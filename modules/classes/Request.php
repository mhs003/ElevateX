<?php
class Request
{
    public array $params;
    public array $query;
    public array $body;
    public array $files;
    public string $route;
    public string $routePath;
    public string $path;

    public function __construct(array $params, array $query, array $body, array $files, string $route, string $routePath, string $path)
    {
        $this->params = $params;
        $this->query = $query;
        $this->body = $body;
        $this->files = $files;
        $this->route = $route;
        $this->routePath = $routePath;
        $this->path = $path;
    }

    public function getParam(string $paramName)
    {
        return $this->params[$paramName] ?? null;
    }

    public function getQuery(string $paramName)
    {
        return $this->query[$paramName] ?? null;
    }

    public function getBody(string $paramName)
    {
        return $this->body[$paramName] ?? null;
    }

    public function file(string $fieldName, string $fileName = null)
    {
        if (isset($this->files[$fieldName])) {
            $file = $this->files[$fieldName];

            if ($file['error'] === UPLOAD_ERR_OK) {
                if ($fileName) {
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $newFileName = $fileName . '.' . $extension;
                    $file['name'] = $newFileName;
                }

                return $file;
            }
        }

        return null;
    }
}
