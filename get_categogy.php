<?php
include "./connection/connect.php";

$query = "SELECT * FROM category";

$result = mysqli_query($db, $query);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode($data);
?>