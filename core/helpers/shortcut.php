<?php

use core\application;
use core\database;
use core\query;
use core\request;
use core\response;
use core\router;
use core\template;
use core\utils\cache;
use core\utils\collect;
use core\utils\session;

// Foundation Shortcut
function app(): application
{
    return application::$app;
}

function request(): request
{
    return application::$app->request;
}

function response(): response
{
    return application::$app->response;
}

function redirect(string $url, bool $replace = true, int $httpCode = 0)
{
    return application::$app->response->redirect($url, $replace, $httpCode);
}

function session(): session
{
    return application::$app->session;
}

function router(): router
{
    return application::$app->router;
}

function database(): database
{
    return application::$app->database;
}

function query(string $table): query
{
    return new query(database: application::$app->database, table: $table);
}

function template(string $template, array $context = []): response
{
    $engine = new template();
    return application::$app->response->write($engine->render($template, $context));
}

function url(string $path = '/'): string
{
    return rtrim(application::$app->request->rootUrl . '/' . ltrim($path, '/'), '/');
}

function request_url(): string
{
    return application::$app->request->url;
}

function route(string $name, ?string $context = null): string
{
    return url(application::$app->router->route($name, $context));
}

function root_dir(string $path = '/'): string
{
    return rtrim(application::$app->path . '/' . ltrim($path), '/');
}

// Helper/Utils Shortcut

function dump(...$args)
{
    echo '<style>body{font-size:18px}</style><pre>';
    var_dump(...$args);
    echo '</pre>';
}

function dd(...$args)
{
    dump(...$args);
    exit(0);
}

function debugger(string $type, mixed $log): void
{
    application::$app->debugger->log($type, $log);
}

function csrf_token(): ?string
{
    return application::$app->session->get('_token');
}

function csrf(): string
{
    return sprintf('<input type="hidden" name="_token" value="%s" />', csrf_token());
}

function user(): ?array
{
    return application::$app->request->user;
}

function collect(array $items = []): collect
{
    return collect::make($items);
}

function cache(string $name): cache
{
    return new cache($name);
}
