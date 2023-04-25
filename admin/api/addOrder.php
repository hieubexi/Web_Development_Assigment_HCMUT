<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../models/OrderItems.php';
include_once '../models/Order.php';

$database = new Database();
$db = $database->connect();

$order = new Order($db);

$data = json_decode(file_get_contents("php://input"), true);

// $data = {
//     "user_id": "1",
//     "discount":"0.0",
//     "invoice": "100000",
//     "status": "Processing",
//     "items": [
//         {
//             "product_id": "1",
//             "quantity": "2"
//         }, 
//         {
//             "product_id": "3",
//             "quantity": "1"
//         }
//     ]
// }

$order->user_id = $data["user_id"];
$order->discount = $data["discount"];
$order->invoice = $data["invoice"];
$order->status = $data["status"];
$items = $data["items"];
$order->code = $order->genCode();
$orderId = $order->addOrder();
if ($orderId) {
    $result = $order->getOrderIdByCode($order->code);
    $data = $result->fetch(PDO::FETCH_ASSOC);
    $id = $data['id'];
    if (count($items) > 0) {
        for ($i = 0; $i < count($items); $i++) {
            $item = new OrderItems($db);
            $item->order_id = $id;
            $item->product_id = $items[$i]["product_id"];
            $item->quantity = $items[$i]["quantity"];
            if ($item->addOrderItems()) {
                continue;
            } else {
                echo json_encode(
                    array(
                        'message' => 'Order Items Not Created!','id' => $orderId)
                );
                break;
            }
        }
    }
    echo json_encode(
        array('message' => 'Order Created!','id' => $orderId)
    );
} else {
    echo json_encode(
        array('message' => 'Order Not Created!')
    );
}