<?php
$route = new Route();

$route->get('/', "HomeController@main");


// Error pages
$route->onError(404, function ($msg, $res) {
    $res->send(render('errors.404', ['message' => $msg]));
});
$route->onError(405, function ($msg, $res) {

    $res->send(render('errors.405', ['message' => $msg]));
});
$route->onError(500, function ($msg, $res) {
    $res->send(render('errors.500', ['message' => $msg]));
});

$route->handleRoutes();