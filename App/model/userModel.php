<?php
require_once '../connection/connection.php';

class UserModel {
    private $db;

    function __construct() {
        $this->db = Connection::getInstance();
    }

    function getUserByUserName($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    function updateUser($id, $firstname, $lastname, $email, $phone_number, $address) {
        $stmt = $this->db->prepare("UPDATE users SET firstname = ?, lastname = ?, email = ?, phone_number = ?, address = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $firstname, $lastname, $email, $phone_number, $address, $id);
        return $stmt->execute();
    }

    function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    function getAllUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function signup($firstname, $lastname, $username, $email, $phone_number, $password, $address) {
        $stmt = $this->db->prepare("INSERT INTO users (firstname, lastname, username, email, phone_number, password, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstname, $lastname, $username, $email, $phone_number, $password, $address);
        return $stmt->execute();
    }

    function login($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
