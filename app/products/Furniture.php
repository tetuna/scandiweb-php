<?php

class Furniture extends ProductAbstract
{
    protected $height;
    protected $width;
    protected $length;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->height = $data["height"];
        $this->width = $data["width"];
        $this->length = $data["length"];
    }

    public function returnTypeData()
    {
        return [
            "sku" => parent::$sku,
            "name" => parent::$name,
            "price" => parent::$price,
            "product_type" => parent::$product_type,

            "height" => $this->height,
            "width" => $this->width,
            "length" => $this->length,
        ];
    }
}
