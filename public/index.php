<?php
session_start();
/* ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL); */
require_once __DIR__.'/../modules/autoload.php';
define('ROOT_PATH', getProjectRoot(__DIR__)); // !! IMPORTANT !!

// start the app
(new Engine())->start();