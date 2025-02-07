<?php

use Config\PhpConfig;

include_once("Config/PhpConfig.php");
include_once("Config/Config.php");

PhpConfig::configure();

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $class = __DIR__ . '/' . $class . '.php';
    if (file_exists($class)) {
        require $class;
    }
});


