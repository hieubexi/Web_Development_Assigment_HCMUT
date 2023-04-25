<?php
include("connection/connect.php");
error_reporting(0);
session_start();

$productID = $_GET['productID'];
$sql="SELECT * FROM ratings WHERE product_id = $productID";
$query=mysqli_query($db,$sql);
$product=mysqli_fetch_array($query);

?>
<div class="container">
    <?php
    echo $product['content'];
    ?>

</div>