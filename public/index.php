<?php

// define application root directory path.
define('ROOT_DIR', dirname(__DIR__));

// load composer autoload.php
require __DIR__ . '/../vendor/autoload.php';

// load bootstrap application to run
(require __DIR__ . '/../app/bootstrap.php')
    ->run();
