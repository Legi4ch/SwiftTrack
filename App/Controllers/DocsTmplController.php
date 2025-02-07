<?php

namespace App\Controllers;

use app\Controllers\Abstracts\BaseController;
use App\Request\Request;
use Config\Config;

class DocsTmplController extends BaseController
{
    protected string $template = "templates";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "Swift Track. Документация. Шаблоны.",
            "welcome" => "Шаблоны в Swift Track",
            "root" => Config::HOST, // {{root}} variable define site root for each template if you need.
        ];

        $this->loadTemplate($tmplVars);
    }
}