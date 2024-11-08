<?php

use hyper\application;
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