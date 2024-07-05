<?php

namespace App\Controllers;

use app\Controllers\Abstract\BaseController;
use App\Request\Request;
use Config\Config;

class DocsMdlController extends BaseController
{
    protected string $template = "middleware";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "SwiftTrack. Документация. Middleware.",
            "welcome" => "Middleware в SwiftTrack",
            "root" => Config::HOST, // {{root}} variable define site root for each template if you need.
        ];

        $this->loadTemplate($tmplVars);
    }
}