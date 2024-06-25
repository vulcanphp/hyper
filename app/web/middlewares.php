<?php

use hyper\application;
use hyper\request;
use hyper\response;

function csrfProtectionMiddleware(request $request)
{
    if ($request->method === 'POST') {
        $token = $request->post('_token');
        if (!$token || $token !== application::$app->session->get('_token')) {
            return new response('Invalid CSRF token', 403);
        }
    }
}

function authMiddleware(request $request)
{
    if (!isset($request->user)) {
        return new response('Unauthorized', 401);
    }
}
