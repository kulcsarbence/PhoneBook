<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Router;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router();

$router->add('GET', '/', function() {
    require_once __DIR__ . '/../src/controllers/HomeController.php';
});

$router->add('POST', '/add', function() {
    require_once __DIR__ . '/../src/controllers/ProcessController.php';
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($method, parse_url($uri, PHP_URL_PATH));