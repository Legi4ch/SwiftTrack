<?php

namespace App\Controllers\Interfaces;

use App\Request\Request;

interface ControllerInterface
{
    public function init(Request $request);
}