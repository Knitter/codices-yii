<?php

declare(strict_types=1);

$rootDir = dirname(__DIR__, 2);
Yii::setAlias('@root', $rootDir);

Yii::setAlias('@src', $rootDir . '/src');
Yii::setAlias('@wwwroot', $rootDir . '/wwwroot');

//Yii::setAlias('@baseUrl' , '/');
//Yii::setAlias('@assetsUrl',  '@baseUrl/assets');

Yii::setAlias('@assets', $rootDir . '/wwwroot/assets');
Yii::setAlias('@resources', $rootDir . '/src/resources');
Yii::setAlias('@messages', $rootDir . '/src/resources/messages');
Yii::setAlias('@views', $rootDir . '/src/app/View/UI');
Yii::setAlias('@layout', $rootDir . '/src/app/View/Layout');
Yii::setAlias('@migrations', $rootDir . 'src/migrations');
