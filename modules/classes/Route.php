<?php
use Module\Router;

class Route extends Router
{
    public function addRoute(string $method, string $path, $callback): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'callback' => $callback
        ];
    }

    public function get(string $path, $callback): void
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post(string $path, $callback): void
    {
        $this->addRoute('POST', $path, $callback);
    }

    public function put(string $path, $callback): void
    {
        $this->addRoute('PUT', $path, $callback);
    }

    public function delete(string $path, $callback): void
    {
        $this->addRoute('DELETE', $path, $callback);
    }

    public function handleRoutes(): void
    {
        $this->handleRequest();
    }

    public static function addError(int $errCode, string $msg): void
    {
        self::handleError($errCode, $msg);
    }

    public function onError(int $statusCode, $callback): void
    {
        self::$errorHandlers[$statusCode] = $callback;
    }
}