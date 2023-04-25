<?php
include("connection/connect.php");
error_reporting(0);
session_start();

$ssql1 = "select * from story where id = 1";
$res1 = mysqli_query($db, $ssql1); 
$story1 = mysqli_fetch_array($res1);


$ssql2 = "select * from story where id='2'";
$res2 = mysqli_query($db, $ssql2); 
$story2 = mysqli_fetch_array($res2);


$ssql3 = "select * from story where id='3'";
$res3 = mysqli_query($db, $ssql3); 
$story3 = mysqli_fetch_array($res3);
?>

<div class ="row text-center " style=" align-items: center; display:float;">
  <h2 style =" font-weight: lighter; ">Story </h2> 

  </div>
<div class="row row-cols-1 row-cols-md-3 g-4 my-preview">

  <div class="col">
    <div class="card h-100 text-center mb-3">
      <a href="#">
      <img src="<?php echo $story1['center_pic']?>" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"><?php echo $story1['title'] ?></h5>
        <!-- <p class="card-text"><?php echo $story1['content'] ?></p> -->
      </div>
      </a>

    </div>
  </div>
  <div class="col">
    <div class="card h-100 text-center mb-3">
      <a href="#">
      <img src="<?php echo $story2['center_pic']?>" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"><?php echo $story2['title'] ?></h5>
        <!-- <p class="card-text"><?php echo $story2['content'] ?></p> -->
      </div>
      </a>

    </div>
  </div>
  <div class="col">
    <div class="card h-100 text-center mb-3">
      <a href="#">
      <img src="<?php echo $story3['center_pic']?>" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title"><?php echo $story3['title'] ?></h5>
        <!-- <p class="card-text"><?php echo $story3['content'] ?></p> -->
      </div>
      </a>

    </div>
  </div>
</div>