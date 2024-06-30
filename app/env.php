<?php

return [
    'debug' => false,
    'secret' => 'c52f493a81826ba866af6bb66a8c67802caf1e1d',
    'database' => [
        'driver' => 'sqlite',
        'file' => __DIR__ . '/../sqlite.db'
    ],
    'lang' => 'en',
    'lang_dir' => __DIR__ . '/../public/i18n',
    'tmp_dir' => __DIR__ . '/../public/tmp',
    'upload_dir' => __DIR__ . '/../public/uploads',
    'media_url' => '/public/uploads/',
    'asset_url' => '/public/resources/',
    'admin' => __DIR__ . '/web/admin.php',
];
