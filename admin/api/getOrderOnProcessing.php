<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$result = $order->getOrdersOnProcessing();

$numRow = $result->rowCount();

if ($numRow > 0) {
    $orders_arr = array();
    $orders_arr['data'] = array();
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $order_item = array(
            'id' => $id,
            'code' => $code,
            'username' => $username,
            'discount' =>$discount,
            'invoice' => $invoice,
            'status' => $status,
            'created_at' => $created_at
        );

        array_push($orders_arr['data'], $order_item);
    }

    echo json_encode($orders_arr);
} else {
    echo json_encode(
        array('message' => 'No Orders Found!')
    );
}