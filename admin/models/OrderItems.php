<?php
class OrderItems {
    private $conn;
    private $table = 'order-items';

    public $id;
    public $order_id;
    public $product_id;
    public $quantity;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getOrderDetailByOrderId($id) {
        $query = '
            SELECT p.code, 
                p.name,
                p.image_url,
                p.discount,
                p.price,
                p.publisher,
                p.author,
                oi.quantity,
                oi.id,
                p.id AS product_id
            FROM `' . $this->table . '` oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ' . $id . '
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addOrderItems() {
        $query = '
            INSERT INTO `' . $this->table . '`
            SET order_id= :order_id,
                product_id= :product_id,
                quantity= :quantity
        ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':order_id', $this->order_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':quantity', $this->quantity);
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function updateOrderItems() {
        $query = '
            UPDATE `' . $this->table . '`
            SET quantity= :quantity
            WHERE id=:id
        ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function deleteOrderItems() {
        $query = '
            DELETE FROM `' . $this->table . '`
            WHERE id=:id
        ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}