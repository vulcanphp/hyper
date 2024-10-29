<?php

/**
 * Environment variables
 *
 * This file contains the environment variables for the application.
 *
 * @var array
 */
return [
    /**
     * Debug mode
     *
     * Set to true to enable debug mode.
     *
     * @var bool
     */
    'debug' => false,

    /**
     * Secret key
     *
     * Secret key used for encryption and decryption.
     *
     * @var string
     */
    'secret' => 'c52f493a81826ba866af6bb66a8c67802caf1e1d',

    /**
     * Language
     *
     * Language used for the application.
     *
     * @var string
     */
    'lang' => 'en',

    /**
     * Database configuration
     *
     * Configuration for the database.
     *
     * @var array
     */
    'database' => [
        /**
         * Driver
         *
         * Driver used for the database.
         *
         * @var string
         */
        'driver' => 'sqlite',

        /**
         * File
         *
         * Path to the sqlite database file.
         *
         * @var string
         */
        'file' => __DIR__ . '/sqlite.db',
    ],
];

