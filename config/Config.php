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







}