<?php

namespace App\Controllers;

use app\Controllers\Abstracts\BaseController;
use App\Database\FreeBuilder;
use App\Database\SqliteConnection;
use App\Request\Request;
use Config\Config;

class DocsDbController extends BaseController
{
    protected string $template = "database";

    public function init(Request $request): void {
        $fb = new FreeBuilder(SqliteConnection::class);
        $data = $fb->getAll();
        $tmplVars = [
            "title" => "Swift Track. Документация. База данных.",
            "welcome" => "Базы данных в Swift Track",
            "data" => $data,
            "root" => Config::HOST, // {{root}} variable define site root for each template if you need.
        ];

        $this->loadTemplate($tmplVars);
    }
}