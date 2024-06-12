<?php

use core\application;

require __DIR__ . '/vendor/autoload.php';

$app = new application(
    path: __DIR__,
    routesPath: __DIR__ . '/app/web/routes.php',
    requirePath: [
        __DIR__ . '/app/web/providers.php',
        __DIR__ . '/app/web/middlewares.php',
    ],
    providers: ['csrfProtectionProvider'],
    middlewares: ['csrfProtectionMiddleware'],
    env: [
        'debug' => true,
        'database' => [
            'driver' => 'sqlite',
            'file' => __DIR__ . '/sqlite.db'
        ]
    ],
);

$app->run();
