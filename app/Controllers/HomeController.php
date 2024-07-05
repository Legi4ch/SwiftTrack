<?php

namespace App\Controllers;

use app\Controllers\Abstract\BaseController;
use App\Request\Request;
use Config\Config;

class HomeController extends BaseController
{
    protected string $template = "home";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "SwiftTrack Demo starter page",
            "welcome" => "Starter Page",
            "root" => Config::HOST // {{root}} variable define site root for each template if you need.
        ];

        $this->loadTemplate($tmplVars);
    }
}