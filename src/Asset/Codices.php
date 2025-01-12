<?php

namespace App\Asset;

//use Yii;
//use yii\web\AssetBundle;

final class Codices extends AssetBundle {

    //public ?string $basePath = '@assets';
    //public ?string $baseUrl = '@assetsUrl';
    public ?string $sourcePath = '@resources/assets';
    //public array $css = ['site.css'];

    //public $css = ['css/codices.bundle.css'];
    //public $js = ['js/codices.bundle.js'];
    //public $depends = [
    //    'yii\web\YiiAsset',
    //    //'yii\bootstrap5\BootstrapAsset',
    //];

    public function __construct(array $config = []) {
        parent::__construct($config);

        //if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
        //    $this->js = [];
        //    $this->css = [];
        //    return;
        //}
    }
}
