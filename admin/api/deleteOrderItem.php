<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,
Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/OrderItems.php';

$database = new Database();
$db = $database->connect();

$orderItem = new OrderItems($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data  = {
//     "id":"3"
// }

$orderItem->id = $data["id"];

if ($orderItem->deleteOrderItems()) {
    echo json_encode(
        array('message' => 'Order Item Deleted!')
    );
} else {
    echo json_encode(
        array('message' => 'Order Item Not Deleted!')
    );
}