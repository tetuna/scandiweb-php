<?php

class Product extends Controller
{
    public function saveApi()
    {
        echo "save API";
    }

    public function get()
    {
        $productModel = $this->model('ProductModel');
        $singleProduct = $productModel->find($_GET['sku'])->fetch();
        header("Content-Type: application/json");
        if ($singleProduct) {
            echo json_encode($singleProduct);
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            echo json_encode(["message" => "Product not found - sku:" . $_GET['sku']]);
        }
    }
}
