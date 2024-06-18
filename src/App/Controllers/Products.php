<?php

declare(strict_types=1);

namespace App\Controllers;
// 如果確定再根目錄前方無須\，使用use載入class就能使用該class
use App\Models\Product;
// 加入異常類別
use Framework\Exceptions\PageNotFoundException;
use Framework\Viewer;

class Products
{
    public function __construct(private Viewer $viewer, private Product $model)
    {
    }
    public function index()
    {
        // 同個底下需再加\從根目錄開始查找

        $products = $this->model->findAll();


        echo $this->viewer->render("shared/header.php", [
            "title" => "Products"
        ]);

        echo $this->viewer->render("Products/index.php", [
            "products" => $products
        ]);
    }

    public function show(string $id)
    {
        $product = $this->model->find($id);
        // print_r($product);
        if ($product === false) {
            throw new PageNotFoundException("Product not Found");
        }

        echo $this->viewer->render("shared/header.php", [
            "title" => "Product"
        ]);

        echo $this->viewer->render("Products/show.php", [
            "product" => $product
        ]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " " . $id . " " . $page;
    }

    public function new()
    {
        echo $this->viewer->render("shared/header.php", [
            "title" => "New Product"
        ]);

        echo $this->viewer->render("Products/new.php");
    }

    public function create()
    {
        $data = [
            "name" => $_POST["name"],
            "description" => empty($_POST["description"]) ? null : $_POST["description"]
        ];

        if ($this->model->insert($data)) {

            header("Location: /products/{$this->model->getInsertID()}/show");
            exit;
        } else {

            echo $this->viewer->render("shared/header.php", [
                "title" => "New Product"
            ]);

            echo $this->viewer->render("Products/new.php", [
                "errors" => $this->model->getErrors()
            ]);
        }

        // print_r($this->model->getErrors());
    }
}
