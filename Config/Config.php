<?php

namespace Config;

class Config
{
    const HOST ="http://localhost";
    const TEMPLATE_FOLDER = "templates/";
    const DEV_MODE = true; // false for production.
    const LOG_FOLDER = '/var/www/folder/php-logs/errors.log';
    const CSS_PATH = self::HOST."assets/css/";
    const JS_PATH = self::HOST."assets/js/";

    const QUERY_BUILDER_CREATE_ERROR = "An error while QB created!";

    public static array $CORS_HEADERS = [
        'Access-Control-Allow-Origin' => 'http://192.168.1.112:3000',
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
        'Access-Control-Allow-Credentials' => 'true',
        "Access-Control-Allow-Methods: GET, POST, OPTIONS",
    ];

    public static function setCorsHeaders() {
        foreach (self::$CORS_HEADERS as $key => $value) {
            header("$key: $value");
        }
    }







}