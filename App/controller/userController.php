<?php
require_once '../model/userModel.php';

class UserController {
    private $userModel;

    function __construct() {
        $this->userModel = new UserModel();
    }

    function getUserByUserName($username) {
        return $this->userModel->getUserByUserName($username);
    }

    function updateUser($id, $firstname, $lastname, $email, $phone_number, $address) {
        return $this->userModel->updateUser($id, $firstname, $lastname, $email, $phone_number, $address);
    }

    function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }

    function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    function handleSignup() {
        if(isset($_POST['action']) && $_POST['action'] == 'signup') {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $address = $_POST['address'];

            return $this->userModel->signup($firstname, $lastname, $username, $email, $phone_number, $password, $address);
        }
    }

    function handleSignin() {
        if(isset($_POST['action']) && $_POST['action'] == 'signin') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByUserName($username);
            if($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }
        return false;
    }

    function handleLogout() {
        session_start();
        session_destroy();
        header('Location: index.php');
    }
}
