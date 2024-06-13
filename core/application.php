<?php

namespace core;

use core\utils\cache;
use core\utils\session;
use core\utils\debugger;

class application
{
    public static application $app;
    public request $request;
    public response $response;
    public router $router;
    public session $session;
    public database $database;
    public debugger $debugger;
    public cache $cache;

    public function __construct(
        public string $path,
        public array $env = [],
        private array $providers = [],
        private array $middlewares = [],
        ?string $routesPath = null,
        array $requirePath = []
    ) {
        self::$app = $this;
        $this->debugger = new debugger($this->env['debug'] ?? false);
        $this->debugger->log('app', 'creating application');
        $this->session = new session();
        $this->request = new request();
        $this->response = new response();
        $this->router = new router(new middleware());
        $this->cache = new cache('app');
        $this->database = new database($this->env['database'] ?? []);
        if ($routesPath !== null) {
            $this->debugger->log('app', "loading routes from: {$routesPath}");
            foreach (require $routesPath as $route) {
                $this->router->add(...$route);
            }
        }
        foreach ($requirePath as $require) {
            $this->debugger->log('app', "require file from: {$require}");
            require $require;
        }
        $this->debugger->log('app', 'application created');
    }

    public function addServiceProvider(callable $provider): void
    {
        $this->providers[] = $provider;
    }

    public function addRouteMiddleware(callable $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function run(): void
    {
        $this->debugger->log('app', 'running providers, total (' . count($this->providers) . ')');
        // Run service providers
        foreach ($this->providers as $provider) {
            call_user_func($provider, $this);
        }
        // Add Router middleware
        foreach ($this->middlewares as $middleware) {
            $this->router->getMiddleware()->add($middleware);
        }
        // Dispatch the router
        $this->debugger->log('app', 'despatching router');
        $response = $this->router->dispatch($this->request);
        $response->send();
        $this->debugger->log('app', 'response sent');
    }
}
