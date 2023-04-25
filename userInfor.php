<?php
session_start();
error_reporting(0);
include("connection/connect.php");

$ssql = "select * from users where username='$_SESSION[username]'";
$res = mysqli_query($db, $ssql);
$user = mysqli_fetch_array($res);

$oldPassword = $user['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email =  $_POST['email'];
$address = $_POST['address'];
$phone_number =   $_POST['phone_number'];
$condition_password = $_POST['condition_password'];
$repeat_password = $_POST['repeat-password'];
$password = $_POST['password'];

if (isset($_POST['submit'])) {
    if (
        empty($firstname) &&
        empty($lastname) &&
        empty($email) &&
        empty($address) &&
        empty($phone_number)
    ) {
        $error_empty = "You must enter all required fields";
    }  
    else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
        {
            $error_email = "Email address is not valid";
        } else if (strlen( $_POST['phone_number']) < 10) {
            $error_phone = "Phone number is incorrect! Phone number must be at least 10 characters";
        } else { 
            if (empty($firstname)){
                $firstname = $user['firstname'];
            } else if (empty($lastname)){
                $lastname = $user['lastname'];
            } else if (empty($address)){
                 $address = $user['address'];
            }else if (empty($phone_number)){
                $phone_number = $user['phone_number'];
            }else if(empty($address)){
                $address = $user['address'];
            }
            $mql = "UPDATE users SET firstname='$firstname', lastname='$lastname',email='$email',
    phone_number='$phone_number',address='$address' where username='$_SESSION[username]' ";
            mysqli_query($db, $mql);
            $success_update = "Your information has been updated";
        }
    }
} else if (isset($_POST['change-password'])) {
    if (empty($password) || empty($condition_password) || empty($repeat_password)) {
        $error_password = "Please enter all required fields";
    } else {
        if ($condition_password != $user['password']) {
            $error_old_password = "Your old password is incorrect!";
        } else if (strlen($password) < 6) {
            $error_long_pass = "Password is too short! Please enter more than 5 characters";
        } else if ($repeat_password != $password) {
            $error_repeat_password = "Password do not match! Please enter the password the same as you entered";
        } else {
            $mql = "UPDATE users SET password ='$_POST[password]' where username='$_SESSION[username]' ";
            mysqli_query($db, $mql);

           
            $success = "Your password change successful";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="./image/gucci_logo.png">
    <title>@GUXXI - Your Account </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/global_component.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/icons/">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
    <style>

    </style>
</head>

<body class="col-12">
    <?php include_once "header.php" ?>

        <!-- Page wrapper  -->
        <div class="container" style="margin-top :30px">
            <div class="row g-5">
                <div class="col-md-10 col-lg-4 col-sm-12">
                    <!-- HERE is PROFILE INFORMATION -->
                    <div class="card " style="width: 90%; background:none;">
                        <img src="<?php echo $user['profile_img'] ?>" class="card-img-top" style=" border-radius:50%;  max-content:100 px" alt="profile-picture" >
                        <div class="card-body ">
                            <h5 class="card-title" style="color:#212A3E"><?php echo $user['firstname'] . " " . $user['lastname'] ?></h5>
                            <hr>
                            <p class="card-text"> <svg class="bi" width="25" height="25" fill="currentColor ">
                                    <use xlink:href="bootstrap-icons.svg#person-badge-fill" />
                                </svg> <?php echo $user['username'] ?> </p>
                            <p class="card-text"><svg class="bi" width="25" height="25" fill="currentColor">
                                    <use xlink:href="bootstrap-icons.svg#telephone-fill" />
                                </svg> <?php echo $user['phone_number'] ?> </p>
                            <p class="card-text"><svg class="bi" width="25" height="25" fill="currentColor">
                                    <use xlink:href="bootstrap-icons.svg#envelope-fill" />
                                </svg> <?php echo $user['email'] ?></p>
                            <p class="card-text"><svg class="bi" width="25" height="25" fill="currentColor">
                                    <use xlink:href="bootstrap-icons.svg#house-fill" />
                                </svg> <?php echo $user['address'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 col-sm-12">
                    <!-- HERE is SETTING account -->
                    <h4 class="mb-3 cursor-hover">Account settings</h4>
                    <form class="needs-validation cursor-hover" action="" method="post">
                    <div class="form-floating mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="First Name" name="firstname" value ="<?php echo $_POST['firstname']?>">
                                <label for="floatingInput">First Name</label>
                                <p style="color :red"> <?php echo $error_firstName ?></p>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Last Name" name="lastname" value ="<?php echo $_POST['lastname']?>">
                                <label for="floatingInput">Last Name</label>
                                <p style="color :red"> <?php echo $error_lastName ?></p>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="PhoneNumber" name="phone_number" value ="<?php echo $_POST['phone_number']?>">
                                <label for="floatingInput">Phone Number</label>
                                <p style="color :red"> <?php echo $error_phone ?></p>
                            </div>
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingInput" placeholder="example@address.com" name="email" value ="<?php echo $_POST['email']?>">
                                <label for="floatingInput">Email</label>
                                <p style="color :red"> <?php echo $error_email ?></p>
                            </div>
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Address" name="address" value ="<?php echo $_POST['address']?>">
                                <label for="floatingInput">Address</label>
                                <p style="color :red"> <?php echo $error_address?></p>
                            </div>
                            <div class="mb-3" style="margin-left:5px">
                            <span style="color :green"> <?php echo $success_update ?></span>
                           <span style="color :red"> <?php echo  $error_empty?></span> 
                            </div>
                            <div class="col-lg-5 col-md-10">
                            <input class="my-button update-button w-100" type="submit" name="submit" value="Update Infomation"></input>
                            </div>
                            
                        </div>
                    </form>
                    <hr>
                     <!-- HERE is CHANGE PASSWORD -->
                    <h4 class="mb-3 cursor-hover">Change Password</h4>
                    <form class="needs-validation cursor-hover" action="" method="post">
                        <div class="form-floating mb-3">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="condition_password">
                                <label for="floatingPassword">Enter your old password</label>
                                <p style="color :red"> <?php echo $error_old_password ?></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                                <label for="floatingPassword">Enter your new password</label>
                                <p style="color :red"> <?php echo $error_long_pass ?></p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="repeat-password">
                                <label for="floatingPassword">Confirm new password</label>
                                <p style="color :red"> <?php echo $error_repeat_password ?></p>
                            </div>
                            <div class="mb-3" style="margin-left:5px">
                                <p style="color :red"> <?php echo $error_password ?></p>
                                <p style="color :green"> <?php echo $success ?></p>
                            </div>
                            <div class="col-lg-5 col-md-10">
                            <input class="my-button confirm-button w-100" type="submit" name="change-password" value="Change"></input>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
      require_once("footer.php");
      ?>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>


</body>

</html>