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
            "products" => $products,
            "total"=>$this->model->getTotal()
        ]);
    }

    public function show(string $id)
    {
        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", [
            "title" => "Product"
        ]);

        echo $this->viewer->render("Products/show.php", [
            "product" => $product
        ]);
    }

    public function edit(string $id)
    {
        $product = $this->getProduct($id);

        echo $this->viewer->render("shared/header.php", [
            "title" => "Edit Product"
        ]);

        echo $this->viewer->render("Products/edit.php", [
            "product" => $product
        ]);
    }

    public function showPage(string $title, string $id, string $page)
    {
        echo $title . " " . $id . " " . $page;
    }

    private function getProduct(string $id): array
    {
        $product = $this->model->find($id);
        // print_r($product);
        if ($product === false) {
            throw new PageNotFoundException("Product not Found");
        }

        return $product;
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
                "errors" => $this->model->getErrors(),
                "product" => $data
            ]);
        }

        // print_r($this->model->getErrors());
    }

    public function update(string $id)
    {

        $product = $this->getProduct($id);

        $product["name"] = $_POST["name"];
        $product["description"] = empty($_POST["description"]) ? null : $_POST["description"];


        if ($this->model->update($id, $product)) {

            header("Location: /products/{$id}/show");
            exit;
        } else {

            echo $this->viewer->render("shared/header.php", [
                "title" => "Edit Product"
            ]);

            echo $this->viewer->render("Products/edit.php", [
                "errors" => $this->model->getErrors(),
                "product" => $product
            ]);
        }

        // print_r($this->model->getErrors());
    }

    public function delete(string $id)
    {
        $product = $this->getProduct($id);

        // 先確認是否為post
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $this->model->delete($id);

            header("Location: /products/index");
            exit;
        }

        echo $this->viewer->render("shared/header.php", [
            "title" => "Delete Product"
        ]);

        echo $this->viewer->render("Products/delete.php", [
            "product" => $product
        ]);
    }
}
