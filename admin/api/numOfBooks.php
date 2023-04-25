<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Product.php';

$database = new Database();
$db = $database->connect();

$products = new Product($db);

$result = $products->getAllProductCount();
$data = $result->fetch(PDO::FETCH_ASSOC);

echo json_encode($data["NUM"]);