<?php

use hyper\application;
use hyper\tracer;
use hyper\translator;

/**
 * This file contains the service providers for the web application.
 *
 * A service provider is a class that adds functionality to the
 * application. The service providers in this file are only loaded
 * when the application is running in web mode.
 *
 * @since 1.0.0
 */

/**
 * Error Tracer service provider.
 *
 * If the application is in debug mode, this provider enables the error
 * tracer to log errors and exceptions to the console.
 *
 * @param application $app
 *   The application instance.
 *
 * @return void
 */
function errorTracerProvider(application $app)
{
    if ($app->env['debug']) {
        tracer::trace();
    }
}

/**
 * Translator service provider.
 *
 * Registers the translator service in the application container.
 *
 * @param application $app
 *   The application instance.
 *
 * @return void
 */
function translatorProvider(application $app)
{
    $app->translator = new translator($app->env['lang'], $app->env['lang_dir']);
}