<?php

use App\Router\Router;

return function (Router $router) {
    $router->post("/", "app\Controllers\HomePostController");
};