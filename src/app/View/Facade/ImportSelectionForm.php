<?php

declare(strict_types=1);

namespace Codices\View\Facade;

use yii\base\Model;

final class ImportSelectionForm extends Model {

    public string $importId = '';
    /** @var int[] */
    public array $selected = [];

    public function rules(): array {
        return [
            [['importId'], 'required'],
            ['importId', 'string', 'min' => 8, 'max' => 64],
            ['selected', 'each', 'rule' => ['integer']],
        ];
    }
}
