<?php
	include("connection/connect.php"); //INCLUDE CONNECTION
	error_reporting(0); // hide undefine index errors
	session_start(); // temp sessions
	if (isset($_POST['submit']))   // if button is submit
	{
		$username = $_POST['username'];  //fetch records from login form
		$password = $_POST['password'];

		if (!empty($_POST["submit"]))   // if records were not empty
		{
			$loginquery = "SELECT * FROM users WHERE username='$username'"; //selecting matching records
			$result = mysqli_query($db, $loginquery); //executing
			$row = mysqli_fetch_array($result);
			if (is_array($row)) {
				if ($password == $row['password']) {
					setcookie("user_id", $row['id'], time() + (86400*30), "/");
					$_SESSION['username'] = $username;
					$success = "Log in successfully";
					header("Location:index.php");
				} else {
					$message = "Password is incorrect";
				} 
			} else {
				$message = "Username is incorrect";
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
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/global_component.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="stylesheet" href="./node_modules/bootstrap-icons/icons/">
     <link rel="stylesheet" href="./sass/style.sass">
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
    <div class ="login-container my-login text-center">
     <div class ="col-md-4 offset-md-4">
            <form class="cursor-hover" action="" method ="post">
    <img class="mb-4 cursor-hover" src="./image/gucci_logo.png" alt="" width="140" >
    <h1 class="h3 mb-3 fw-normal cursor-hover">Please Log In</h1>
    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" name ="username">
      <label for="floatingInput">User name</label>
    </div>
    <br> 
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name = "password">
      <label for="floatingPassword">Password</label>
    </div>
    <span style="color:red;"><?php echo "<br>". $message ; ?></span>
    <span style="color:green;"><?php echo "<br>". $success; ?></span>
    <input class="w-100 btn btn-lg btn-primary pointer-hover" type="submit" name = "submit" value="Log In"></input>
  </form>
            </div>
        </div>
    </div>

<!-- Here is footer -->
<?php require_once "footer.php" ?>
<!-- Script HERE -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>