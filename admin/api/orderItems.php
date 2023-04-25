<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/OrderItems.php';

$database = new Database();
$db = $database->connect();

$orderItems = new OrderItems($db);

$id = isset($_GET['orderId']) ? $_GET['orderId'] : die();

$result = $orderItems->getOrderDetailByOrderId($id);

$numRows = $result->rowCount();

if ($numRows > 0) {
    $orderItems_arr = array();
    $orderItems_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $orderItem = array(
            'id' => $id,
            'product_id' => $product_id,
            'code' => $code,
            'name' => $name,
            'img' => $image_url,
            'publisher' => $publisher,
            'author' => $author,
            'current_price' => ceil($price/1000*(100-$discount)/100)*1000,
            'quantity' => $quantity
        );

        array_push($orderItems_arr['data'], $orderItem);
    }

    echo json_encode($orderItems_arr);

} else {
    echo json_encode(
        array('message' => 'No Order Items Found!')
    );
}