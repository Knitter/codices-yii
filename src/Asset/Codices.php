<?php

namespace App\Asset;

use Yii;
use yii\web\AssetBundle;

final class Codices extends AssetBundle {

    public $sourcePath = '@resources/assets';
    //public $css = [];
    //public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        //    //'yii\bootstrap5\BootstrapAsset',
    ];

    public function __construct(array $config = []) {
        parent::__construct($config);
        if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
            $this->js = [];
            $this->css = [];
            return;
        }
    }
}
