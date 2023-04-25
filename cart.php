<?php 
    session_start();
    include("connection/connect.php");
// get Product
  
// Get user
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="./image/gucci_logo.png">
    <title>@GUXXI</title>
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
    <!-- Here is header -->
<?php require_once "header.php" ?>
<!-- Here is banner -->
<div class ="container" style ="margin-top:2%; margin-bottom:5%">
<!-- HERE is cart -->
<div class ="row" style ="margin-bottom:20px;">
    <h3 style ="color:  #01414b;"><?php echo $user['firstname']." ".$user['lastname']. "'s Cart";?></h3>
     <hr>
     <?php
      $userID = $user['id'] ;
      // Get cart
      $sql_cart="SELECT * FROM `carts` WHERE user_id = $userID";
      $query_cart=mysqli_query($db,$sql_cart);

      while($cart=mysqli_fetch_array($query_cart)){
        // Get product
        $productID = $cart['product_id'];
        $sql_product="SELECT * FROM `products` WHERE id = $productID";
        $query_product=mysqli_query($db,$sql_product);
        $product=mysqli_fetch_array($query_product) ;

        echo '
        <div class="card mb-3 col-12 my-card" style="background:none;">
        <div class="row g-0">
          <div class="col-md-4">
          <a href="detailProduct.php?productID='.$productID.'"> <img src="'. $product['image_url'].'" class="img-fluid rounded-start" alt="image_of_product"></a>
</div>
          <div class="col-md-8">
            <div class="card-body">
            <small class="card-text"> <strong>Date:</strong>  '.$cart['created_at'].'</small>
            <hr>
              <h5 class="card-title"style="color: #01414b;font-weight:bolder;"> Item Infomation </h5>
              <p class="card-text"> <strong>Name:</strong>  '.$product['name'].'</p>
              <p class="card-text"> <strong>Price:</strong> $'.$product['price'].' <strong>Discount:</strong> '.$product['discount'].'%</p>
              <button class="my-button text-center buy-button" name ="buyNow"><svg class="bi" width="25" height="25" fill="currentColor ">
              <use xlink:href="bootstrap-icons.svg#bag-check-fill" /> </svg>  <a href="payment.php?productID='.$productID.'" style="color:beige">Buy Now</a>  </button>
            </div>
          </div>
        </div>
      </div> ';
      
      }
     ?>
<!-- HERE is bought item -->
<div class ="row " style ="margin-bottom:20px; margin-top:5%">
    <h3 style ="color: #4b0101;"><?php echo $user['firstname']." ".$user['lastname']. "'s List orders";?></h3> 
</div> 
<hr>
    <div class ="row">
      <?php
           
            $sql="SELECT * FROM `orders` WHERE user_id = $userID";
            $query=mysqli_query($db,$sql);

      while($row=mysqli_fetch_array($query)){
      //  Get product
        $productID = $row['product_id'];
        $sql_product="SELECT * FROM `products` WHERE id = $productID";
        $query_product=mysqli_query($db,$sql_product);
        $product = mysqli_fetch_array($query_product) ;


      // Get order 
      $orderID = $row['id'];
      $sql_order="SELECT * FROM `orders` WHERE id = $orderID";
      $query_order=mysqli_query($db,$sql_order);
      $order=mysqli_fetch_array($query_order) ;
        echo '
        <div class="card mb-3 col-12 my-card" style="background:none;">
        <div class="row g-0">
          <div class="col-md-4">
          <a href="detailProduct.php?productID='.$productID.'"> <img src="'. $product['image_url'].'" class="img-fluid rounded-start" alt="image_of_product"></a>
</div>
          <div class="col-md-8">
            <div class="card-body">
            <small class="card-text"> <strong>Date:</strong>  '.$order['created_at'].'</small>
            <hr>
              <h5 class="card-title" style="color: #01414b;font-weight:bolder;">Customer Infomation</h5> 
              <p class="card-text"> <strong>Name:</strong>  '.$user['firstname'].' '.$user['lastname'].'</p>
              <p class="card-text"> <strong>Phone number:</strong> '.$user['phone_number'].'</p>
              <p class="card-text"> <strong>Address:</strong> '.$user['address'].'</p>
              <hr>
              <h5 class="card-title"style="color: #01414b;font-weight:bolder;"> Order Infomation </h5>
              <p class="card-text"> <strong>Name:</strong>  '.$product['name'].'</p>
              <p class="card-text"> <strong>Code:</strong> '.$product['code'].'  <strong>Quantity:</strong> '.$row['quantity'].'</p>
              <p class="card-text"> <strong>Price:</strong> $'.$product['price'].' <strong>Discount:</strong> '.$product['discount'].'%</p>
              <p class="card-text"> <strong>Total: <span style="color: #4b0101"> $'.$product['price']*$row['quantity']*(1 - $product['discount']/100).'</span></strong></p>
              <p class="card-text"> <strong>Status:</strong>  '.$order['status'].'</p>
            </div>
          </div>
        </div>
      </div> ';
      }
      ?>
    </div>


    
</div>
</div>




<!-- Here is footer -->
<?php require_once "footer.php" ?>
<!-- Script HERE -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>