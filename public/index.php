<?php

use Dotenv\Dotenv;

$base = dirname(__DIR__);
require_once $base . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable($base.'/config/env');
$dotenv->load();

$_ENV['YII_ENV'] = empty($_ENV['YII_ENV']) ? null : $_ENV['YII_ENV'];
$_SERVER['YII_ENV'] = $_ENV['YII_ENV'];

$_ENV['YII_DEBUG'] = filter_var(
    !empty($_ENV['YII_DEBUG']) ? $_ENV['YII_DEBUG'] : true,
    FILTER_VALIDATE_BOOLEAN,
    FILTER_NULL_ON_FAILURE
) ?? true;
$_SERVER['YII_DEBUG'] = $_ENV['YII_DEBUG'];

//if ($environment === 'development' || $environment === 'qa') {
//    defined('YII_DEBUG') or define('YII_DEBUG', true);
//    defined('YII_ENV') or define('YII_ENV', 'dev');
//
//    if ($environment === 'qa') {
//        defined('ERP_QA_ENV') or define('ERP_QA_ENV', true);
//    }
//} else {
//    if ($environment === 'test') {
//        defined('YII_DEBUG') or define('YII_DEBUG', true);
//        defined('YII_ENV') or define('YII_ENV', 'test');
//    } else {
//        defined('YII_DEBUG') or define('YII_DEBUG', false);
//        defined('YII_ENV') or define('YII_ENV', 'prod');
//    }
//}
//
require $base . '/vendor/yiisoft/yii2/Yii.php';
require $base . '/config/common/bootstrap.php';

$config = yii\helpers\ArrayHelper::merge(
    require $base . '/config/common/main.php',
    require $base . '/config/web/web.php'
);

new App\Component\Application($config)->run();
