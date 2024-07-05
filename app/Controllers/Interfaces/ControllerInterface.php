<?php

namespace app\Controllers\Interfaces;

use App\Request\Request;

interface ControllerInterface
{
    public function init(Request $request);
}