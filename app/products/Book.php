<?php

class Book extends ProductAbstract
{
    protected $weight;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->weight = $data["weight"];
    }

    public function returnTypeData()
    {
        return [
            "sku" => parent::$sku,
            "name" => parent::$name,
            "price" => parent::$price,
            "product_type" => parent::$product_type,

            "weight" => $this->weight,
        ];
    }
}
