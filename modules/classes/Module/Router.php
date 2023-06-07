<?php
namespace Module;

class Router
{
    public static array $errorHandlers = [];
    public array $routes = [];

    public function handleRequest(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD']; // Get requested method
        $requestPath = $_SERVER['REQUEST_URI']; // Get requested path
        $matchedRoute = null; // Matched route indicator variable
        $params = []; // Parameters from dynamic route's path

        $def_route = "";

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod) {
                $def_route = $route['path'];
                $routePath = ROOT_PATH . $route['path'];

                // Check if the route path has dynamic parameters
                preg_match_all('/\[([a-zA-Z0-9_]+)\]/', $routePath, $placeholders);
                $placeholderNames = $placeholders[1];
                if ( /* strpos($routePath, '[') !== false */count($placeholderNames) > 0) {
                    $matches = $this->getRouteMatched($routePath, $requestPath);

                    if ($matches && is_array($matches)) {
                        $matchedRoute = $route;
                        $params = array_combine($placeholderNames, array_slice($matches, 1));
                        break;
                    }
                } else {
                    if ($routePath === $requestPath) {
                        $matchedRoute = $route;
                        break;
                    }
                }
            }
        }

        if ($matchedRoute) {
            $rPath = $requestPath;
            $fPath = removeLeft($rPath, ROOT_PATH);
            $callback = $matchedRoute['callback'];
            $req = new \Request($params, $_GET, $_POST, $_FILES, $def_route, $fPath, $rPath);
            $res = new \Response();
            if (is_string($callback)) {
                // callback is a controller
                Controller::parseController($callback, $req, $res);
            } else if (is_callable($callback)) {
                // callback is an actual callback or you can say, is a function
                call_user_func($callback, $req, $res);
            } else {
                $this->handleError(500, 'Internal server error');
            }
            return; // Exit the execution of other routes
        }

        // Check if any route matches the requested path regardless of method
        $matchingRouteFound = false;
        foreach ($this->routes as $route) {
            $routePath = ROOT_PATH . $route['path'];
            if ($this->getRouteMatched($routePath, $requestPath)) {
                $matchingRouteFound = true;
                break;
            }
        }

        if ($matchingRouteFound) {
            // Matching route found, but not for the requested method
            $this->handleError(405, 'Method Not Allowed');
        } else {
            // No matching route found
            $this->handleError(404, 'Page not found');
        }
    }

    public static function handleError(int $statusCode, string $message): void
    {
        if (isset(self::$errorHandlers[$statusCode])) {
            $handler = self::$errorHandlers[$statusCode];
            $res = new \Response();
            call_user_func($handler, $message, $res);
        } else {
            http_response_code($statusCode);
            echo "Error {$statusCode} - {$message}";
            exit;
        }
    }

    private function getRouteMatched(string $template, string $path): mixed
    {
        if ($template === $path) {
            return true;
        } else {
            $regexPattern = str_replace('/', '\/', $template);
            $regexPattern = preg_replace('/\/\[[^\]]+\]/', '/([^\/]+)', $regexPattern);
            preg_match('/^' . $regexPattern . '$/', $path, $matches);
            if (count($matches) > 0) {
                return $matches;
            } else {
                return false;
            }
        }
    }
}