<?php

use App\Router\Router;

return function (Router $router) {
    $router->post("/", "App\Controllers\HomePostController");
};