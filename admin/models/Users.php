<?php 
class Users {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $phone;
    public $email;
    public $firstname;
    public $lastname;
    public $address;
    public $role;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $query = '
            SELECT *
            FROM ' . $this->table . '
            WHERE role = "customer"
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getUsersNum() {
        $query = '
            SELECT COUNT(id) AS NUM FROM ' . $this->table . '
        ';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getUserById() {
        $query = '
            SELECT *
            FROM ' . $this->table . '
            WHERE id=:id
        ';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function updateUserAddress() {
        $query = '
                UPDATE ' . $this->table . '
                SET address= :address
                WHERE id= :id
        ';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function updateUserById() {
        $query = '
                UPDATE ' . $this->table . '
                SET address= :address,
                    firstname= :firstname,
                    lastname= :lastname,
                    email= :email,
                    phone_number= :phone
                WHERE id= :id
        ';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}