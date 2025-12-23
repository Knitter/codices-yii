<?php

declare(strict_types=1);

namespace Codices\Import;

final class ImportPreview {

    /** @param ImportPreviewRow[] $rows */
    public function __construct(
        public string $id,
        public array  $rows,
        public int    $total,
        public int    $duplicates
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'rows' => array_map(static fn(ImportPreviewRow $r) => $r->toArray(), $this->rows),
            'total' => $this->total,
            'duplicates' => $this->duplicates,
        ];
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self {
        $rows = [];
        foreach (($data['rows'] ?? []) as $r) {
            $rows[] = ImportPreviewRow::fromArray($r);
        }

        return new self((string)$data['id'], $rows, (int)($data['total'] ?? count($rows)), (int)($data['duplicates'] ?? 0));
    }
}
