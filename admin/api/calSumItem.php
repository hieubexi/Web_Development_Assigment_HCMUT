<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Order.php';
include_once '../models/OrderItems.php';

$database = new Database();
$db = $database->connect();

$orderItems = new OrderItems($db);

$id = isset($_GET['orderId']) ? $_GET['orderId'] : die();

$result = $orderItems->getOrderDetailByOrderId($id);

$numRows = $result->rowCount();

if ($numRows > 0) {
    $sum = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $current_price = ceil($row['price']/1000*(100-$row['discount'])/100)*1000;
        $sum += $row['quantity'] * $current_price;
    }
    $order = new Order($db);
    if ($order->updatePrice($id, $sum)) {
        echo json_encode(
            array('message' => 'Order Updated!', 'sum' => $sum)
        );
    } else {
        echo json_encode(
            array('message' => 'Error When Update Order Invoice!')
        );
    }
} else {
    echo json_encode(
        array('message' => 'No Order Items Found!')
    );
}