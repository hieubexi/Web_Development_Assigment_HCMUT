<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->connect();

$cate = new Category($db);

$result = $cate->getNumCategory();
$data = $result->fetch(PDO::FETCH_ASSOC);

echo json_encode($data["NUM"]);