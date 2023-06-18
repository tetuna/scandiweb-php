<?php

class DataForSave
{
    public function returnData(ProductAbstract $product, $data)
    {
        return $product->returnTypeData($data);
    }
}