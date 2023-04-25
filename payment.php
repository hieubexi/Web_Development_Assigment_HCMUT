<?php 
    session_start();
    // error_reporting(0);
    include("connection/connect.php");
// get Product
    $productID = $_GET['productID'];
    $sql="SELECT * FROM products WHERE id = $productID";
    $query=mysqli_query($db,$sql);
    $product=mysqli_fetch_array($query);
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
<?php
    if(isset($_POST['submit'])){
      if(empty($_POST['quantity']) || empty($_POST['paymentMethod'])){
          $error_all ="You must enter all required fields";
      }
      else{
        $status ="Packaging";
       $total = $product['price']*$_POST['quantity']* (1 - $product['discount']/100);
       $mql ="INSERT INTO `orders`( `code`, `user_id`, `product_id`, `quantity`, `invoice`, `status`, `payment`) VALUES ('".rand(5000,1000)."','".$user['id']."','".$product['id']."','".$_POST['quantity']."','".$total."','".$status."','".$_POST['paymentMethod']."')";
     mysqli_query($db, $mql);
     $delete_mql= "DELETE FROM `carts` WHERE `user_id`=".$user['id']." AND `product_id`=".$product['id'];
     mysqli_query($db, $delete_mql);
     $full_success = "Thank you for order! Hope you enjoy your order";
     $mess="Back to homepage";
      }
    }
?>
<div class = "container" >
<div class ="col-10 mb-5 " style="margin-top:2%; "> 
  
    <hr>
</div>
<div class="row g-5"style=" margin-bottom:5%;">
      <div class="col-md-5 col-lg-4 order-md-last cursor-hover">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-success">Your cart</span>
          <span class="badge bg-info rounded-pill"> <?php  echo $_POST['quantity']." "  ." products"?> </span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0"><?php echo $product['name']; ?></h6>
            </div>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
            <h6 class="my-0">Price</h6>
            </div>
          
          <span class="text-body-secondary"><?php echo '$'.$product['price']; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between bg-body-tertiary">
            <div class="text-success">
              <h6 class="my-0">Discount</h6>
            </div>
            <span class="text-success"> <?php echo $product['discount'].'%'; ?></span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <span >Total (USD)</span>
            <strong style="color:brown"><?php 
             $total = $product['price'] *$_POST['quantity'] * ( 100 - $product['discount'] )/100;
            echo '$'.$total; ?></strong>
          </li>
        </ul>
      </div>

      <div class="col-md-7 col-lg-8 cursor-hover">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation cursor-hover" novalidate=""  action="" method="post">
          <div class="row g-3 cursor-hover">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control" id="firstName" name ="firstname" placeholder="" value="<?php echo $user['firstname']?>" required="">
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lastName" name="lastname" placeholder="" value="<?php echo $user['lastname']?>" required="">
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>
            <div class="col-12 cursor-hover">
            <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Username" required="" value ="<?php echo $user['username']?>">
              <div class="invalid-feedback">
                Please enter a username.
              </div>
            </div>
            <div class="col-12 cursor-hover">
              <label for="email" class="form-label">Email <span class="text-body-secondary">(Optional)</span></label>
              <input type="email" class="form-control" id="email"  name="email" placeholder="you@example.com" value ="<?php echo $user['email']?>">
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name ="address" placeholder="1234 Main St" value ="<?php echo $user['address']?>"required="">
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address 2 <span class="text-body-secondary">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>
          </div>
          <hr class="my-4">
          <h4 class="mb-3 cursor-hover">Number of Product</h4>
          <div class="col-12 cursor-hover">
              <input type="number" class="form-control" id="quantity" placeholder="Quantity" name ="quantity"  value ="<?php echo $_POST['quantity']?>" >
              <div class="invalid-feedback">
                Please enter the number of products.
              </div>
            </div>
          <hr class="my-4">

          <h4 class="mb-3 cursor-hover">Payment</h4>
          <div class="col-12">
              <label for="paymentMethod" class="form-label">Payment Method <span class="text-body-secondary">(Optional)</span></label>
              <input type="text" class="form-control" id="paymentMethod" placeholder="We only except pay in delivery" name ="paymentMethod" value ="<?php echo $_POST['paymentMethod']?>">
              <small> You can type "By cash" or "By Paypal" but we only except pay on delivery</small>
            </div>
          <hr class="my-4">
          <div class="mb-3">
          <span style ="color:red"> <?php echo $error_all?></span>
          <span style ="color:green"> <?php echo $full_success?></span>
          <a href="home.php"> <span style ="color:darkblue;"> <?php echo $mess?></span></a>
         
          </div>
          <div class ="col-lg-5 col-md 10">
          <input class="w-100 my-button buy-button" type="submit" name ="submit"></input>
          </div>
        </form>
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