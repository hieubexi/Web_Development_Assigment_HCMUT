<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Discounts.php';

$database = new Database();
$db = $database->connect();

$discount = new Discounts($db);

$d_code = isset($_GET['discount_code']) ? $_GET['discount_code'] : die();

$discount->code = $d_code;

$result = $discount->getDiscountByCode();

if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(array(
        "discount" => $row['discount'],
        "code" => $row['code']
    ));
} else {
    echo json_encode(
        array('message' => 'Discount Code is not valid!')
    );
}