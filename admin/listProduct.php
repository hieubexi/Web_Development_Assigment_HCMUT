<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/global_component.css"> -->
</head>

<body class="fix-header fix-sidebar">

    <div id="main-wrapper">

        <div class="container" style="margin-top: 5%">
            <!-- Start Page Content -->
            <div class="row">
                <div class="col-2">
                    <ul class="list-group">
                        <li class="list-group-item " aria-current="true">Dashboard</li>
                        <a href="listUser.php" style="text-decoration: none;">
                            <li class="list-group-item ">Manage Users</li>
                        </a>
                        <a href="listProduct.php" style="text-decoration: none;">
                            <li class="list-group-item active">Manage Products</li>
                        </a>
                        <a href="listOrder.php" style="text-decoration: none;">
                            <li class="list-group-item">Manage Orders</li>
                        </a>
                        <a href="logout.php" style="text-decoration: none;">
                            <li class="list-group-item">Log Out</li>
                        </a>
                    </ul>
                </div>
                <div class="col-10">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Dữ liệu sách</h4>
                            <h6 class="card-subtitle">Xuất dữ liệu ra Copy, CSV, Excel, PDF & Print</h6>

                            <div class="table-responsive m-t-40">
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Code</th>
                                            <th>Image</th>
                                            <th>Discount (%)</th>
                                            <th>Price</th>
                                            <th>Dimesion</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Edit/Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php

                                        $sql = "SELECT * FROM products";
                                        $query = mysqli_query($db, $sql);

                                        if (!mysqli_num_rows($query) > 0) {
                                            echo '<td colspan="13"><center>Không có dữ liệu</center></td>';
                                        } else {
                                            while ($rows = mysqli_fetch_array($query)) {
                                                $mql = "select * from products where id=$rows[id]";
                                                $newquery = mysqli_query($db, $mql);
                                                $fetch = mysqli_fetch_array($newquery);


                                                echo '									
													<td>' . $rows['id'] . '</td>
													<td>' . $rows['category_id'] . '</td>
                                                    <td>' . $rows['name'] . '</td>
                                                    <td>' . $rows['code'] . '</td>
                                                    <td>
													<center><img src="' . $rows['image_url'] . '" class="img-responsive  radius" style="max-height:300px;max-width:150px;" /></center>
													</td>
                                                    <td>' . $rows['discount'] . '</td>
                                                    <td>đ.' . $rows['price'] . '</td>
                                                    <td>' . $rows['dimension'] . '</td>
                                                    <td>' . $rows['created_at'] . '</td>
                                                    <td>' . $rows['updated_at'] . '</td>
													<td> 
													<a href="update_book.php?menu_upd='. $rows['category_id'] . '" class="btn btn-info btn-flat btn-addon btn-sm m-b-10 m-l-5"><i class="ti-settings"></i></a>
													<a href="delete_book.php?menu_del='. $rows['id'] . '" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"><i class="fa fa-trash-o" style="font-size:16px"></i></a>
                                                    </td></tr>';
                                            }
                                        }


                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>