<?php
include("connection/connect.php");
error_reporting(0);
session_start();
// Get category
$categoryID = $_GET['categoryID'];
$sql_cate="SELECT * FROM category WHERE id= $categoryID";
$query_cate=mysqli_query($db,$sql_cate);
$categoryType=mysqli_fetch_array($query_cate);

// Get products in category
$sql="SELECT * FROM products WHERE category_id= $categoryID";
$query=mysqli_query($db,$sql);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="./image/gucci_logo.png">
    <title>@GUXXI Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/global_component.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="stylesheet" href="./node_modules/bootstrap-icons/icons/">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- HERE is header -->
    
<?php include 'header.php';?>
<div class ="container" style ="margin-top:2%; margin-bottom:5%">
<div class ="row text-center" style ="margin-bottom:20px;">
    <h2><?php echo $categoryType['name']. " Collection"?></h2>
</div>
    <div class ="row">
    <?php
while($rows=mysqli_fetch_array($query))
{   
    echo '
    <div class="col-md-4 col-sm-10 mb-3" >
    <div class="card text-bg-dark border-none my-card" >
    <a href="detailProduct.php?productID='.$rows['id'].'">
          <img  src="'.$rows['image_url'].'" class="card-img-top my-img" alt="image_of_product">
          <div class="card-img-overlay">
          <h5 class="card-title">'.$rows['name'].'</h5>
          <p class="card-text"> '. $rows['price'].' $ </p>
  </div></a>
      </div>
    </div>
';
    }
?> 
    </div>
</div>


    <!-- Here is body -->

<!-- Here is footer -->
  <?php include 'footer.php';?>
<!-- Script HERE -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="js/category.js"></script>
<script src="js/foodpicky.min.js"></script>
<script src="js/pagination.js"></script>
</body>
</html>