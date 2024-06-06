<?php
namespace App\Controllers;

class Products
{
    public function index()
    {
        require "src/models/product.php";
        $model = new Product;
        $products = $model->getData();

        require "src/views/products_index.php";
    }

    public function show()
    {
        require "src/views/products_show.php";
    }
}
