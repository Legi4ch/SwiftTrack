<?php

namespace App\Controllers;

use app\Controllers\Abstract\BaseController;
use App\Request\Request;
use Config\Config;

class DocsTmplController extends BaseController
{
    protected string $template = "templates";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "SwiftTrack. Документация. Шаблоны.",
            "welcome" => "Шаблоны в SwiftTrack",
            "root" => Config::HOST, // {{root}} variable define site root for each template if you need.
        ];

        $this->loadTemplate($tmplVars);
    }
}