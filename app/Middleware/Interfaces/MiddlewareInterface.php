<?php

namespace app\Middleware\Interfaces;

use App\Request\Request;

interface MiddlewareInterface
{
    public function handle(Request $request, callable $next);
}