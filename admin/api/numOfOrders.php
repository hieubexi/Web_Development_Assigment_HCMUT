<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->connect();

$orders = new Order($db);

$result = $orders->getOrdersNum();
$data = $result->fetch(PDO::FETCH_ASSOC);

echo json_encode($data["NUM"]);