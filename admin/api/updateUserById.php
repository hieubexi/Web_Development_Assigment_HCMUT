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
//     "firstname": "asd",
//     "lastname": "asd",
//     "phone": "0091239",
//     "email": "hiasod@masdo",
//     "id": "1"
// }

$user->id = trim($data["id"], " ");
$user->address = $data["address"];
$user->firstname = $data["firstname"];
$user->lastname = $data["lastname"];
$user->email = $data["email"];
$user->phone = $data["phone"];

if ($user->id == "" or trim($data["address"]) == "" or trim($data["phone"]) == "" or trim($data["firstname"]) == "" or trim($data["lastname"]) == "" or trim($data["email"]) == "") {
    echo json_encode(
        array('message' => 'Data Request is not valid!')
    );
} else {
    if ($user->updateUserById()) {
        echo json_encode(
            array('message' => 'User is Updated!')
        );
    } else {
        echo json_encode(
            array('message' => 'User is Not Updated!')
        );
    }
}
