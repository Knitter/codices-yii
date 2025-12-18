<?php

declare(strict_types=1);

namespace Codices\View\Facade;

use yii\base\Model;
use yii\web\UploadedFile;

final class ImportUploadForm extends Model {

    public const FORMAT_GENERIC_CSV = 'generic-csv';
    public const FORMAT_CODICES_JSON = 'codices-json';
    public const FORMAT_CALIBRE_CSV = 'calibre-csv';

    public string $format = self::FORMAT_GENERIC_CSV;
    /** @var UploadedFile|null */
    public ?UploadedFile $file = null;

    public function rules(): array {
        return [
            [['format'], 'required'],
            ['format', 'in', 'range' => [self::FORMAT_GENERIC_CSV, self::FORMAT_CODICES_JSON, self::FORMAT_CALIBRE_CSV]],
            // CSV upload (Generic CSV or Calibre CSV)
            [
                ['file'],
                'file',
                'extensions' => ['csv'],
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => false,
                'when' => function () {
                    return in_array($this->format, [self::FORMAT_GENERIC_CSV, self::FORMAT_CALIBRE_CSV], true);
                }
            ],
            // JSON upload (Codices JSON)
            [
                ['file'],
                'file',
                'extensions' => ['json'],
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => false,
                'when' => function () {
                    return $this->format === self::FORMAT_CODICES_JSON;
                }
            ],
        ];
    }
}
