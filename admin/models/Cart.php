<?php
class Cart {
    private $conn;
    private $table = 'carts';

    public $id;
    public $user_id;
    public $product_id;
    public $qty;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addProductToCart() {
        $query = '
            INSERT INTO ' . $this->table . '
            SET user_id= :user_id,
                status= "Cart",
                product_id= :product_id,
                quantity= :qty
        ';

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->qty = htmlspecialchars(strip_tags($this->qty));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':qty', $this->qty);

        if($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function checkExistCartItem() {
        $query = '
            SELECT *
            FROM ' . $this->table . ' 
            WHERE user_id= :user_id AND product_id= :product_id
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->execute();
        return $stmt;
    }

    public function getCartInfo($user_id) {
        $query = '
            SELECT  c.status,
                    c.id AS cart_id,
                    c.quantity, 
                    p.id,
                    p.name,
                    p.author,
                    p.publisher,
                    p.code,
                    p.image_url,
                    p.discount,
                    p.price
            FROM ' . $this->table . ' c
            LEFT JOIN `products` p ON c.product_id = p.id
            WHERE c.user_id=:user_id
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }

    public function updateProductInCart() {
        $query = '
            UPDATE ' . $this->table . '
            SET quantity= :qty
            WHERE id=:id
        ';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':qty', $this->qty);
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function removeProductInCart() {
        $query = '
            DELETE FROM ' . $this->table . '
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

    public function removeProductInCartByUserId() {
        $query = '
            DELETE FROM ' . $this->table . '
            WHERE user_id= :user_id
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}