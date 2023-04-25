<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Users.php';

$database = new Database();
$db = $database->connect();

$user = new Users($db);

$user_id = isset($_GET['userId']) ? $_GET['userId'] : die();

$user->id = $user_id;

$result = $user->getUserById();

if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(array(
        "firstName" => $row['firstname'],
        "fullName" => $row['firstname'] . '' . $row['lastname'],
        "lastName" => $row['lastname'],
        "username" => $row['username'],
        "email" => $row['email'],
        "phone" => $row['phone_number'],
        'address' => $row['address']
    ));
} else {
    echo json_encode(
        array('message' => 'Cart is empty!')
    );
}