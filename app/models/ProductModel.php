<?php

class ProductModel extends Model
{
    public function find($sku)
    {
        $sql = "SELECT * FROM products WHERE products.sku=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$sku]);
        return $stmt;
    }
}
