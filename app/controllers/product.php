<?php

class Product extends Controller
{
    private $model;

    function __construct()
    {
        $this->model = $this->model('ProductModel');

        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Origin: *");
    }

    public function index()
    {
        $allProducts = $this->model->all()->fetchAll();
        echo json_encode($allProducts);
    }

    public function get()
    {
        $singleProduct = $this->model->find($_GET['sku'])->fetch();
        if ($singleProduct) {
            echo json_encode([$singleProduct]);
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            echo json_encode(["message" => "Product not found - sku:" . $_GET['sku']]);
        }
    }

    public function destroySeveral()
    {
        $this->model->deleteSeveral(explode(",", $_POST['product_sku_array']))->fetch();
        echo json_encode(["message" => "Products have been deleted!"]);
    }

    public function saveApi()
    {
        $productForStore = json_decode($_POST["product"], true);
        if ($this->model->find($productForStore['sku'])->fetch()) {
            header('HTTP/1.0 403 Forbidden');
            echo json_encode([
                "error" => [
                    "input" => "sku",
                    "message" => "SKU already exists"
                ]
            ]);
        } else if (!preg_match('/^[A-Za-z0-9]*$/', $productForStore['sku'])) {
            header('HTTP/1.0 422 Unprocessable Entity');
            echo json_encode([
                "error" => [
                    "input" => "sku",
                    "message" => "Alphabets and numbers only: [A-Z a-z 0-9]"
                ]
            ]);
        } else if (!preg_match('/^[A-Za-zა-ჰ0-9-\[\]()., ]*$/', $productForStore['name'])) {
            header('HTTP/1.0 422 Unprocessable Entity');
            echo json_encode([
                "error" => [
                    "input" => "name",
                    "message" => "Alphabets, numbers and some special characters only: []().,- [A-Z a-z ა-ჰ 0-9]"
                ]
            ]);
        } else if (!$this->isDecimal($productForStore['price'])) {
            header('HTTP/1.0 422 Unprocessable Entity');
            echo json_encode([
                "error" => [
                    "input" => 'price',
                    "message" => "Please enter the price following format (ex: 1.05 or 1)"
                ]
            ]);
        } else {
            $class = ucfirst($productForStore["product_type"]);
            $onlyTypeData = new $class($productForStore);
            $dataForSave = new DataForSave();
            $data = $dataForSave->returnData($onlyTypeData, $productForStore);
            $this->model->store($data);
            echo json_encode(["message" => "Create"]);
        }
    }

    private function isDecimal($value)
    {
        return preg_match('/^[0-9]+(?:\.[0-9]{0,2})?$/', $value);
    }
}
