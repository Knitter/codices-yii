<?php

namespace codices\assets;

use Yii;
use yii\web\AssetBundle;

class CodicesAsset extends AssetBundle {

    public $sourcePath = '@prod-assets';
    public $css = ['css/codices.bundle.css'];
    public $js = ['js/codices.bundle.js'];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap5\BootstrapAsset',
    ];

    /**
     * @param array $config
     */
    public function __construct(array $config = []) {
        parent::__construct($config);

        if (Yii::$app->request->isAjax || Yii::$app->request->isPjax) {
            $this->js = [];
            $this->css = [];
            return;
        }

        if (YII_DEBUG) {
            $this->sourcePath = '@dev-assets';
            $this->css = [
                'fonts/inter.css',
                'css/tabler.min.css',
                'css/tabler-flags.min.css',
                'css/tabler-payments.min.css',
                'css/tabler-social.min.css',
                'css/tabler-vendors.min.css'
            ];

            $this->js = [
                'js/tabler.esm.min.js'
            ];
        }
    }
}
