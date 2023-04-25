<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Cart.php';

$database = new Database();
$db = $database->connect();

$cartItem = new Cart($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data  = {
//     "user_id":"3"
// }

$cartItem->user_id = $data["user_id"];

if ($data["user_id"] == "") {
    echo json_encode(
        array('message' => 'User id is empty!')
    );
} else {
    if ($cartItem->removeProductInCartByUserId()) {
        echo json_encode(
            array('message' => 'Cart Items Deleted!')
        );
    } else {
        echo json_encode(
            array('message' => 'Cart Items Not Deleted!')
        );
    }
}
