<?php

use hyper\application;
use hyper\request;
use hyper\response;

/**
 * Middlewares.
 *
 * A middleware is a function that has access to the request and response objects.
 * It can be used to modify the request and response, as well as execute code before
 * or after the main application logic.
 *
 * @since 1.0.0
 */

/**
 * CSRF protection middleware.
 *
 * This middleware validates the CSRF token sent in the request. If the token is
 * invalid or missing, it returns a 403 Forbidden response.
 *
 * @param request $request The current request.
 *
 * @return response|null The response when the token is invalid, null otherwise.
 */
function csrfProtectionMiddleware(request $request)
{
    if ($request->method === 'POST') {
        $token = $request->post('_token');
        if (!$token || $token !== application::$app->session->get('_token')) {
            return new response('Invalid CSRF token', 403);
        }
    }
}

/**
 * Authentication middleware.
 *
 * This middleware checks if the request contains an authenticated user.
 * If the user is not authenticated, it returns a 401 Unauthorized response.
 *
 * @param request $request The current request.
 *
 * @return response|null The response if unauthorized, null otherwise.
 */
function authMiddleware(request $request)
{
    if (is_quest()) {
        return new response('Unauthorized', 401);
    }
}
