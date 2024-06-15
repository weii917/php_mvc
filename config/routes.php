 <?php
    // 使用namespace方式而同時檔案位置也是跟namespace一樣路徑
    $router = new Framework\Router;

    $router->add("/admin/{controller}/{action}", ["namespace" => "Admin"]);
    $router->add("/{title}/{id:\d+}/{page:\d+}", ["controller" => "products", "action" => "showpage"]);
    // 越具體的放最前面，
    $router->add("/product/{slug:[\w-]+}", ["controller" => "products", "action" => "show"]);
    $router->add("/{controller}/{id:\d+}/{action}");
    $router->add("/home/index", ["controller" => "home", "action" => "index"]);
    $router->add("/products", ["controller" => "products", "action" => "index"]);
    $router->add("/", ["controller" => "home", "action" => "index"]);
    // 通用的放最後面
    $router->add("/{controller}/{action}");

    return $router;
