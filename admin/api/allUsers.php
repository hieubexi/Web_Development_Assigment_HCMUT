<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Users.php';

$database = new Database();
$db = $database->connect();

$users = new Users($db);

$result = $users->getAllUsers();

$numRow = $result->rowCount();

if ($numRow > 0) {
    $user_arr = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $u_item = array(
            'id' => $row["id"],
            'username' => $row["username"],
            'firstname' => $row["firstname"],
            'lastname' => $row["lastname"],
            'email' => $row["email"],
            'phone_number' => $row["phone_number"],
            'address' => $row["address"]
        );
        array_push($user_arr, $u_item);
    }

    echo json_encode($user_arr);
} else {
    echo json_encode(
        array('message' => 'No Products Found!')
    );
}