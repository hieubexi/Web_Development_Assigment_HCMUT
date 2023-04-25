<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->connect();

$products = new Product($db);

$result = $products->getAllProducts();

$numRow = $result->rowCount();

if ($numRow > 0) {
    $product_arr = array();
    $product_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $p_item = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'code' => $row['code'],
            'discount' =>$row['discount'],
            'price' => $row['price']
        );

        array_push($product_arr['data'], $p_item);
    }

    echo json_encode($product_arr);
} else {
    echo json_encode(
        array('message' => 'No Products Found!')
    );
}