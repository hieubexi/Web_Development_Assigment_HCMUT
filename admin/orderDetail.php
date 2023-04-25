<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();

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
    <title>Detail of Orders</title>
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

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <?php include_once './header.php'; ?>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <?php include_once './left_sidebar.php'; ?>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-9">
                                        <h3 style="margin-left: 10px;">Place order</h3>
                                    </div>
                                    <div class="col-3 justify-content-end">
                                        <button id="create_btn" class="btn btn-success mr-2" type="button">Create order</button>
                                        <button id="update_btn" class="btn btn-warning mr-2" type="button">Update</button>
                                        <button id="back_btn" class="btn btn-secondary" type="button">Back</button>

                                    </div>
                                    <!-- <div class="col-2">
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <h4 class="col-sm-8 card-title">Customer Information</h4>
                                    <button id="update_user_btn" class="btn btn-info col mr-3" type="button">Edit information</button>
                                </div>
                                <form action="">
                                    <div class="form-group row">
                                        <label for="username" class="col-sm-3 col-form-label">User</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="username" placeholder="enter username" disabled>
                                            <!-- <span class="check_success"><i class="fa fa-check-circle"></i></span> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lName" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="lName" placeholder="name" disabled>

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="address" placeholder="address" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-sm-3 col-form-label">Phone number</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="phone" placeholder="Enter Phone Number" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <h4 class="col-sm-9 card-title">Order Infomation</h4>
                                    <!-- <button id="update_order_btn" class="btn btn-info col mr-3" type="button">Chỉnh sửa thông tin</button> -->
                                </div>
                                <form action="">
                                    <div class="form-group row">
                                        <label for="code" class="col-sm-3 col-form-label">Code</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="code" placeholder="Code" disabled>
                                            <!-- <small style="color: red;">(*) Some thing went wrong!</small> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="discount" class="col-sm-3 col-form-label">Discount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="discount" placeholder="Discount(%)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="sum" class="col-sm-3 col-form-label">Total</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="sum" placeholder="Total" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select id="status" class="form-control">
                                                <option value="Processing">Processing</option>
                                                <option value="Accepted">Accepted</option>
                                                <option value="Received">Received</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <h3 class="card-title mb-4">List products</h3>
                            <div class="card-body mb-4">
                                <div class="row">
                                    <div class="col-1">
                                        <strong>No.</strong>
                                    </div>
                                    <div class="col-5">
                                        <strong>Product information</strong>
                                    </div>
                                    <div class="col-2">
                                        <strong>Cost</strong>
                                    </div>
                                    <div class="col-2">
                                        <strong>Number</strong>
                                    </div>
                                    <div class="col-2">
                                        <strong>Total</strong>
                                    </div>
                                </div>

                                <div class="orderItemList" style="margin-top: 25px;">

                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-4">
                                        <select id="product_select" class="form-control">
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <input id="qty_item" class="form-control" type="number" placeholder="Quantity" min="1" value='1'>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" id="addProduct" class="btn btn-primary">Add product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End PAge Content -->
    </div>
    <!-- End Container fluid  -->




    <!-- footer -->
    <footer class="footer"> © 2018 All rights reserved. Template designed by <a href="https://colorlib.com">Colorlib</a></footer>
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
    <script src="js/orderInfo.js"></script>


    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>
</body>

</html>