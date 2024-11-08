<?php

/**
 * Entry point for the application.
 *
 * This file is the entry point for the entire application. It sets up
 * the application environment, loads the Composer autoloader, and
 * runs the bootstrap process.
 */

// define application root directory path.
define('ROOT_DIR', dirname(__DIR__));

// include composer autoload
require __DIR__ . '/../vendor/autoload.php';

/**
 * Runs the bootstrap process.
 *
 * This function is responsible for loading the application's
 * bootstrap file, which sets up the application environment and
 * runs the application.
 *
 * @return void
 */
(require __DIR__ . '/../app/bootstrap.php')
    ->run();