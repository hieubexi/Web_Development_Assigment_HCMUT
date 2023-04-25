<?php
class Ratings {
    private $conn;
    private $table = 'ratings';

    public $id;
    public $product_id;
    public $user_id;
    public $content;
    public $rate_star;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAvgStarByProduct() {
        $query = '
            SELECT AVG(rate_star) AS AVG_STAR FROM ' . $this->table . ' 
            WHERE product_id = ' . $this->product_id . '
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAllReviewByProduct() {
        $query = '
            SELECT u.username, rd.rate_star, rd.created_at, rd.content FROM ' . $this->table . ' rd 
            LEFT JOIN `users` u ON rd.user_id = u.id
            WHERE rd.product_id = ' . $this->product_id . ';
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addReview() {
        $query = '
            INSERT INTO ' . $this->table . '
            SET product_id= :product_id,
                user_id= :user_id,
                rate_star= :rate_star,
                content= :content
        ';
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->rate_star = htmlspecialchars(strip_tags($this->rate_star));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':rate_star', $this->rate_star);
        $stmt->bindParam(':content', $this->content);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            printf("Error: %s.\n", $stmt->error);
            return 0;
        }
    }

    public function updateReview() {
        $query = '
            UPDATE ' . $this->table . '
            SET rate_star= :rate_star,
                content= :content
            WHERE id= :id
        ';
        $stmt = $this->conn->prepare($query);

        $this->rate_star = htmlspecialchars(strip_tags($this->rate_star));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(':rate_star', $this->rate_star);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function deleteReview() {
        $query = '
            DELETE FROM ' . $this->table . '
            WHERE id= :id
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