<!DOCTYPE html>
<html lang="en">
<?php

$message = $success1="";
session_start();
error_reporting(0);
include("../connection/connect.php");

if(isset($_POST['check'])){
    $check_username2= mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."' ");
       if(mysqli_num_rows($check_username2) > 0) //check username
       {
        $message="Tên đăng nhập đã tồn tại";
       }
          
       
       else {
        $success1 = "Tên đăng nhập hợp lệ";
       }
    }
else if(isset($_POST['submit'] ))
{
    if(empty($_POST['username']) ||
   	    empty($_POST['firstname'])|| 
		empty($_POST['lastname']) ||  
		empty($_POST['email'])||
		empty($_POST['password'])||
		empty($_POST['phone_number']) ||
       
        empty($_POST['role']))
		
		{
			$error = '<div class="alert alert-danger alert-dismissible fade show">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Bạn phải điền vào tất cả các ô!</strong>
			</div>';
		}
	else
	{
           
	$check_email = mysqli_query($db, "SELECT email FROM users where email = '$_POST[email]' ");
    $check_username = mysqli_query($db, "SELECT username FROM users where username = '$_POST[username]' ");
	
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
    {
       	$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Email không hợp lệ!</strong>
															</div>';
    }
	elseif(strlen($_POST['password']) < 6)
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Mật khẩu phải nhiều hơn 5 ký tự</strong>
															</div>';
	}
	
	elseif(strlen($_POST['phone_number']) != 10)
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Số điện thoại không hợp lệ</strong>
															</div>';
	}
    elseif(mysqli_num_rows($check_username) > 0)
     {
    	$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Tên đăng nhập này đã tồn tại</strong>
															</div>';
     }
	
	elseif(mysqli_num_rows($check_email) > 0)
     {
    	$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Địa chỉ email này đã tồn tại</strong>
															</div>';
     }
	else {
       
	
	$mql = "INSERT INTO users(username,firstname,lastname,email,phone_number,password,address,role) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."',
    '".$_POST['email']."','".$_POST['phone_number']."','".password_hash("$_POST[password]", PASSWORD_BCRYPT)."','".$_POST['address']."','".($_POST['role'])."')";
	mysqli_query($db, $mql);
			$success = 	'<div class="alert alert-success alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Chúc mừng!</strong> Tài khoản được tạo thành công.</br></div>';
	
    }
    
}

}


?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../image/gucci_logo.png">
    <title>Add user</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header" >
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">         
        <?php include 'header.php'?>
        <?php include 'left_sidebar.php'?>
        <!-- Page wrapper  -->
        <div class="page-wrapper" style="height:1200px;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                <h3 style ="font-weight:bolder; color :brown">Dashboard</h3> </div>
               
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                     <div class="row">
                   
                   
					
					 <div class="container-fluid">
                <!-- Start Page Content -->

									<?php  //echo var_dump($_POST);
									        echo $error;
                                            echo $success;
									        ?>
	
					    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add user</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                       
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Username</label>
                                                    <input id="username" value="<?php echo $_POST['username']?>"type="text" name="username" class="form-control" placeholder="Enter username">
                                                   </div>
                                                   <p style="color:red; font-weight:600"><?php echo $message?></p>
                                                   <p style="color:green; font-weight:600"><?php echo $success1?></p>
                                                   <p> <input type="submit" name="check" value="Check" class="btn btn-danger"></input>
                                                   
                                                </div>
                                            
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Last Name</label>
                                                    <input type="text" style="text-transform: capitalize;" name="firstname" class="form-control form-control-danger" placeholder="Enter Lastname">
                                                    </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        
                                        <!--/row-->
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Fist Name</label>
                                                    <input style="text-transform: capitalize;" type="text" name="lastname" class="form-control" placeholder="Enter first name">
                                                   </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" name="email" class="form-control form-control-danger" placeholder="example@gmail.com">
                                                    </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
										 <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Password</label>
                                                    <input type="password" name="password" class="form-control form-control-danger" placeholder="Password">
                                                    </div>
                                                </div>
                                        
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Phone Number</label>
                                                    <input type="text" name="phone_number" class="form-control form-control-danger" placeholder="Enter Phone number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="control-label">Address</label>
                                                    <input style="text-transform: capitalize;" type="text" name="address" class="form-control form-control-danger" placeholder="Enter Address">
                                                    </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Role</label><br>
                                                        <select style="font-size:medium; padding: 9px; border:1px solid rgb(232,232,232); color:rgb(80,80,80)" name = "role" aria-label="select example">
                                                            <option value="admin">admin</option>
                                                            <option value="customer" selected>customer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                        
                                      
                                      
                                            <!--/span-->
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-primary" value="Save"> 
                                        <a href="dashboard.php" class="btn btn-inverse">Exit</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2022 All rights reserved. </footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    

</body>

</html>