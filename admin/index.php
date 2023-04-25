<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if (isset($_POST['submit'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$pwd = password_hash($password, PASSWORD_BCRYPT);
	if (!empty($_POST["submit"])) {

		$login = "SELECT * FROM users WHERE username='$username'";
		$result = mysqli_query($db, $login);
		$row = mysqli_fetch_array($result);

		if (is_array($row)) {
			if ($password == $row['password'] && $row['role'] == "admin") {
				$_SESSION["adm_id"] = $row['id'];
				$success = "Đăng nhập thành công";
				header("refresh:1;url=dashboard.php");
			}
			else {
				$message = "Mật khẩu không chính xác!";
			}
		}
	else {
		$message = "Tên đăng nhập không chính xác hoặc bạn không được cấp quyền đăng nhập!";
	}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/png" sizes="16x16" href="admin/images/favicon1.png">
	<title>Form Đăng nhập</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900'>
	<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Montserrat:400,700'>
	<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
	<link rel="stylesheet" href="css/login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
</head>

<body>


	<div class="container">
		<div class="info">
			<h1 style="font-weight:600; color:brown">ADMINISTRATOR</h1><
		</div>
	</div>
	<div class="form">
		<div class="thumbnail"><img src="images/manager.png" /></div>
		
		
		<div style="color:red;"><?php echo $message; ?></div>
		<span style="color:green; font-weight:600"><?php echo $success;?></span>
		<br><br>
		<form class="login-form" action="index.php" method="post">
			<input type="text" placeholder="Nhập tên đăng nhập" name="username" />
			<input type="password" placeholder="Nhập mật khẩu" name="password" />
			<input type="submit" name="submit" value="Đăng nhập" />	
		</form>

	</div>

	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='js/index.js'></script>

</body>

</html>