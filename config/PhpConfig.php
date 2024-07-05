<?php

namespace Config;

final class PhpConfig {
    public static function configure():void {
        error_reporting(Config::DEV_MODE ? E_ALL : 0);
        ini_set('ignore_repeated_errors', TRUE);
        ini_set('display_errors', Config::DEV_MODE);
        ini_set('log_errors', TRUE);
        ini_set('error_log', Config::LOG_FOLDER);
    }
}