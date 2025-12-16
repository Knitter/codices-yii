<?php

/*
 * Copyright (c) 2025 Sérgio Lopes. All rights reserved.
 * Licensed under the MIT license. See LICENSE file in the project root for details.
 */

declare(strict_types=1);

$rootDir = dirname(__DIR__, 2);
Yii::setAlias('@root', $rootDir);

Yii::setAlias('@src', $rootDir . '/src');
Yii::setAlias('@wwwroot', $rootDir . '/wwwroot');

Yii::setAlias('@assets', $rootDir . '/wwwroot/assets');
Yii::setAlias('@resources', $rootDir . '/src/resources');
Yii::setAlias('@messages', $rootDir . '/src/resources/messages');
Yii::setAlias('@views', $rootDir . '/src/app/View/Template');
Yii::setAlias('@layout', $rootDir . '/src/app/View/Layout');
Yii::setAlias('@migrations', $rootDir . '/src/migrations');
Yii::setAlias('@data', $rootDir . '/data');

// FIXING yii command for console apps trying to use an "alias" that doesn't exist
Yii::setAlias('@Codices', $rootDir . '/src/app');
