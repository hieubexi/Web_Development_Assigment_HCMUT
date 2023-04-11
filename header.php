<?php
include("connection/connect.php");
error_reporting(0);
session_start();

?>
<!--header starts-->
<header class="header">
<nav class="navbar navbar-expand-md custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">@GUCHI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0" >
      <li class="nav-item">
          <a class="nav-link" href="#">What news?
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="list_product.php">Men</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Women</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="#">Hand bags</a>
        </li>
        <?php
                    if (empty($_SESSION['username'])) // if user is not login
                    {
                        echo '<li class="nav-item">
                        <a class="nav-link " aria-current="page" href="login.php">Log In</a>
                      </li>';

                    } else {
                        //if user is login
                        // echo '<li class="nav-item"><a style="color: white" class="has-arrow  "href="cart.php" aria-expanded="false"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="hide-menu"> Cart </span> </li>';
                        echo '
                        <li class="nav-item">
                        <a class="nav-link" href="Cart">Cart</a>
                        </li>
                        <li class="nav-item dropdown" style= "font-style: italic; ">
                        <a class="nav-link dropdown-toggle account" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 20">
  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
</svg>
                          Hi, '. $_SESSION['username'].', welcome back!
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li><a class="dropdown-item" href="userInfor">Your Account</a></li>
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