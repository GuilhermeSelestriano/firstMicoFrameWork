<?php

namespace Framework;

class Request
{
    protected string $method;
    protected string $path;
    protected string $basePath;
    protected array $query;
    protected array $post;

    public function __construct(string $method = 'GET', string $uri = '/', array $query = [], array $post = [], string $basePath = '')
    {
        $this->method = strtoupper($method);
        $this->path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $this->basePath = $basePath;
        $this->query = $query;
        $this->post = $post;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public static function createFromGlobals(): self
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
        if ($basePath !== '' && $basePath !== '/' && strpos($path, $basePath) === 0) {
            $path = substr($path, strlen($basePath)) ?: '/';
        }
        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $path,
            $_GET ?? [],
            $_POST ?? [],
            $basePath
        );
    }

    public function getMethod(): string { return $this->method; }
    public function getPath(): string { return $this->path; }

    public function get(string $key, $default = null)
    {
        return $this->query[$key] ?? $this->post[$key] ?? $default;
    }
}
