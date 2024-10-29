<?php

use hyper\application;

/**
 * This file contains the service providers for the web application.
 *
 * A service provider is a class that adds functionality to the
 * application. The service providers in this file are only loaded
 * when the application is running in web mode.
 *
 * @package hyper
 * @author Shahin Moyshan <shahin.moyshan2@gmail.com>
 * @since 1.0.0
 */

/**
 * Checks the current system load and returns a 503 if it's too high.
 *
 * This service provider is meant to be used to prevent the server from
 * being overloaded by too many requests. It does this by checking the
 * current system load and returning a 503 if it's above a certain
 * threshold (0.90). If the system is too busy, it will return a 503
 * header and die with a message indicating that the server is too
 * busy.
 *
 * This provider can be enabled by adding "checkSysLoadProvider" line in the
 * app/bootstrap.php file.
 */
function checkSysLoadProvider()
{
    if (function_exists('sys_getloadavg')) {
        $load = sys_getloadavg();
        if ($load[0] > 0.90) {
            header('HTTP/1.1 503 Too busy, try again later');
            die('Server too busy. Please try again later.');
        }
    }
}

/**
 * CSRF protection service provider.
 *
 * This service provider ensures that the application has a CSRF token
 * in the session. If the token does not exist, it generates a new one
 * using a 32-byte random string and sets it in the session. This token
 * is used to protect against cross-site request forgery attacks.
 *
 * @param application $app The application instance.
 */
function csrfProtectionProvider(application $app)
{
    if (!$app->session->has('_token')) {
        $app->session->set('_token', bin2hex(random_bytes(32)));
    }
}
