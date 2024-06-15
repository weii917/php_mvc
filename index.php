<?php

declare(strict_types=1);

// 使用\\是因為他是特殊字元會解析為要結束字元，要\轉譯他為\
// 抓取要new的 namespace\class再轉為路徑的/來找到檔案位置
spl_autoload_register(function (string $class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

$dotenv = new Framework\Dotenv;

$dotenv->load(".env");

// 因使用static所以使用::來取得function
set_error_handler("Framework\ErrorHandler::handleError");

set_exception_handler("Framework\ErrorHandler::handleException");


$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $segments = explode("/", $path);

if ($path === false) {
    throw new UnexpectedValueException("Malformed URL:
                                        '{$_SERVER["REQUEST_URI"]}'");
}


$router = require "config/routes.php";


$container = require "config/service.php";

$dispatcher = new Framework\Dispatcher($router, $container);
$dispatcher->handle($path);
