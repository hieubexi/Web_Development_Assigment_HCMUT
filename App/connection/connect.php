<?php
    $serverName = "localhost";  
    $username = "root";
    $password ="";
    $dbname = "init";

    $db = mysqli_connect($serverName, $username, $password, $dbname); //connect to database

    if(!$db){
        die("Could not connect to database: " . mysqli_connect_error());
    }
    
?>