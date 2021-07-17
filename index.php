<?php

// Задаём основную кодировку страницы.
header('Content-Type: text/html; charset=utf-8');

// Отключаем вывод ошибок.
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Set defines
define("EXT", "ext/");
define("ASSETS", "assets/");
define("VIEW", "view/");

// Load classes
require EXT . "__autoload.php";

// Проверяем на загрузку 
isset( $_GET["upload"] ) && exit( $Controller->check_file() );

// Проверяем на что - то
isset( $_GET["get"] ) && exit( $Controller->send_file() );

// Load view container
require VIEW . "home.php";