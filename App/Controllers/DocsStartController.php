<?php

namespace App\Controllers;

use app\Controllers\Abstract\BaseController;
use App\Request\Request;
use Config\Config;

class DocsStartController extends BaseController
{
    protected string $template = "start";

    public function init(Request $request): void {
        $tmplVars = [
            "title" => "Swift Track. Документация. Основные принципы.",
            "welcome" => "Идеология Swift Track",
            "root" => Config::HOST // {{root}} variable define site root for each template if you need.
        ];

        $this->loadTemplate($tmplVars);
    }
}