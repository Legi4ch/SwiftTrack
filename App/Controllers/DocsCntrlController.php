<?php

namespace App\Controllers;

use app\Controllers\Abstract\BaseController;
use App\Request\Request;
use Config\Config;

class DocsCntrlController extends BaseController
{
    protected string $template = "controller";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "Swift Track. Документация. Контроллеры.",
            "welcome" => "Контроллеры в Swift Track",
            "root" => Config::HOST // {{root}} variable define site root for each template if you need.
        ];
        $this->loadTemplate($tmplVars);
    }
}