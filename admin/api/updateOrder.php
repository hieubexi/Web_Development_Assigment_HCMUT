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
//     "id":"11",
//     "code": "2342Ac",
//     "user_id": "1",
//     "discount":"0.0",
//     "invoice":"200000",
//     "status": "Processing",
// }

$order->id = $data["id"];
$order->user_id = $data["user_id"];
$order->code = $data["code"];
$order->discount = $data["discount"];
$order->invoice = ceil(intval($data["invoice"]) * (100.0 - floatval($data["discount"])) / 100);
$order->status = $data["status"];
// $items = $data["items"];

if ($order->updateOrder()) {
    echo json_encode(
        array('message' => 'Order Updated!')
    );
} else {
    echo json_encode(
        array('message' => 'Order Not Updated!')
    );
}