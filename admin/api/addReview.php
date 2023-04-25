<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/Ratings.php';

$database = new Database();
$db = $database->connect();

$review = new Ratings($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data = {
//     "user_id": "1",
//     "rate_star": "5",
//     "product_id": "1",
//     "content": "asdaosidnxzcnlkzxkc"
// }
if ($data['rate_star'] == "") {
    echo json_encode(
        array('error' => 'Star was empty!')
    );
}
if ($data['content'] == "") {
    echo json_encode(
        array('error' => 'Star was empty!')
    );
}

if ($data['user_id'] == "") {
    echo json_encode(
        array('error' => 'User_id is empty!')
    );
}

if ($data['product_id'] == "") {
    echo json_encode(
        array('error' => 'Product_id is empty!')
    );
}
if ($data['rate_star'] != "" && $data['product_id'] != "" && $data['user_id'] != "" && $data['content'] != "") {
    $review->product_id = $data['product_id'];
    $review->user_id = $data['user_id'];
    $review->rate_star = $data['rate_star'];
    $review->content = $data['content'];

    $result = $review->addReview();
    if ($result != 0) {
        echo json_encode(
            array('rating_id' => $result)
        );
    } else {
        echo json_encode(
            array('message' => 'Review is not Created!')
        );
    }
}


