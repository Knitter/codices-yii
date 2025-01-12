<?php

$parent = dirname(__DIR__);

Yii::setAlias('@container', $parent);
//-
Yii::setAlias('@config', $parent . '/config');
//
Yii::setAlias('@app', $parent . '/src');
Yii::setAlias('@App', $parent . '/src');
//
Yii::setAlias('@messages', $parent . '/resources/messages');
Yii::setAlias('@public', $parent . '/public');
Yii::setAlias('@tests', $parent . '/tests');
//
Yii::setAlias('@assets', $parent . '/resources/assets');
