<?php

use core\application;

function csrfProtectionProvider(application $app)
{
    // set csrf token
    if (!$app->session->has('_token')) {
        $app->session->set('_token', bin2hex(random_bytes(32)));
    }
}
