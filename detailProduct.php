<?php 
    session_start();
    include("connection/connect.php");
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
<?php
?>
<div class ="container"  style="margin-top:2%; margin-bottom:5%;">
<div  class="row">
<div class ="col-10 mb-5 "> 
    <h4 style="font-weight:lighter"> Products Infomation</h2>
    <hr>
</div>
</div>
        <div class="row" style="margin-top:2%; margin-bottom:5%;">
            <div class ="col-md-5 col-sm-10">
            <div class="card text-bg-dark">
  <img src="<?php echo $product['image_url']?>" class="card-img" alt="image of product">
</div> 
            </div>
            <div class ="col-md-7 col-sm-10">
            
    <h3 class="card-title mb-3"><?php echo $product['name']?> </h2>
    <p class="card-text price mb-3"> Price: <?php echo $product['price']. " $"?></p>
    <p class="card-text discount mb-3"> Discout: <?php echo $product['discount']. " %"?></p>
    <p class="card-text dimension mb-3"> Size:  <?php echo $product['dimension']?></p>
    <p class="card-text =mb-3">  <?php echo $product['description']?></p>
    <?php
    if (empty($_SESSION['username'])){
      $href_cart ="#";
      $href_pay ="#";
      $error ="Your must login for this action!" ;
    }else{
      $href_cart ='addCart.php?productID='.$productID;
      $href_pay ='payment.php?productID='.$productID;
      $error ="";
    }
    ?>
    <button  class="my-button text-center addCart-button" name="addCart">
        <svg class="bi" width="25" height="25" fill="currentColor ">  
        <use xlink:href="bootstrap-icons.svg#cart-plus-fill" /> </svg> 
        <a href="<?php echo $href_cart ?>"  style="color:beige" >Add to cart </a>
    </button>
    <button class="my-button text-center buy-button" name="buyNow">
        <svg class="bi" width="25" height="25" fill="currentColor ">
        <use xlink:href="bootstrap-icons.svg#bag-check-fill" /> </svg>  
        <a href="<?php echo $href_pay ?>" style="color:beige">Buy Now</a>  
    </button>
    <div>
      <p style ="color:red"><?php echo $error ?></p>
    </div>
   
    <div style="margin-top:5px">
    <!-- <span style ="color:red"> <?php echo $error_cart ?></span>
    <span style ="color:green"> <?php echo $succes_cart ?></span> -->
    </div>
        
            </div>
        </div>
        <hr>
        <div class="row mb-3">
        <h4 style="font-weight:lighter"> Feedback from Customer</h2>
           <div class ="col-10">
            <?php
            $sql1="SELECT * FROM ratings WHERE product_id = $productID";
            $query1=mysqli_query($db,$sql1);
           
            while( $product_rating=mysqli_fetch_array($query1)){
                $userId =$product_rating['user_id'] ;
                $sql_user="SELECT * FROM users WHERE id = $userId ";
                $query_user=mysqli_query($db,$sql_user);
                $user =mysqli_fetch_array($query_user);
                echo '
                <div class="card mb-3">
                <div class="card-header">
                  <h4> '.$user['firstname'].' '.$user['lastname'].'</h4> '.
                  $product_rating['rate_star'].' 
                  <svg class="bi" width="25" height="25" fill="currentColor " style=" color:goldenrod; margin-left:5px; padding-bottom:2px;">
                  <use xlink:href="bootstrap-icons.svg#star-fill" />
              </svg>
                </div>
                <div class="card-body">
                  <blockquote class="blockquote mb-0">
                    <p>'.$product_rating['content'].'</p>
                    <footer class="blockquote-footer"> Created at: '.$product_rating['created_at'].'</footer>
                  </blockquote>
                </div>
              </div>
                ';
            }
            // echo $product_rating['content'];
            ?>
           </div>
           
        </div>
        
    </div>



<!-- Here is footer -->
<?php require_once "footer.php" ?>
<!-- Script HERE -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="js/product.js"></script>
</body>
</html>