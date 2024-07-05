<?php

use Config\PhpConfig;

include_once("config/PhpConfig.php");
include_once("config/Config.php");

PhpConfig::configure();

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $class = __DIR__ . '/' . $class . '.php';
    if (file_exists($class)) {
        require $class;
    }
});