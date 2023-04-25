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
//     "id":"3"
// }

$cartItem->id = $data["id"];

if ($cartItem->removeProductInCart()) {
    echo json_encode(
        array('message' => 'Cart Item Deleted!')
    );
} else {
    echo json_encode(
        array('message' => 'Cart Item Not Deleted!')
    );
}