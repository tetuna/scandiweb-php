<?php

namespace App\Models;

use App\Core\Model;

class ProductModel extends Model
{
    public function all()
    {
        $sql = "SELECT * FROM products";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function find($sku)
    {
        $sql = "SELECT * FROM products WHERE products.sku=?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$sku]);
        return $stmt;
    }

    public function store($product)
    {
        $sql = "INSERT INTO products (sku, name, price, product_type, size, weight, height, length, width)
        VALUES (?,?,?,?,?,?,?,?,?)";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([
            $product["sku"],
            $product["name"],
            $product["price"],
            $product["product_type"],
            $product["size"],
            $product["weight"],
            $product["height"],
            $product["length"],
            $product["width"]
        ]);
    }

    public function deleteSeveral($productSkuArray)
    {
        $questionMarks = implode(", ", array_fill(0, count($productSkuArray), "?"));
        $sql = "DELETE FROM products WHERE sku IN (" . $questionMarks . ")";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([...$productSkuArray]);
        return $stmt;
    }
}
