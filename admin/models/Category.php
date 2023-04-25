<?php
class Category {
    private $conn;
    private $table = 'category';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getNumCategory() {
        $query = '
        SELECT COUNT(id) AS NUM FROM ' . $this->table . '
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}