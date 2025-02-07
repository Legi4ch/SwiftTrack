<?php

namespace App\Middleware;

use App\Controllers\MiddlewareErrorsController;
use app\Middleware\Interfaces\MiddlewareInterface;
use App\Request\Request;
use Config\Config;

class AuthMiddleware implements MiddlewareInterface {
    public function handle(Request $request, callable $next)
    {
        Config::setCorsHeaders();
        if (!$this->isAuthenticated($request)) {
            MiddlewareErrorsController::handleError(403, "Invalid token");
            exit;
        }
        return $next($request);
    }

    private function isAuthenticated(Request $request)
    {
        $headers = $request->getHeaders();
        return isset($headers['Authorization']) && $headers['Authorization'] === 'Bearer valid_token';
    }
}