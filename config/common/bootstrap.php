<?php

$parent = dirname(__DIR__, 2);

Yii::setAlias('@container', $parent);
Yii::setAlias('@config', $parent . '/config');
Yii::setAlias('@src', $parent . '/src');
//
Yii::setAlias('@messages', $parent . '/resources/messages');
Yii::setAlias('@assets', $parent . '/resources/assets');
//
Yii::setAlias('@public', $parent . '/public');
Yii::setAlias('@tests', $parent . '/tests');
//
Yii::setAlias('@App', $parent . '/src');
