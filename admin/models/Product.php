<?php 
class Product {
    private $conn;
    private $table = 'products';

    public $id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllProducts() {
        $query = '
            SELECT * FROM ' . $this->table . '
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAllProductCount() {
        $query = '
            SELECT COUNT(id) AS NUM FROM ' . $this->table . '
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getProductById($id) {
        $query = '
            SELECT * FROM ' . $this->table . '
            WHERE id=:id
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt;
    }
}