<?php
include("connection/connect.php");
error_reporting(0);
session_start();

?>
<!--header starts-->
<header class="header">
<nav class="navbar navbar-expand-md custom-navbar sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">@GUCHI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Product
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="list_product.php">Men</a></li>
            <li><a class="dropdown-item" href="#">Women</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Hand bags</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Join us</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2 search-input" type="search" placeholder="Search" aria-label="Search">
        <button class="btn search-button" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</header>