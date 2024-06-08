<?php

namespace App\Controllers;
// 如果確定再根目錄前方無須\，使用use載入class就能使用該class
use App\Models\Product;

class Products
{
    public function index()
    {
        // 同個底下需再加\從根目錄開始查找
        $model = new Product;
        $products = $model->getData();

        require "src/views/products_index.php";
    }

    public function show(string $id)
    {
        echo $id;
        require "src/views/products_show.php";
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " " . $id . " " . $page;
    }
}
