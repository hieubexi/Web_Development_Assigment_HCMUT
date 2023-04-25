<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/OrderItems.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->connect();

$orderItem = new OrderItems($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data = {
//     "order_id": "2",
//     "product_id": "1",
//     "quantity": "2"
// }

$orderItem->order_id = $data['order_id'];
$orderItem->product_id = $data['product_id'];
$orderItem->quantity = $data['quantity'];

if ($orderItem->addOrderItems()) {
    echo json_encode(
        array('message' => 'Order Item Created!')
    );
} else {
    echo json_encode(
        array('message' => 'Order Item Not Created!')
    );
}