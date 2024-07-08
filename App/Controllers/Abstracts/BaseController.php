<?php

namespace app\Controllers\Abstract;

use App\Controllers\ErrorsController;
use App\Controllers\Interfaces\ControllerInterface;
use App\Request\Request;
use Config\Config;

abstract class BaseController implements ControllerInterface {
    protected string $template;

    abstract function init(Request $request);


    protected function loadTemplate(array $variables = []): void {
        $templateFile = Config::TEMPLATE_FOLDER . $this->template . "_tmpl.php";
        if (file_exists($templateFile)) {
            ob_start();
            extract($variables);
            include $templateFile;
            $content = ob_get_clean();
            echo $this->processTemplate($content, $variables);
        } else {
            error_log("Template loading error $this->template");
            ErrorsController::handleError(500, "Template loading error: $this->template");
            die();
        }
    }

    private function processTemplate($content, $variables): array|string|null {
        return preg_replace_callback('/\{\{([\w\-.\[\]]+)}}/', function($matches) use ($variables) {
            $key = $matches[1];
            $originalMarker = $matches[0]; // Исходный маркер, например {{variable}}
            return $this->resolveVariable($key, $variables, $originalMarker);
        }, $content);
    }

    private function resolveVariable($key, $variables, $defaultValue) {
        // Разбиваем ключ на части по точкам или квадратным скобкам
        preg_match_all('/\w+|\[\d+]/', $key, $matches);
        $keys = array_map(function($part) {
            return trim($part, '[]');
        }, $matches[0]);

        // Рекурсивно находим значение по цепочке ключей
        $value = $variables;
        foreach ($keys as $part) {
            if (is_array($value) && array_key_exists($part, $value)) {
                $value = $value[$part];
            } else {
                return $defaultValue; // Возвращаем исходный маркер, если не удалось найти значение
            }
        }
        return $value;
    }
}