<?php

abstract class ProductAbstract
{
    protected static $sku;
    protected static $name;
    protected static $price;
    protected static $product_type;

    abstract public function returnTypeData();

    public function __construct($data)
    {
        self::$sku = $data['sku'];
        self::$name = $data['name'];
        self::$price = $data['price'];
        self::$product_type = $data['product_type'];
    }
}
