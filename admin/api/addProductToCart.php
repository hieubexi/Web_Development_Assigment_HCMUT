<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Cart.php';

$database = new Database();
$db = $database->connect();

$cart = new Cart($db);

// $data = {
//     "user_id": "1",
//     "product_id": "2",
//     "quantity": "2"
// }

$data = json_decode(file_get_contents("php://input"), true);

$cart->user_id = $data['user_id'];
$cart->product_id = $data['product_id'];
$cart->qty = $data['quantity'];

$checkExistCartItem = $cart->checkExistCartItem();

if ($checkExistCartItem->rowCount() > 0) {
    $row = $checkExistCartItem->fetch(PDO::FETCH_ASSOC);
    $cart->id = $row['id'];
    $cart->qty = (int)$data['quantity'] + $row['quantity'];
    if($cart->updateProductInCart()) {
        echo json_encode(
            array('message' => 'Update Product To Cart Success!')
        );
    }
} else {
    if ($cart->addProductToCart()) {
        echo json_encode(
            array('message' => 'Add Product To Cart Success!')
        );
    } else {
        echo json_encode(
            array('message' => 'Add Product To Cart Fail!')
        );
    };
}

