<?php

declare(strict_types=1);

namespace Codices\Service;

use Codices\Import\ImportPreview;
use Codices\Import\ImportPreviewRow;
use Codices\Import\ImportResult;
use Codices\Model\Author;
use Codices\Model\Collection;
use Codices\Model\Format;
use Codices\Model\Genre;
use Codices\Model\Item;
use Codices\Model\Publisher;
use Codices\Model\Series;
use Codices\View\Facade\BookForm;
use Yii;
use yii\db\Connection;

final readonly class ImportService {

    public function __construct(private Connection $db) {}

    public function buildPreviewFromGenericCsv(string $path): ImportPreview {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open uploaded CSV.');
        }
        $delimiter = ';';
        $header = null;
        $rows = [];
        $index = 0;
        $seenIsbns = [];
        $duplicates = 0;

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            // skip empty rows
            if ($data === [null] || (count($data) === 1 && trim((string)$data[0]) === '')) {
                continue;
            }
            if ($header === null) {
                $header = $this->normalizeHeader($data);
                continue;
            }
            $row = $this->rowToAssoc($header, $data);

            $title = trim((string)($row['title'] ?? ''));
            $isbn = $this->normalizeIsbn((string)($row['isbn'] ?? ''));
            $language = $this->nullIfEmpty($row['language'] ?? null);
            $publisher = $this->nullIfEmpty($row['publisher'] ?? null);
            $year = $this->toIntOrNull($row['ano'] ?? ($row['year'] ?? null));
            $series = $this->nullIfEmpty($row['series'] ?? null);
            $order = $this->toIntOrNull($row['order'] ?? null);
            $edition = $this->nullIfEmpty($row['edicao'] ?? ($row['edicao_'] ?? ($row['edicao__'] ?? null)));

            // Authors: main + others
            $first = $this->nullIfEmpty($row['authors_name'] ?? ($row['author_s_name'] ?? null));
            $last = $this->nullIfEmpty($row['authors_last_name'] ?? ($row['author_s_last_name'] ?? null));
            $authors = [];
            $main = trim(($first ? ($first . ' ') : '') . ($last ?? ''));
            if ($main !== '') {
                $authors[] = $main;
            }
            $other = $this->nullIfEmpty($row['authors_other'] ?? null);
            if ($other) {
                // Convert "Surname, Name" -> "Name Surname" if comma present
                $parts = array_map('trim', explode(';', str_replace(['|'], [';'], $other)));
                if (count($parts) === 1) { // maybe comma style list
                    $parts = [trim($other)];
                }
                foreach ($parts as $p) {
                    if ($p === '') continue;
                    if (str_contains($p, ',')) {
                        [$s, $n] = array_map('trim', explode(',', $p, 2));
                        $authors[] = trim($n . ' ' . $s);
                    } else {
                        $authors[] = $p;
                    }
                }
            }

            $genreRaw = $this->nullIfEmpty($row['genre'] ?? null);
            $genres = [];
            if ($genreRaw) {
                foreach (preg_split('/[,&]/', $genreRaw) as $g) {
                    $g = trim($g);
                    if ($g !== '') $genres[] = $g;
                }
                $genres = array_values(array_unique($genres));
            }

            // Type and format
            $typeField = $this->nullIfEmpty($row['type'] ?? null);
            [$itemType, $formatName] = $this->detectTypeAndFormat($typeField);

            $errors = [];
            if ($title === '') {
                $errors[] = 'Missing title';
            }

            $existsInDb = false;
            $dup = false;
            if ($isbn !== null && $isbn !== '') {
                $existsInDb = Item::find()->where(['isbn' => $isbn])->exists();
                if (isset($seenIsbns[$isbn])) {
                    $dup = true;
                }
                $seenIsbns[$isbn] = true;
            }
            if ($dup || $existsInDb) {
                $duplicates++;
            }

            $rows[] = new ImportPreviewRow(
                $index,
                $title,
                $authors,
                $genres,
                $series,
                $order,
                $publisher,
                $year,
                $language,
                $isbn,
                $itemType,
                $formatName,
                $errors,
                $dup,
                $existsInDb,
            );

            $index++;
        }
        fclose($handle);

        $id = bin2hex(random_bytes(8));
        return new ImportPreview($id, $rows, count($rows), $duplicates);
    }

    public function buildPreviewFromCalibreCsv(string $path): ImportPreview {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Unable to open uploaded CSV.');
        }
        $delimiter = ','; // Calibre exports standard CSV with comma delimiter
        $header = null;
        $rows = [];
        $index = 0;
        $seenIsbns = [];
        $duplicates = 0;

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            if ($data === [null] || (count($data) === 1 && trim((string)$data[0]) === '')) {
                continue;
            }
            if ($header === null) {
                $header = $this->normalizeHeader($data);
                continue;
            }
            $row = $this->rowToAssoc($header, $data);

            $title = trim((string)($row['title'] ?? ''));

            // Authors
            $authorsField = (string)($row['authors'] ?? '');
            $authors = [];
            if ($authorsField !== '') {
                // Split on '&', ';', ' and ', ','
                $tmp = preg_split('/\s+and\s+|\s*&\s*|;|,/i', $authorsField) ?: [];
                foreach ($tmp as $p) {
                    $p = trim($p);
                    if ($p === '') continue;
                    if (str_contains($p, ',')) {
                        [$last, $first] = array_map('trim', explode(',', $p, 2));
                        $authors[] = trim($first . ' ' . $last);
                    } else {
                        $authors[] = $p;
                    }
                }
            }
            $authors = array_values(array_unique(array_filter($authors, static fn($a) => $a !== '')));

            // Genres from tags
            $genres = [];
            $tags = $this->nullIfEmpty($row['tags'] ?? null);
            if ($tags) {
                foreach (preg_split('/\s*,\s*/', $tags) as $g) {
                    $g = trim((string)$g);
                    if ($g !== '') $genres[] = $g;
                }
                $genres = array_values(array_unique($genres));
            }

            $series = $this->nullIfEmpty($row['series'] ?? null);
            $order = null;
            $si = $this->nullIfEmpty($row['series_index'] ?? null);
            if ($si !== null && $si !== '') {
                // Calibre can export decimals; cast to int preserving zero if applicable
                $order = (int)round((float)$si);
                if ($order === 0 && (float)$si > 0.0) {
                    $order = (int)floor((float)$si);
                }
            }

            $publisher = $this->nullIfEmpty($row['publisher'] ?? null);

            // Year from pubdate
            $year = null;
            $pubdate = $this->nullIfEmpty($row['pubdate'] ?? null);
            if ($pubdate) {
                if (preg_match('/(\d{4})/', $pubdate, $m)) {
                    $year = (int)$m[1];
                }
            }

            // Language
            $language = $this->nullIfEmpty($row['languages'] ?? null);
            if ($language !== null) {
                $lc = strtolower(trim($language));
                $map = ['eng' => 'English', 'en' => 'English', 'por' => 'Portuguese', 'pt' => 'Portuguese', 'spa' => 'Spanish', 'es' => 'Spanish'];
                $language = $map[$lc] ?? $language;
            }

            // ISBN: either ISBN column or within Identifiers
            $isbn = $this->normalizeIsbn($row['isbn'] ?? null);
            if ($isbn === null) {
                $ident = $this->nullIfEmpty($row['identifiers'] ?? null);
                if ($ident) {
                    if (preg_match('/isbn[:=\s]*([0-9xX\-\s]+)/', $ident, $m)) {
                        $isbn = $this->normalizeIsbn($m[1]);
                    } elseif (preg_match('/([0-9]{9,13}[xX]?)/', $ident, $m)) {
                        $isbn = $this->normalizeIsbn($m[1]);
                    }
                }
            }

            // Determine type/format from formats column
            $formatName = null; $itemType = Item::TYPE_PAPER;
            $formats = $this->nullIfEmpty($row['formats'] ?? null);
            if ($formats) {
                $parts = preg_split('/\s*,\s*/', $formats) ?: [];
                $formatName = $parts[0] ?? null;
                [$itemType, $tmpFormat] = $this->detectTypeAndFormat($formatName);
                if ($tmpFormat !== null) { $formatName = $tmpFormat; }
            }

            $errors = [];
            if ($title === '') {
                $errors[] = 'Missing title';
            }

            $existsInDb = false; $dup = false;
            if ($isbn !== null && $isbn !== '') {
                $existsInDb = Item::find()->where(['isbn' => $isbn])->exists();
                if (isset($seenIsbns[$isbn])) { $dup = true; }
                $seenIsbns[$isbn] = true;
            }
            if ($dup || $existsInDb) { $duplicates++; }

            $rows[] = new ImportPreviewRow(
                $index,
                $title,
                $authors,
                $genres,
                $series,
                $order,
                $publisher,
                $year,
                $language,
                $isbn,
                $itemType,
                $formatName,
                $errors,
                $dup,
                $existsInDb,
            );
            $index++;
        }
        fclose($handle);

        $id = bin2hex(random_bytes(8));
        return new ImportPreview($id, $rows, count($rows), $duplicates);
    }

    public function buildPreviewFromCodicesJson(string $path): ImportPreview {
        $json = @file_get_contents($path);
        if ($json === false) {
            throw new \RuntimeException('Unable to open uploaded JSON.');
        }
        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new \RuntimeException('Invalid JSON payload.');
        }
        // Accept either array of items or { items: [...] }
        if (isset($data['items']) && is_array($data['items'])) {
            $items = $data['items'];
        } else {
            $items = $data;
        }

        $rows = [];
        $index = 0;
        $seenIsbns = [];
        $duplicates = 0;

        foreach ($items as $it) {
            if (!is_array($it)) continue;

            $title = trim((string)($it['title'] ?? ''));
            $authors = [];
            if (!empty($it['authors']) && is_array($it['authors'])) {
                foreach ($it['authors'] as $a) {
                    $a = trim((string)$a);
                    if ($a !== '') $authors[] = $a;
                }
                $authors = array_values(array_unique($authors));
            }

            $genres = [];
            if (!empty($it['genres']) && is_array($it['genres'])) {
                foreach ($it['genres'] as $g) {
                    $g = trim((string)$g);
                    if ($g !== '') $genres[] = $g;
                }
                $genres = array_values(array_unique($genres));
            }

            $series = null; $order = null;
            if (!empty($it['series'])) {
                if (is_array($it['series'])) {
                    $series = $this->nullIfEmpty($it['series']['name'] ?? null);
                    $order = $this->toIntOrNull($it['series']['order'] ?? null);
                } else {
                    $series = $this->nullIfEmpty((string)$it['series']);
                    $order = $this->toIntOrNull($it['orderInSeries'] ?? ($it['order'] ?? null));
                }
            }

            $publisher = $this->nullIfEmpty($it['publisher'] ?? ($it['publisherName'] ?? null));

            $year = $this->toIntOrNull($it['publishYear'] ?? ($it['year'] ?? null));
            if ($year === null && isset($it['publishDate'])) {
                $pd = (string)$it['publishDate'];
                if (preg_match('/(\d{4})/', $pd, $m)) $year = (int)$m[1];
            }

            $language = $this->nullIfEmpty($it['language'] ?? null);

            $isbn = $this->normalizeIsbn($it['isbn'] ?? null);

            $itemType = Item::TYPE_PAPER;
            $formatName = $this->nullIfEmpty($it['format'] ?? null);
            if (!empty($it['type'])) {
                $t = strtolower((string)$it['type']);
                if (in_array($t, [Item::TYPE_PAPER, Item::TYPE_EBOOK, Item::TYPE_AUDIO], true)) {
                    $itemType = $t;
                } else {
                    [$itemType, $tmpFormat] = $this->detectTypeAndFormat($t);
                    if ($formatName === null) $formatName = $tmpFormat;
                }
            } elseif ($formatName !== null) {
                [$itemType, $tmpFormat] = $this->detectTypeAndFormat($formatName);
                if ($tmpFormat !== null) $formatName = $tmpFormat;
            }

            $errors = [];
            if ($title === '') { $errors[] = 'Missing title'; }

            $existsInDb = false; $dup = false;
            if ($isbn !== null && $isbn !== '') {
                $existsInDb = Item::find()->where(['isbn' => $isbn])->exists();
                if (isset($seenIsbns[$isbn])) { $dup = true; }
                $seenIsbns[$isbn] = true;
            }
            if ($dup || $existsInDb) { $duplicates++; }

            $rows[] = new ImportPreviewRow(
                $index,
                $title,
                $authors,
                $genres,
                $series,
                $order,
                $publisher,
                $year,
                $language,
                $isbn,
                $itemType,
                $formatName,
                $errors,
                $dup,
                $existsInDb,
            );
            $index++;
        }

        $id = bin2hex(random_bytes(8));
        return new ImportPreview($id, $rows, count($rows), $duplicates);
    }

    /**
     * @param ImportPreview $preview
     * @param int[] $selectedIndexes
     */
    public function importFromPreview(ImportPreview $preview, array $selectedIndexes, int $ownerId): ImportResult {
        $result = new ImportResult();
        $selected = array_flip(array_map('intval', $selectedIndexes));

        foreach ($preview->rows as $row) {
            if (!isset($selected[$row->index])) {
                $result->skipped++;
                continue;
            }
            if ($row->title === '' || ($row->isbn !== null && $row->isbn !== '' && Item::find()->where(['isbn' => $row->isbn])->exists())) {
                $result->skipped++;
                continue;
            }

            $tx = $this->db->beginTransaction();
            try {
                $form = new BookForm();
                $form->title = $row->title;
                $form->isbn = $row->isbn;
                $form->language = $row->language;
                $form->type = $row->itemType;
                $form->format = $row->formatName;
                $form->publishYear = $row->year;
                $form->orderInSeries = $row->orderInSeries;

                // Resolve relations
                $form->publisherId = $this->resolvePublisherId($row->publisher, $ownerId);
                $form->seriesId = $this->resolveSeriesId($row->series, $ownerId);
                $form->authors = $this->resolveAuthorIds($row->authors, $ownerId);
                $form->genres = $this->resolveGenreIds($row->genres, $ownerId);

                // Ensure format record exists (optional, for consistency)
                if ($row->formatName) {
                    $this->ensureFormat($row->itemType, $row->formatName, $ownerId);
                }

                // Create the item
                /** @var ItemService $items */
                $items = Yii::$container->get(ItemService::class);
                $items->create($form, $ownerId);

                $tx->commit();
                $result->imported++;
            } catch (\Throwable $e) {
                $tx->rollBack();
                $result->errors[] = sprintf('#%d %s (%s)', $row->index, $row->title, $e->getMessage());
            }
        }

        return $result;
    }

    /** @param string[] $names */
    private function resolveAuthorIds(array $names, int $ownerId): array {
        $ids = [];
        foreach ($names as $n) {
            $n = trim($n);
            if ($n === '') continue;
            $author = Author::find()->where(['name' => $n])->one();
            if ($author === null) {
                $author = new Author();
                $author->name = $n;
                $author->ownedById = $ownerId;
                $author->save();
            }
            $ids[] = (int)$author->id;
        }
        return array_values(array_unique($ids));
    }

    /** @param string[] $names */
    private function resolveGenreIds(array $names, int $ownerId): array {
        $ids = [];
        foreach ($names as $n) {
            $n = trim($n);
            if ($n === '') continue;
            $genre = Genre::find()->where(['name' => $n])->one();
            if ($genre === null) {
                $genre = new Genre();
                $genre->name = $n;
                $genre->ownedById = $ownerId;
                $genre->save();
            }
            $ids[] = (int)$genre->id;
        }
        return array_values(array_unique($ids));
    }

    private function resolveSeriesId(?string $name, int $ownerId): ?int {
        $name = $this->nullIfEmpty($name);
        if ($name === null) return null;
        $series = Series::find()->where(['name' => $name])->one();
        if ($series === null) {
            $series = new Series();
            $series->name = $name;
            $series->ownedById = $ownerId;
            $series->save();
        }
        return (int)$series->id;
    }

    private function resolvePublisherId(?string $name, int $ownerId): ?int {
        $name = $this->nullIfEmpty($name);
        if ($name === null) return null;
        $publisher = Publisher::find()->where(['name' => $name])->one();
        if ($publisher === null) {
            $publisher = new Publisher();
            $publisher->name = $name;
            $publisher->ownedById = $ownerId;
            $publisher->save();
        }
        return (int)$publisher->id;
    }

    private function resolveCollectionId(?string $name, int $ownerId): ?int {
        $name = $this->nullIfEmpty($name);
        if ($name === null) return null;
        $collection = Collection::find()->where(['name' => $name])->one();
        if ($collection === null) {
            $collection = new Collection();
            $collection->name = $name;
            $collection->ownedById = $ownerId;
            $collection->save();
        }
        return (int)$collection->id;
    }

    private function ensureFormat(string $type, string $name, int $ownerId): void {
        $fmt = Format::findOne(['type' => $type, 'name' => $name, 'ownedById' => $ownerId]);
        if ($fmt === null) {
            $fmt = new Format();
            $fmt->type = $type;
            $fmt->name = $name;
            $fmt->ownedById = $ownerId;
            $fmt->save();
        }
    }

    /**
     * @param string[] $header
     * @return array<int, string>
     */
    private function normalizeHeader(array $header): array {
        $out = [];
        foreach ($header as $h) {
            $key = $this->normalizeKey((string)$h);
            $out[] = $key;
        }
        return $out;
    }

    /**
     * @param array<int, string> $header
     * @param array<int, string|null> $row
     * @return array<string, string|null>
     */
    private function rowToAssoc(array $header, array $row): array {
        $assoc = [];
        foreach ($header as $i => $key) {
            $assoc[$key] = $row[$i] ?? null;
        }
        return $assoc;
    }

    private function normalizeKey(string $s): string {
        $s = trim($s);
        $s = $this->stripAccents(mb_strtolower($s));
        $s = str_replace(["\u{2019}", "'"], '_', $s);
        $s = preg_replace('/[^a-z0-9]+/u', '_', $s) ?? $s;
        $s = trim($s, '_');
        // Map to expected keys
        $map = [
            'owner' => 'owner',
            'authors_last_name' => 'authors_last_name',
            'author_s_last_name' => 'authors_last_name',
            'authors_name' => 'authors_name',
            'author_s_name' => 'authors_name',
            'series' => 'series',
            'order' => 'order',
            'genre' => 'genre',
            'title' => 'title',
            'isbn' => 'isbn',
            'language' => 'language',
            'type' => 'type',
            'authors_other' => 'authors_other',
            'notes' => 'notes',
            'publisher' => 'publisher',
            'ano' => 'ano',
            'original_language' => 'original_language',
            'edicao' => 'edicao',
        ];
        return $map[$s] ?? $s;
    }

    private function stripAccents(string $str): string {
        $replacements = [
            'á' => 'a','à' => 'a','â' => 'a','ã' => 'a','ä' => 'a',
            'é' => 'e','è' => 'e','ê' => 'e','ë' => 'e',
            'í' => 'i','ì' => 'i','î' => 'i','ï' => 'i',
            'ó' => 'o','ò' => 'o','ô' => 'o','õ' => 'o','ö' => 'o',
            'ú' => 'u','ù' => 'u','û' => 'u','ü' => 'u',
            'ç' => 'c',
            'Á' => 'a','À' => 'a','Â' => 'a','Ã' => 'a','Ä' => 'a',
            'É' => 'e','È' => 'e','Ê' => 'e','Ë' => 'e',
            'Í' => 'i','Ì' => 'i','Î' => 'i','Ï' => 'i',
            'Ó' => 'o','Ò' => 'o','Ô' => 'o','Õ' => 'o','Ö' => 'o',
            'Ú' => 'u','Ù' => 'u','Û' => 'u','Ü' => 'u',
            'Ç' => 'c',
        ];
        return strtr($str, $replacements);
    }

    private function nullIfEmpty(?string $value): ?string {
        $value = $value !== null ? trim($value) : null;
        return $value === '' ? null : $value;
    }

    private function toIntOrNull($value): ?int {
        if ($value === null || $value === '') return null;
        $i = (int)$value;
        return $i !== 0 ? $i : null;
    }

    private function normalizeIsbn(?string $isbn): ?string {
        if ($isbn === null) return null;
        $isbn = trim($isbn);
        if ($isbn === '') return null;
        $isbn = preg_replace('/[^0-9Xx]/', '', $isbn) ?? $isbn;
        return strtoupper($isbn);
    }

    /** @return array{0: string, 1: ?string} */
    private function detectTypeAndFormat(?string $typeField): array {
        $itemType = Item::TYPE_PAPER;
        $formatName = null;
        if ($typeField !== null) {
            $t = strtolower(trim($typeField));
            $formatName = $typeField;
            $ebook = ['epub','pdf','mobi','kindle','ebook','e-book'];
            $audio = ['mp3','audiobook','audio','cd','audible'];
            $paper = ['paperback','hardcover','hardback','trade paperback','pocket'];
            foreach ($ebook as $v) { if (str_contains($t, $v)) { $itemType = Item::TYPE_EBOOK; break; } }
            foreach ($audio as $v) { if (str_contains($t, $v)) { $itemType = Item::TYPE_AUDIO; break; } }
            foreach ($paper as $v) { if (str_contains($t, $v)) { $itemType = Item::TYPE_PAPER; break; } }
        }
        return [$itemType, $formatName];
    }
}
