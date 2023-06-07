<?php
use Module\Model;

class Engine
{
    function __construct()
    {

    }

    public function start()
    {
        $this->handleModels();
        $this->includeRouteFiles();
    }

    private function includeRouteFiles()
    {
        $routefile_path = __DIR__ . '/../../routes';
        $requestPath = $_SERVER['REQUEST_URI'];
        if (startsWith($requestPath, ROOT_PATH . '/api')) {
            require_once $routefile_path . '/api.php';
        } else {
            require_once $routefile_path . '/web.php';
        }
    }

    private function handleModels(): void
    {
        spl_autoload_register(function ($class) {
            $class_file = __DIR__ . '/../../app/Models/' . $class . '.php';
            if (file_exists($class_file)) {
                require_once $class_file;
            }
        });
    }
}