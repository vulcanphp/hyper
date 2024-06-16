<?php

use core\application;

return new application(
    path: __DIR__,
    routesPath: __DIR__ . '/web/routes.php',
    requirePath: [
        __DIR__ . '/web/providers.php',
        __DIR__ . '/web/middlewares.php',
    ],
    providers: ['checkSysLoadProvider', 'csrfProtectionProvider'],
    middlewares: ['csrfProtectionMiddleware'],
    env: [
        'debug' => true,
        'secret' => 'c52f493a81826ba866af6bb66a8c67802caf1e1d',
        'database' => [
            'driver' => 'sqlite',
            'file' => __DIR__ . '/../sqlite.db'
        ],
        'lang' => 'bn',
        'lang_dir' => __DIR__ . '/../public/i18n',
        'tmp_dir' => __DIR__ . '/../public/tmp',
        'upload_dir' => __DIR__ . '/../public/uploads',
        'media_url' => '/public/uploads/',
        'asset_url' => '/public/resources/',
    ],
);
