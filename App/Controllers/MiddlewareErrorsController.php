<?php

namespace App\Controllers;

final class MiddlewareErrorsController {


    private const ERRORS = [
        401 => ["header" => "HTTP/1.0 401 Unauthorized", "message" => "401 Unauthorized"],
        403 => ["header" => "HTTP/1.0 403 Forbidden", "message" => "Invalid token"],
        404 => ["header" => "HTTP/1.0 404 Not Found", "message" => "404 Page Not Found"],
        405 => ["header" => "HTTP/1.0 405 Method Not Allowed", "message" => "405 Method Not Allowed"],
        500 => ["header" => "HTTP/1.0 500 Internal Server Error", "message" => "500 Internal Server Error"]
    ];


    public static function handleError(int $errorType, string $message = ""):void {
        if (!isset(self::ERRORS[$errorType])) {
            $errorType = 500;
        }
        header(self::ERRORS[$errorType]["header"]);
        echo '{"error":"'.$errorType.'","message":"'.self::ERRORS[$errorType]['message'].'"}';
        exit;
    }


}


