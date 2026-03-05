<?php

namespace Framework;

abstract class Controller
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function view(string $path, array $data = []): Response
    {
        $data['basePath'] = $this->request->getBasePath();
        extract($data);
        ob_start();
        include $path;
        return new Response(ob_get_clean());
    }

    protected function json(array $data, int $statusCode = 200): Response
    {
        return Response::json($data, $statusCode);
    }
}
