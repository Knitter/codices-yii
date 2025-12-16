<?php

declare(strict_types=1);

/** @phpstan-var string[] $commonComponents */
$commonComponents = require dirname(__DIR__) . '/common/components.php';

$config = [];
$config += $commonComponents;
return $config;
