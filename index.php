<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $segments = explode("/", $path);

// 使用\\是因為他是特殊字元會解析為要結束字元，要\轉譯他為\
// 抓取要new的 namespace\class再轉為路徑的/來找到檔案位置
spl_autoload_register(function (string $class_name) {
    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});
// 使用namespace方式而同時檔案位置也是跟namespace一樣路徑
$router = new Framework\Router;

$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/", ["controller" => "home", "action" => "index"]);

$params = $router->match($path);

if ($params === false) {
    exit("No route matched");
}

$action = $params["action"];
$controller = "App\Controllers\\" . ucwords($params["controller"]);


$controller_object = new $controller;

$controller_object->$action();