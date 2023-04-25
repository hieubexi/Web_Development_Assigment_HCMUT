<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Ratings.php';

$database = new Database();
$db = $database->connect();

$rating = new Ratings($db);

$product_id = isset($_GET['productId']) ? $_GET['productId'] : die();

$rating->product_id = $product_id;

$result = $rating->getAvgStarByProduct();

if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);

    echo json_encode(
        array('avg_star' => $row['AVG_STAR'])
    );
} else {
    echo json_encode(
        array('message' => 'No Rating Detail Found!')
    );
}