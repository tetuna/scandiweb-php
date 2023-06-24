<?php

class Dvd extends ProductAbstract
{
    protected $size;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->size = $data["size"];
    }

    public function returnTypeData()
    {
        return [
            "sku" => parent::$sku,
            "name" => parent::$name,
            "price" => parent::$price,
            "product_type" => parent::$product_type,

            "size" => $this->size,
        ];
    }
}
