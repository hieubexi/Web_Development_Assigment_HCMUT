<?php
class Discounts {
    private $conn;
    private $table = 'discounts';

    public $id;
    public $code;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getDiscountByCode() {
        $query = '
            SELECT discount, code
            FROM ' . $this->table . '
            WHERE code=:code';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $this->code);
        $stmt->execute();
        return $stmt;
    }
}