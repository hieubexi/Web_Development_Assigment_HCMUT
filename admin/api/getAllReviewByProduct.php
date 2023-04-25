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

$result = $rating->getAllReviewByProduct();

if ($result->rowCount() > 0) {
    $review_data = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $review = array(
            'username' => $row['username'],
            'rate_star' => $row['rate_star'],
            'created_at' => $row['created_at'],
            'content' => $row['content']
        );
        array_push($review_data, $review);
    }
    echo json_encode($review_data);
} else {
    echo json_encode(
        array('message' => 'No Reviews Found!')
    );
}