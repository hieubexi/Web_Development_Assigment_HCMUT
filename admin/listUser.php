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

<div class="container-fluid" style="margin-top: 5%">
        <!-- Start Page Content -->
        <div class="row">
            <div class ="col-2">
            <ul class="list-group">
  <li class="list-group-item " aria-current="true">Dashboard</li>
  <a href="listUser.php" style="text-decoration: none;"><li class="list-group-item active" >Manage Users</li></a>
  <a href="listProduct.php" style="text-decoration: none;"><li class="list-group-item" >Manage Products</li></a>
  <a href="listOrder.php" style="text-decoration: none;"><li class="list-group-item" >Manage Orders</li></a>
  <a href="logout.php" style="text-decoration: none;"><li class="list-group-item" >Log Out</li></a>
</ul>
            </div>
            <div class="col-10">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Danh sách khách hàng</h4>
                        <div class="table-responsive m-t-20">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Last Name</th>
                                        <th>First Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Address</th>
                                        <th>Role</th>
                                        <th>Created at</th>
                                        <th>Updated at</th>
                                        <th>Edit/Remove</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM users";
                                    $query = mysqli_query($db, $sql);
                                    if (!mysqli_num_rows($query) > 0) {
                                        echo '<td colspan="7"><center>No User-Data!</center></td>';
                                    } else {
                                        while ($rows = mysqli_fetch_array($query)) {
                                            echo ' <tr><td>' . $rows['username'] . '</td>
														<td>' . $rows['firstname'] . '</td>
														<td>' . $rows['lastname'] . '</td>
														<td>' . $rows['email'] . '</td>
														<td>' . $rows['phone_number'] . '</td>
														<td style="text-transform:capitalize">' . $rows['address'] . '</td>	
                                                                                                
                                                        <td>' . $rows['role'] . '</td>	
                                                        <td>' . $rows['created_at'] . '</td>	
                                                        <td>' . $rows['updated_at'] . '</td>	
                                                        <td> 
                                                        <a href="delete_users.php?user_del='.$rows['id'].'" class="btn btn-danger btn-flat btn-addon btn-xs m-b-10"> <p>Delete</p></a>
                                                                                                     </td>																				
														</tr>';
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>