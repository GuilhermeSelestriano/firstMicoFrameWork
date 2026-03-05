<?php

namespace Framework;

class Application
{
    protected Router $router;
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->router = new Router();
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function run(): Response
    {
        $response = $this->router->dispatch($this->request);
        $this->sendResponse($response);
        return $response;
    }

    protected function sendResponse(Response $response): void
    {
        if (headers_sent()) return;
        http_response_code($response->getStatusCode());
        foreach ($response->getHeaders() as $name => $value) {
            header("$name: $value");
        }
        echo $response->getBody();
    }
}
