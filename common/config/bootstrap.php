<?php
$parent = dirname(__DIR__, 2);

Yii::setAlias('@container', $parent);
Yii::setAlias('@bin', $parent . '/bin');
Yii::setAlias('@bin-runtime', $parent . '/bin/runtime');

Yii::setAlias('@common', $parent . '/common');
Yii::setAlias('@console', $parent . '/console');
Yii::setAlias('@public', $parent . '/public');
Yii::setAlias('@codices', $parent . '/codices');

Yii::setAlias('@prod-assets', $parent . '/codices/assets/assets');
Yii::setAlias('@dev-assets', $parent . '/codices/assets/src');
