<?php

use App\Router\Router;

return function (Router $router) {
    $router->get("/", "App\Controllers\HomeController");
    $router->get("/docs/start/", "App\Controllers\DocsStartController");
    $router->get("/docs/router/", "App\Controllers\DocsRouterController");
    $router->get("/docs/controllers/", "App\Controllers\DocsCntrlController");
    $router->get("/docs/request/", "App\Controllers\DocsRequestController");
    $router->get("/docs/middleware/", "App\Controllers\DocsMdlController");
    $router->get("/docs/database/", "App\Controllers\DocsDbController");
    $router->get("/docs/templates/", "App\Controllers\DocsTmplController");
};

