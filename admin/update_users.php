<!DOCTYPE html>
<html lang="en">
<?php
session_start();
error_reporting(0);
include("../connection/connect.php");

if(isset($_POST['submit'] ))
{
    if(
        empty($_POST['firstname'])|| 
		empty($_POST['lastname']) ||  
		empty($_POST['email'])||
		empty($_POST['password'])||
        empty($_POST['address'])||
        empty($_POST['role'])||
		empty($_POST['phone_number']))
        
		{
            
			$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Bạn phải điền vào tất cả các ô!</strong>
															</div>';
		}
	else
	{
    $check_username = mysqli_query($db, "SELECT username FROM users where username = '$_POST[username]' ");

    
	
	
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
    {
       	$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Email không hợp lệ!</strong>
															</div>';
    }
	else if(strlen($_POST['password']) < 6)
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Mật khẩu phải có nhiều hơn 5 ký tự!</strong>
															</div>';
	}
	
	else if(strlen($_POST['phone_number']) != 10)
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Số điện thoại không hợp lệ!</strong>
															</div>';
	}
    else if($_POST['password'] != $_POST['cpassword']){  //matching passwords
        $error = '<div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Mật khẩu chưa chính xác! Vui lòng nhập lại</strong>
        </div>';
    }
	
	else{
       
	
	$mql = "update users set firstname='$_POST[firstname]', lastname='$_POST[lastname]',email='$_POST[email]',
    phone_number='$_POST[phone_number]',password='".password_hash("$_POST[password]", PASSWORD_BCRYPT)."',address='$_POST[address]',
     role='$_POST[role]' where id='$_GET[user_upd]' ";
	mysqli_query($db, $mql);
			$success = 	'<div class="alert alert-success alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Tài khoản cập nhật thành công</strong></div>';
	
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
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon1.png">
    <title>Cập nhật tài khoản</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">


        <!-- header header  -->
        <?php include 'header.php'?>
        <?php include 'left_sidebar.php'?>


        <!-- Page wrapper  -->
        <div class="page-wrapper" style="height:1200px;">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
               
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                     <div class="row">
                   
                   
					
					 <div class="container-fluid">
                <!-- Start Page Content -->
							
									<?php  
									        echo $error;
									        echo $success; 
									?>	
					    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Cập nhật tài khoản</h4>
                            </div>
                            <div class="card-body">
							  <?php $ssql ="select * from users where id='$_GET[user_upd]'";
									$res=mysqli_query($db, $ssql); 
									$newrow=mysqli_fetch_array($res);
                                ?>
                                <form action='' method='post'  >
                                    <div class="form-body">
                                    <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Tên đăng nhập</label>
                                                    <input disabled type="text" name="username" class="form-control" value="<?php  echo $newrow['username']; ?>">
                                                   </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Họ và tên lót</label>
                                                    <input type="text" name="firstname" class="form-control form-control-danger"  value="<?php  echo $newrow['firstname'];  ?>" placeholder="jon">
                                                    </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Tên</label>
                                                    <input type="text" name="lastname" class="form-control" placeholder="doe"  value="<?php  echo $newrow['lastname']; ?>">
                                                   </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Email</label>
                                                    <input type="text" name="email" class="form-control form-control-danger"  value="<?php  echo $newrow['email'];  ?>" placeholder="example@gmail.com">
                                                    </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                        <!--/row-->
										
                                        <div class= "row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Địa chỉ</label>
                                                    <input type="text" name="address" class="form-control form-control-danger"   value="<?php  echo $newrow['address'];  ?>" placeholder="Địa chỉ">
                                                    </div>
                                                </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Số điện thoại</label>
                                                    <input type="text" name="phone_number" class="form-control form-control-danger" value="<?php  echo $newrow['phone_number'];  ?>" placeholder="Số điện thoại">
                                                    
                                                </div> 
                                            </div>
                                            </div>
                                        
                                            <div class = "row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Vai trò</label><br>
                                                    <select style="font-size:medium; padding: 8px; border:1px solid rgb(232,232,232); color:rgb(80,80,80)" name = "role" aria-label="select example">
                                                    <?php $user ="select * from users";
													$re=mysqli_query($db, $user); 
                                                   
                                                    
													while($row1=mysqli_fetch_array($re))  
													{
                                                        if ($_GET['user_upd'] == $row1['id']){
                                                            $selectStr = 'selected'; 
                                                                                                         
                                                            echo' <option '.$selectStr.' >'.$row1['role'].'</option>';
                                                            if($row1['role']=='admin') echo' <option>customer</option>';
                                                            else echo '<option>admin</option>';
                                                        }
													}  
                                                 
													?> 
                                                    </select>
                                                </div>
                                                
                                                </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Mật khẩu</label>
                                                    <input type="password" name="password" class="form-control form-control-danger"   value="" placeholder="Nhập Mật khẩu">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Nhập lại Mật khẩu</label>
                                                    <input type="password" name="cpassword" class="form-control form-control-danger"   value="" placeholder="Nhập lại Mật khẩu">
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-success" value="Cập nhật"> 
                                        <a href="allusers.php" class="btn btn-inverse">Hủy</a>
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
</body>

</html>