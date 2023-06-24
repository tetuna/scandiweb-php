<?php

class ProductCleanData
{
    public function returnData(ProductAbstract $product, $data)
    {
        return $product->returnTypeData($data);
    }
}