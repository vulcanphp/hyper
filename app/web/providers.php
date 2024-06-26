<?php

use hyper\application;

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

function csrfProtectionProvider(application $app)
{
    if (!$app->session->has('_token')) {
        $app->session->set('_token', bin2hex(random_bytes(32)));
    }
}
