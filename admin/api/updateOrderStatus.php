<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data = {
//     "id": "11",
//     "status": "Accept"
// }

$order->id = $data["id"];
$order->status = $data["status"];

if ($order->updateStatus()) {
    echo json_encode(
        array('message' => 'Order Updated!')
    );
} else {
    echo json_encode(
        array('message' => 'Order Not Updated!')
    );
}