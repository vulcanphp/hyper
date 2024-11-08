<?php

/** 
 * NOTE: THIS index.php FILE IS ONLY FOR PHP BUILT-IN DEVELOPMENT
 *       SERVER PURPOSES ONLY, NOT FOR PRODUCTION SERVER.
 *       ON YOUR PRODUCTION SERVER, MAKE SURE YOUR NGINX AND
 *       APACHE SERVER REDIRECT ALL THE HTTP REQUESTS TO THE 'public' FOLDER.
 * 
 * After making sure the server is properly configured, you can remove this file.
 */

// Get the requested URI and decode it
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// Define the path to the public directory
$publicDir = __DIR__ . '/public';

/**
 * Redirect requests with trailing slashes if the resource is not a directory.
 * This handles cases where a trailing slash is present in the URI but the path is not a directory.
 */
if (preg_match('/\/$/', $uri) && !is_dir("$publicDir$uri")) {
    header('Location: ' . rtrim($uri, '/'), true, 301);
    exit();
}

/**
 * Serve the requested resource as-is if it exists in the public directory.
 * This allows direct access to files like images, CSS, and JavaScript.
 */
$filePath = $publicDir . $uri;
if (file_exists($filePath) && is_file($filePath)) {
    // Let the server handle the request
    return false;
}

/**
 * Route all other requests to index.php for further handling.
 * This is typical for single-page applications or when using a front controller pattern.
 */
require "$publicDir/index.php";

