<?php
$route = new Route();

$route->get('/api/hello', function($req, $res) {
    $res->http_code(200);
    $res->json(['error' => 'false', 'message' => 'hello world']);
});


$route->handleRoutes();