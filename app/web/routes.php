<?php

use views\home;

return [
    ['path' => '/', 'callback' => [home::class, 'index']],
    ['path' => '/create', 'method' => ['GET', 'POST'], 'callback' => [home::class, 'create']],
    ['path' => '/{id}/edit', 'method' => ['GET', 'POST'], 'callback' => [home::class, 'edit']],
    ['path' => '/{id}/delete', 'callback' => [home::class, 'delete']],
];
