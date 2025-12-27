<?php

declare(strict_types=1);

namespace Codices\View\Facade;

use yii\base\Model;
use yii\web\UploadedFile;

final class ImportUploadForm extends Model {

    //TODO: Move to helper
    public const string FORMAT_GENERIC_CSV = 'generic-csv';
    //TODO: Move to helper
    public const string FORMAT_CODICES_JSON = 'codices-json';
    //TODO: Move to helper
    public const string FORMAT_CALIBRE_CSV = 'calibre-csv';

    public string $format = self::FORMAT_GENERIC_CSV;
    /** @var UploadedFile|null */
    public ?UploadedFile $file = null;

    public function rules(): array {
        return [
            [['format'], 'required'],
            [['format'], 'in', 'range' => [self::FORMAT_GENERIC_CSV, self::FORMAT_CODICES_JSON, self::FORMAT_CALIBRE_CSV]],
            [
                ['file'], 'file', 'extensions' => ['csv'], 'checkExtensionByMimeType' => false, 'skipOnEmpty' => false,
                'when' => fn() => in_array($this->format, [self::FORMAT_GENERIC_CSV, self::FORMAT_CALIBRE_CSV], true)
            ],
            [
                ['file'], 'file', 'extensions' => ['json'], 'checkExtensionByMimeType' => false, 'skipOnEmpty' => false,
                'when' => fn() => $this->format === self::FORMAT_CODICES_JSON
            ],
        ];
    }
}
