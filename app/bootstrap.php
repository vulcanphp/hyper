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
);
