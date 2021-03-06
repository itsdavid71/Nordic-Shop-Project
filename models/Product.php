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

    public static function getAll($category_id = false, $collection_id = false, $order_id = false)
    {
        global $mysqli; 

        $condition = "";
        $tables = "products p";

        if ($category_id != false) {
            $condition .= " AND category_id = $category_id";
        } 
        
        if ($collection_id != false) {
            $condition .= " AND collection_id = $collection_id";
        }

        if ($order_id != false) {
            $tables .= ", order_products op";
            $condition .= " AND op.order_id = $order_id AND p.product_id = op.product_id";
        }

        $query = "SELECT p.product_id FROM $tables WHERE 1 $condition"; 
        $result = $mysqli->query($query);

        $products = [];
        while ($product_data = $result->fetch_assoc()) {
            $products[] = new Product($product_data['product_id']);
        }
        
        return $products;
    }

    public static function create($title, $price, $category_id, $collection_id)
    {
        global $mysqli;
        
        $query = "INSERT INTO products SET 
                    title='$title', 
                    price=$price, 
                    category_id=$category_id,
                    collection_id=$collection_id
        ";
        $result = $mysqli->query($query);

        return $mysqli->insert_id;
    }

    public function update($title, $price, $category_id, $collection_id)
    {
        global $mysqli;
        
        $query = "UPDATE products SET 
                    title='$title', 
                    price=$price, 
                    category_id=$category_id,
                    collection_id=$collection_id
                  WHERE product_id=".$this->id;
        // var_dump($query);
        // die;
        $result = $mysqli->query($query);

        return $mysqli->affected_rows;
    }

    public function delete()
    {
        global $mysqli;
                var_dump($mysqli->error);

        $query_sizes = "DELETE FROM product_sizes
                        WHERE product_id=".$this->id;
        $query_order = "DELETE FROM order_products
                        WHERE product_id=".$this->id;
        $query = "DELETE FROM products
                  WHERE product_id=".$this->id;

        
        $result = $mysqli->query($query_sizes);
        $result = $mysqli->query($query_order);
        $result = $mysqli->query($query);
        return true;
    }
}

// Product::create('Example product', 100, 1, 1);

// $products = Product::getAll();
// var_dump($products);

