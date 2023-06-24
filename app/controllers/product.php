<?php

class Product extends Controller
{
    private $model;
    private $validator;

    public function __construct()
    {
        $this->model = $this->model('ProductModel');

        header("Content-Type: application/json");
        header("Accept: application/json");
        header("Access-Control-Allow-Origin: *");

        $this->validator = new Validator();
    }

    public function index()
    {
        $allProducts = $this->model->all()->fetchAll();
        echo json_encode($allProducts);
    }

    public function get()
    {
        $singleProduct = $this->model->find($_GET["sku"])->fetch();
        if ($singleProduct) {
            $class = ucfirst($singleProduct["product_type"]);
            $onlyTypeData = new $class($singleProduct);
            $productCleanData = new ProductCleanData();
            $data = $productCleanData->returnData($onlyTypeData, $singleProduct);
            echo json_encode([$data]);
        } else {
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
            echo json_encode(["message" => "Product not found - sku:" . $_GET["sku"]]);
        }
    }

    public function destroySeveral()
    {
        $this->model->deleteSeveral(explode(",", $_POST["product_sku_array"]))->fetch();
        echo json_encode(["message" => "Products have been deleted!"]);
    }

    public function saveApi()
    {
        $productForStore = json_decode($_POST["product"], true);

        // check if sku exists

        if ($this->model->find($productForStore["sku"])->fetch()) {
            header('HTTP/1.0 403 Forbidden');
            $this->validator->inputError("sku", "SKU already exists");
        }

        // get only the necessary data

        $class = ucfirst($productForStore["product_type"]);
        $onlyTypeData = new $class($productForStore);
        $dataForSave = new ProductCleanData();
        $data = $dataForSave->returnData($onlyTypeData, $productForStore);

        // validate Start()

        $dataForValidation = $data;

        $this->validator->alphabetsNumbers($dataForValidation["sku"], "sku");
        $this->validator->alphabetsNumbersSpecChars($dataForValidation["name"], "name");

        unset($dataForValidation["sku"], $dataForValidation["name"], $dataForValidation["product_type"]);

        foreach ($dataForValidation as $key => $item) {
            $this->validator->isDecimal($item, $key);
        }

        // validate End()

        $this->model->store($data);
        echo json_encode(["message" => "Create"]);
    }
}
