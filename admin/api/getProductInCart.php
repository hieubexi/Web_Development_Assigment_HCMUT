<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Cart.php';

$database = new Database();
$db = $database->connect();

$cart = new Cart($db);

$user_id = isset($_GET['userId']) ? $_GET['userId'] : die();

$result = $cart->getCartInfo($user_id);

if ($result->rowCount() > 0) {
    $cart_data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $item = array(
            'status' => $row['status'],
            'id' => $row['cart_id'],
            'quantity' => $row['quantity'],
            'p_id' => $row['id'],
            'p_name' => $row['name'],
            'p_author' => $row['author'],
            'p_publisher' => $row['publisher'],
            'p_code' => $row['code'],
            'p_img' => $row['image_url'],
            'p_discount' => $row['discount'],
            'p_price' => $row['price']
        );
        array_push($cart_data, $item);
    }
    echo json_encode($cart_data);
} else {
    echo json_encode(
        array('message' => 'Cart is empty!')
    );
}