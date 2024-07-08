<?php

namespace App\Middleware;

use App\Controllers\ErrorsController;
use app\Middleware\Interfaces\MiddlewareInterface;
use App\Request\Request;

class AuthMiddleware implements MiddlewareInterface {
    public function handle(Request $request, callable $next)
    {
        if (!$this->isAuthenticated($request)) {
            ErrorsController::handleError(401, "Unauthorized");
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