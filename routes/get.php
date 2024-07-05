<?php

use App\Router\Router;

return function (Router $router) {
    $router->get("/", "app\Controllers\HomeController");
    $router->get("/docs/start/", "app\Controllers\DocsStartController");
    $router->get("/docs/router/", "app\Controllers\DocsRouterController");
    $router->get("/docs/controllers/", "app\Controllers\DocsCntrlController");
    $router->get("/docs/request/", "app\Controllers\DocsRequestController");
    $router->get("/docs/middleware/", "app\Controllers\DocsMdlController");
    $router->get("/docs/database/", "app\Controllers\DocsDbController");
    $router->get("/docs/templates/", "app\Controllers\DocsTmplController");
    $router->get("/articles/[a-zA-Z0-9-]{1,}/[a-zA-Z0-9-]{1,}/", "Core\Controllers\GetFilesController");
};

