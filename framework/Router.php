<?php

namespace Framework;

class Router
{
    protected array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes[] = new Route('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes[] = new Route('POST', $path, $handler);
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route->matches($request->getMethod(), $request->getPath())) {
                $response = ($route->getHandler())($request);
                return $response instanceof Response ? $response : new Response((string) $response);
            }
        }
        return new Response('<h1>404 - Não encontrado</h1>', 404);
    }
}
