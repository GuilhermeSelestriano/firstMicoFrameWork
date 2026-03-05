<?php

namespace Framework;

class Route
{
    protected string $method;
    protected string $path;
    protected $handler;

    public function __construct(string $method, string $path, callable $handler)
    {
        $this->method = strtoupper($method);
        $this->path = $path;
        $this->handler = $handler;
    }

    public function matches(string $method, string $path): bool
    {
        if ($this->method !== $method) return false;
        $pattern = '#^' . preg_replace('/\{[^}]+\}/', '([^/]+)', $this->path) . '$#';
        return (bool) preg_match($pattern, $path);
    }

    public function getHandler(): callable { return $this->handler; }
}
