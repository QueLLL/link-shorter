<?php
define('ROOT', __DIR__);
require_once 'vendor/autoload.php';
use Components\Router;

$router = new Router();
$router->run();
