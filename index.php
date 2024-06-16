<?php

/** 
 * NOTE: THIS index.php FILE ONLY FOR PHP BUILT IN DEVELOPMENT
 *       SEVER PURPOSE ONLY, NOT FOR PRODUCTION SERVER.
 *       IN YOUR PRODUCTION SERVER MAKE SURE YOU NGINX AND
 *       APACHE SERVER REDIRECT ALL THE HTTP REQUEST TO 'public' folder.
 */

// Get the requested URI
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Define the path to the public directory
$publicDir = __DIR__ . '/public';

// Redirect trailing slashes if not a directory
if (preg_match('/\/$/', $uri) && !is_dir($publicDir . $uri)) {
    header('Location: ' . rtrim($uri, '/'), true, 301);
    exit();
}

// Serve the requested resource as-is if it exists in the public directory
$filePath = $publicDir . $uri;
if (file_exists($filePath) && is_file($filePath)) {
    return false; // Let the server handle it
}

// Otherwise, route the request to index.php
require $publicDir . '/index.php';
