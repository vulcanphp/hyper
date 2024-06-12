<?php

namespace core;

class middleware
{
    private array $middlewareStack = [];

    public function add(callable $middleware)
    {
        $this->middlewareStack[] = $middleware;
    }

    public function handle(request $request)
    {
        foreach ($this->middlewareStack as $middleware) {
            $response = call_user_func($middleware, $request);
            if ($response instanceof response) {
                return $response;
            }
        }

        $this->middlewareStack = [];

        return null;
    }
}
