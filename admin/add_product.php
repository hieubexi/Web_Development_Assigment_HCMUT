<!DOCTYPE html>
<html lang="en">
<?php

include("../connection/connect.php");
error_reporting(0);
session_start();



if(isset($_POST['submit']))           //if upload btn is pressed
{
	if(empty($_POST['category_id'])||empty($_POST['name'])||$_POST['code']==''
        ||$_POST['discount']==''||$_POST['price']==''||$_POST['dimension']=='')
		{	
				$error = 	'<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>You must enter all require fields</strong>
				            </div>';
					
		}
	else
	{
       
    
	if($_POST['category_id'] != 1 && $_POST['category_id'] != 2 && $_POST['category_id'] != 3)
     {
    	$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Please enter exactly type!</strong>
															</div>';
     }

    else if(($_POST['discount']) < 0 )
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Discout muse  be > 0% !</strong>
															</div>';
	}
    else if(($_POST['price']) < 0 )
	{
		$error = '<div class="alert alert-danger alert-dismissible fade show">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
																<strong>Price must be > 0 !</strong>
															</div>';
	}
   
	else {
       
        $category_id = $_POST['category_id'];
        $name = $_POST['name'];
        $code = $_POST['code'];
        $image_url = $_POST['image_url'];
        $discount = $_POST['discount'];
        $price = $_POST['price'];
        $dimension = $_POSt['dimension'];
        $mql = "INSERT INTO products(category_id, name, code, image_url, discount, price, dimension, ) 
        
        VALUES ('$category_id','$name','$code','$image_url','$discount','$price','$dimension') ";
        
        mysqli_query($db, $mql);
                $success = 	'<div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Congrass!</strong>Add product succesfully</br></div>';
        
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
    <title>Add product</title>
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
        <!-- End Left Sidebar  -->
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
									<?php  echo $error;
									        echo $success; ?>
	
					    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Add to databse</h4>
                            </div>
                            <div class="card-body">
                                <form action='' method='post'  enctype="multipart/form-data">
                                    <div class="form-body">
                                       
                                        <hr>
                                        <div class="row p-t-20">
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Type of Products</label>
												<select name="category_id" class="form-control custom-select" data-placeholder="Choose type" tabindex="1">
                                                        <option>--Choose type--</option>
                                                 <?php $category ="select * from category";
													$re=mysqli_query($db, $category); 
													while($row1=mysqli_fetch_array($re))  
													{
                                                        echo' <option value="'.$row1['id'].'">'.$row1['name'].'</option>';
													}  
                                                 
													?> 
													 </select>
                                                
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Name</label>
                                                    <input type="text" name="name" class="form-control" placeholder="Enter product's name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Code</label>
                                                    <input type="text" name="code" class="form-control" placeholder="Enter code ">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Image Link</label>
                                                    <input type="text" name="image_url" class="form-control" placeholder="Enter image link">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Discount (%)</label>
                                                    <input type="text" name="discount" class="form-control" placeholder="Enter discout(%)">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Price</label>
                                                    <input type="text" name="price" class="form-control" placeholder="Enter price">
                                                </div>
                                                
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-6">
                                                <div class="form-group has-danger">
                                                    <label class="control-label">Dimesion</label>
                                                    <input type="text" name="dimension" class="form-control form-control-danger" placeholder="Enter available size">
                                                </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    <!--/span-->
                                    </div>
                                    <div class="form-actions">
                                        <input type="submit" name="submit" class="btn btn-success" value="Save"> 
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