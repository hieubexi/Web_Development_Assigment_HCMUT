<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : die();

$result = $order->getOrderIdById($orderId);

$numRow = $result->rowCount();

if ($numRow > 0) {
    $orderDetail_arr = array();
    $orders_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $order_item = array(
            'userid' => $row['id'],
            'username' => $row['username'],
            'lastname' => $row['lastname'],
            'phone' => $row['phone_number'],
            'address' => $row['address'],
            'code' => $row['code'],
            'discount' => $row['discount'],
            'invoice' => $row['invoice'],
            'status' => $row['status']
        );

        array_push($orders_arr['data'], $order_item);
    }
    echo json_encode($orders_arr);
} else {
    echo json_encode(
        array('message' => 'No Orders Found!')
    );
}
