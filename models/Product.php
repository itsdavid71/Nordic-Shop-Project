<?php

require_once '../db.php';

class Product 
{
    public $id;
    public $title;
    public $price;
    public $category_id;
    public $collection_id;

    public function __construct($id)
    {
        global $mysqli;
        
        $query = "SELECT product_id, title, price, category_id, collection_id FROM products WHERE product_id=$id";
        $result = $mysqli->query($query);

        $data = $result->fetch_assoc();

        $this->id = $data['product_id'];
        $this->title = $data['title'];
        $this->price = $data['price'];
        $this->category_id = $data['category_id'];
        $this->collection_id = $data['collection_id'];

    }

    public static function getAll()
    {
        global $mysqli;
        
        $query = "SELECT product_id FROM products";
        $result = $mysqli->query($query);

        $products = [];
        while ($product_data = $result->fetch_assoc()) {
            $products[] = new Product($product_data['product_id']);
        }

        return $products;
    }

    public static function getAllbyField($category_id = false, $collection_id = false)
    {
        global $mysqli; 

        $condition = "";

        if ($category_id != false) {

            $condition .= " AND category_id = $category_id";

        } 
        
        if ($collection_id != false) {

            $condition .= " AND collection_id = $collection_id";

        }

        $query = "SELECT product_id FROM products WHERE 1 $condition"; 
        $result = $mysqli->query($query);

        $products = [];
        while ($product_data = $result->fetch_assoc()) {
            $products[] = new Product($product_data['product_id']);
        }

        return $products;
    }

}

$productscol = Product::getAllbyField(1,0);
var_dump($productscol);
