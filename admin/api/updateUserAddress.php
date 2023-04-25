<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Users.php';

$database = new Database();
$db = $database->connect();

$user = new Users($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data = {
//     "address":"asdasd",
//     "id": "1"
// }

$user->id = trim($data["id"], " ");
$user->address = $data["address"];

if ($user->id == "" or trim($data["address"]) == "") {
    echo json_encode(
        array('message' => 'Data Request is not valid!')
    );
} else {
    if ($user->updateUserAddress()) {
        echo json_encode(
            array('message' => 'User is Updated!')
        );
    } else {
        echo json_encode(
            array('message' => 'User is Not Updated!')
        );
    }
}
