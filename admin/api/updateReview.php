<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Ratings.php';

$database = new Database();
$db = $database->connect();

$review = new Ratings($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data = {
//     "id": "1",
//     "rate_star": "5",
//     "content": "asdaosidnxzcnlkzxkc"
// }

$review->id = $data['id'];
$review->rate_star = $data['rate_star'];
$review->content = $data['content'];

if ($review->updateReview()) {
    echo json_encode(
        array('message' => 'Reviews Updated!')
    );
} else {
    echo json_encode(
        array('message' => 'Reviews Not Updated!')
    );
}