<?php

namespace App\Controllers;
// 如果確定再根目錄前方無須\，使用use載入class就能使用該class
use App\Models\Product;
use Framework\Viewer;

class Products
{
    public function index()
    {
        // 同個底下需再加\從根目錄開始查找
        $model = new Product;
        $products = $model->getData();
        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Products"
        ]);

        echo $viewer->render("Products/index.php", [
            "products" => $products
        ]);
    }

    public function show(string $id)
    {

        $viewer = new Viewer;

        echo $viewer->render("shared/header.php", [
            "title" => "Product"
        ]);

        echo $viewer->render("Products/show.php", [
            "id" => $id
        ]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " " . $id . " " . $page;
    }
}
