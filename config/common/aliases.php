<?php

declare(strict_types=1);

return [
    '@root' => dirname(__DIR__, 4),
    '@src' => '@root/src',
    '@runtime' => '@root/runtime',
    '@wwwroot' => '@root/wwwroot',
    '@vendor' => '@root/vendor',
    //
    '@baseUrl' => '/',
    '@assets' => '@wwwroot/assets',
    '@assetsUrl' => '@baseUrl/assets',
    '@messages' => '@resources/messages',
    '@resources' => '@src/resources',
    '@views' => '@src/View/UI',
    '@layout' => '@views/layout',
    '@migrations' => '@src/migrations',
];
