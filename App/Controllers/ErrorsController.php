<?php

namespace App\Controllers;

use Config\Config;
use RuntimeException;

final class ErrorsController {
    const TEMPLATE = "Errors.php";
    const UNKNOWN_ERROR_TYPE = "";

    private const ERRORS = [
        401 => ["header" => "HTTP/1.0 401 Unauthorized", "message" => "401 Unauthorized"],
        404 => ["header" => "HTTP/1.0 404 Not Found", "message" => "404 Page Not Found"],
        405 => ["header" => "HTTP/1.0 405 Method Not Allowed", "message" => "405 Method Not Allowed"],
        500 => ["header" => "HTTP/1.0 500 Internal Server Error", "message" => "500 Internal Server Error"]
    ];


    public static function handleError(int $errorType, string $message = ""):void {
        if (!isset(self::ERRORS[$errorType])) {
            $errorType = 500;
        }
        header(self::ERRORS[$errorType]["header"]);
        $handlerMessage =  self::ERRORS[$errorType]["message"];
        $systemMessage = $message ?: self::UNKNOWN_ERROR_TYPE;
        self::loadTemplate($handlerMessage,$systemMessage);
    }

    private static function loadTemplate(string $handlerMessage, string $systemMessage, string $root = Config::HOST):void {
        $templateFile = Config::TEMPLATE_FOLDER . self::TEMPLATE;
        if (!file_exists($templateFile)) {
            error_log("Template for error page $templateFile not found");
            throw new RuntimeException("Template for error page $templateFile not found");
        }
        include $templateFile;
    }
}

