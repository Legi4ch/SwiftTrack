<?php
require_once("autoload.php");

use App\Request\Request;
use App\Router\Router;

$router = new Router();
$router->loadRoutes(__DIR__ . '/routes');
$router->handle(new Request());


