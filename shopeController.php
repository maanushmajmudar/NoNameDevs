<?php
require_once("../config/db_conn.php");



class shope
{
    private $db, $conn;

    public function __construct()
    {
        $this->db = new dbConnect();
        $this->conn = $this->db->dbConnect();
    }

    public function getProductList($sortOrder)
    {


        if ($sortOrder === 'highToLow') {
            $stmt = $this->conn->prepare("SELECT id, brand, model, price, qty, year, image FROM laptops ORDER BY price DESC");
        } elseif ($sortOrder === 'lowToHigh') {
            $stmt = $this->conn->prepare("SELECT id, brand, model, price, qty, year, image FROM laptops ORDER BY price ASC");
        } else {
            $stmt = $this->conn->prepare("SELECT id, brand, model, price, qty, year, image FROM laptops");
        }
        $stmt->execute();
        $laptops = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $laptops;
    }
    public function getProductDetails($id)
    {
        $stmt = $this->conn->prepare("SELECT id, brand, model, price, qty, year, image FROM laptops WHERE id = :productId");
        $stmt->bindParam(':productId', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$product) {
            echo "<p>Product not found</p>";
            echo "<a href='shop.php'>Go back</a>";
            exit();
        }
        return $product;
    }
}