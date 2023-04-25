<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/Database.php';
include_once '../models/Users.php';

$database = new Database();
$db = $database->connect();

$users = new Users($db);

$result = $users->getUsersNum();
$data = $result->fetch(PDO::FETCH_ASSOC);

echo json_encode($data["NUM"]);