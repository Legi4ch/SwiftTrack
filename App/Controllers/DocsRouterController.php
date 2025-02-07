<?php

namespace App\Controllers;

use app\Controllers\Abstracts\BaseController;
use App\Request\Request;
use Config\Config;

class DocsRouterController extends BaseController
{
    protected string $template = "router";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "Swift Track. Документация. Маршруты.",
            "welcome" => "Маршрутизация в Swift Track",
            "root" => Config::HOST // {{root}} variable define site root for each template if you need.
        ];
        $this->loadTemplate($tmplVars);
    }
}