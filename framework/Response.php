<?php

namespace Framework;

class Response
{
    protected int $statusCode;
    protected array $headers;
    protected string $body;

    public function __construct(string $body = '', int $statusCode = 200, array $headers = [])
    {
        $this->body = $body;
        $this->statusCode = $statusCode;
        $this->headers = array_merge(['Content-Type' => 'text/html; charset=UTF-8'], $headers);
    }

    public function getBody(): string { return $this->body; }
    public function getStatusCode(): int { return $this->statusCode; }
    public function getHeaders(): array { return $this->headers; }
    public function setHeader(string $name, string $value): self { $this->headers[$name] = $value; return $this; }

    public static function json(array $data, int $statusCode = 200): self
    {
        return new self(json_encode($data, JSON_UNESCAPED_UNICODE), $statusCode, ['Content-Type' => 'application/json']);
    }
}
