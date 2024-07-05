<?php

namespace App\Controllers;

use app\Controllers\Abstract\BaseController;
use App\Request\Request;
use Config\Config;

class DocsRequestController extends BaseController
{
    protected string $template = "request";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "SwiftTrack. Документация. Request.",
            "welcome" => "Класс Request",
            "root" => Config::HOST // {{root}} variable define site root for each template if you need.
        ];
        $this->loadTemplate($tmplVars);
    }
}