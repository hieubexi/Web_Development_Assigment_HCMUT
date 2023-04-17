<?php
session_start(); //temp session
error_reporting(0); // hide undefine index
include("connection/connect.php"); // connection

   if(isset($_POST['check-exits'])){
   $check_username1= mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
      if(empty($_POST['username']) == false && mysqli_num_rows($check_username1) > 0) //check username 
      {
         $message = 'User name already exists';
      }
      else {
         $success ='Yeahh, you can use this username';
      }
   }
   //if submit btn is pressed
  if(isset($_POST['submit'] )) {
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$phone_number = $_POST['phone_number'];
	$repeat_password = $_POST['repeat_password'];
	$address = $_POST['address'];
    if(  //fetching and find if its empty
            empty($username)|| 
            empty($firstname)|| 
   	        empty($lastname)|| 
            empty($email) ||  
            empty($phone_number)||
            empty($password)||
            empty($repeat_password) )
		{
			$message_all = "You must enter all information to registration.";
	}else{
		//cheching username & email if already present
		$check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST	['email']."' ");
		if($password != $repeat_password ){  //matching passwords
    	   	$pass_copy_message = "Password do not match! Please enter the password the same as 	you entered";
   	 	}
		else if(strlen($password) <= 5)  //cal password length
		{
			$pass_long_message = "Password is too short! Please enter more than 5 characters";
		}
		else if(strlen($phone_number) != 10)  //cal phone length
		{
			$phone_message = "Phone number is incorrect! Phone number must be at least 10 characters";
		}
    	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) // Validate email address
    	{
       		$email_valid_message = "Email address is not valid";
    	}
		else if(mysqli_num_rows($check_email) > 0) //check email
     	{
    		$email_exit_message = 'The email address was already exists';
     	}
	//  Success
		else{
	 //inserting values into db
			$mql = "INSERT INTO users(username,firstname,lastname,email,phone_number,password,address,role) 
   			VALUES('".$username."','".$firstname."','".$lastname."',
   			'".$email."','".$phone_number."','".$password."','".$address."','customer')";
			mysqli_query($db, $mql);
			$full_success = "You account is created successfully";
		 	header("refresh:1;url=login.php"); // redireted once inserted success
      	}
	}
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="./image/gucci_logo.png">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/global_component.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="stylesheet" href="./node_modules/bootstrap-icons/icons/">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>
        html, body {
            background-color: white;
        }
    </style>
</head>
<body >
    <!-- Here is header -->
    <?php require_once "header.php" ?>
    <!-- INPUT HERE -->
	<div class="col-md-6 offset-md-3" style="margin-top: 5%; margin-bottom : 5%;">
	<form class="row g-3 cursor-hover " action="" method="post">
    <h1 class="h3 mb-3 fw-normal cursor-hover">Sign Up</h1>
  <div class="col-md-6">
    <label for="firstname" class="form-label">First Name</label>
    <input type="text"  class="form-control" id="firstname" name ="firstname">
  </div>
  <div class="col-md-6">
    <label for="lastname" class="form-label">Last Name</label>
    <input type="lastname" class="form-control" id="lastname" name = "lastname"> 
  </div>
  <div class="col-12">
  <label for="username" class="form-label">User Name</label>
    <input type="username" class="form-control" id="username" name ="username">
	<span style="color:red;"><?php echo  $message ; ?></span>
	<span style="color:green;"><?php echo  $success ; ?></span>
  </div>
  <div class="col-md-6">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name ="password">
	<span style="color:red;"><?php echo  $pass_long_message ; ?></span>
  </div>
  <div class="col-md-6">
    <label for="repeat_password" class="form-label">Confirm Password</label>
    <input type="password" class="form-control" id="repeat_password" name ="repeat_password">
	<span style="color:red;"><?php echo  $pass_copy_message ; ?></span>
  </div>
  <div class="col-12">
    <label for="phone_number" class="form-label">Phone Number</label>
    <input type="text" class="form-control" id="phone_number" name ="phone_number" >
	<span style="color:red;"><?php echo  $phone_message ; ?></span>
  </div>
  <div class ="col-12">
  <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name ="email"
	placeholder="example@address.com">
	<span style="color:red;"><?php echo  $email_exit_message ; ?></span>
	<span style="color:red;"><?php echo  $email_valid_message ; ?></span>
  </div>
  <div class="col-12">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name ="address">
  </div>
  <div class ="col-12">
  <span style="color:red;"><?php echo  $message_all ; ?></span>
  <span style="color:#0F5156;"><?php echo  $full_success ; ?></span>
 
  </div>

  <div class="col-12">
  <input type="submit" class="btn btn-info" name ="check-exits" value ="Check"></input>
    <input type="submit" class="btn btn-primary" name ="submit" value ="Sign Up"> </input>
  </div>
</form>
	</div>
	
<!-- Here is footer -->
<?php require_once "footer.php" ?>
<!-- Script HERE -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>