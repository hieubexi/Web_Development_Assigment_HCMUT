<?php
include("connection/connect.php");
error_reporting(0);
session_start();


?>
<!--header starts-->
<header class="header">
<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">@GUXXI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
      <li class="nav-item">
          <a class="nav-link" href="#">What news?
          </a>
        </li>
        <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Product</a>
    <ul class="dropdown-menu">
      <li><a class="dropdown-item" href="category.php?categoryID=1">Men</a></li>
      <li><a class="dropdown-item" href="category.php?categoryID=2">Women</a></li>
      <li><a class="dropdown-item" href="category.php?categoryID=3">Jewelry</a></li>
    </ul>
</li>
        <?php
     // ?userID='.$user['id'].'
                    if (empty($_SESSION['username'])) // if user is not login
                    {
                        echo '
                        <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="login.php">Log In</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="signup.php">Join Us</a>
                      </li>';
                    } else {
                      $ssql = "select * from users where username='$_SESSION[username]'";
              $res = mysqli_query($db, $ssql);
        $user = mysqli_fetch_array($res);
                        echo '
                        <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-dash-fill" viewBox="0 0 16 20">
  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM6.5 7h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1 0-1z"/>
</svg> Cart</a> 
                        </li>
                        <li class="nav-item dropdown" style= "font-style: italic; ">
                        <a class="nav-link dropdown-toggle account" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 20">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
</svg>
                          Hi '. $user['firstname'].', welcome back!
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="userInfor.php">Your Account</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                        </ul>
                      </li>';
                    }
                    ?>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2 search-input" type="search" placeholder="Search" aria-label="Search">
        <button class="btn search-button" type="submit" name ="submit" onclick= submit()>Search</button>
      </form>
    </div>
  </div>
</nav>
</header>