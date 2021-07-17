<?php

// Autoload classes

use ext\CoreClass;
use ext\JsControllerClass;

spl_autoload_register(function ($class){
    require_once str_replace('\\', '/', $class) . '.php';
});

$Core       = new CoreClass;

$Controller = new JsControllerClass;