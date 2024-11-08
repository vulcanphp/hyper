<?php

/**
 * @file
 * Main application bootstrap file.
 */

use hyper\application;

/**
 * Creates a new instance of the application.
 *
 * @param string $path
 *   The path to the application root directory.
 * @param string $routesPath
 *   The path to the routes file.
 * @param string[] $requirePath
 *   An array of paths to require before loading the routes.
 * @param string[] $providers
 *   An array of providers to register.
 * @param string[] $middlewares
 *   An array of middlewares to register.
 * @param array $env
 *   An array of environment variables.
 *
 * @return application
 *   A new instance of the application.
 */
return new application(
    path: __DIR__,
    routesPath: __DIR__ . '/web/routes.php',
    requirePath: [
        __DIR__ . '/web/providers.php',
        __DIR__ . '/web/middlewares.php',
    ],
    providers: ['translatorProvider'],
    middlewares: ['csrfProtectionMiddleware'],
    env: [
        'lang_dir' => __DIR__ . '/i18n',
        'tmp_dir' => __DIR__ . '/tmp',
        'upload_dir' => __DIR__ . '/../public/uploads',
        'media_url' => '/uploads/',
        'asset_url' => '/resources/',
        'lang' => 'en',
        'database' => [
            'driver' => 'sqlite',
            'file' => __DIR__ . '/sqlite.db',
        ],
    ]
);
