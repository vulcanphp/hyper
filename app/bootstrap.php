<?php

use admin\admin;
use hyper\application;

return new application(
    path: __DIR__,
    routesPath: __DIR__ . '/web/routes.php',
    requirePath: [
        __DIR__ . '/web/providers.php',
        __DIR__ . '/web/middlewares.php',
    ],
    providers: ['checkSysLoadProvider', 'csrfProtectionProvider', [new admin(), 'setup']],
    middlewares: ['csrfProtectionMiddleware'],
    env: [
        'lang_dir' => __DIR__ . '/../public/i18n',
        'tmp_dir' => __DIR__ . '/../public/tmp',
        'upload_dir' => __DIR__ . '/../public/uploads',
        'admin' => __DIR__ . '/web/admin.php',
        'media_url' => '/public/uploads/',
        'asset_url' => '/public/resources/',
    ]
);
