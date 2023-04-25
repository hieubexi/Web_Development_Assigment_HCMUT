<?php
session_start();
include("connection/connect.php");

$storyID = $_GET['storyID'];
$sql = "SELECT * FROM story WHERE id = $storyID";
$query = mysqli_query($db, $sql);
$story = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="./image/gucci_logo.png">
    <title>The story of @GUXXI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/global_component.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/icons/">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,500;0,600;0,700;1,600&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Here is header -->
    <?php require_once "header.php" ?>
    <div class="container" style="margin-top:3%; margin-bottom:5%;">
        <div class="row ">
            <div class="col-12 text-center">
                <h4 style="font-weight:lighter; color:#07353b;"> <?php echo $story['title'] ?> </h2>
                <hr>
            <p class="my-story"> <?php echo $story['content']?></p>
                <hr>
                    <div class="card text-bg-dark mb-5">
                        <img src="<?php echo $story['center_pic']?>" class="card-img" alt="center image">
                    </div>
                    <hr>
                    <div class="card text-bg-dark">
                        <img src="<?php echo $story['option_pic']?>" class="card-img" alt="center image">
                    </div>
            </div>
        </div>
    </div>

    </div>

    <?php require_once "story.php" ?>

    <!-- Here is footer -->
    <?php require_once "footer.php" ?>
    <!-- Script HERE -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="js/product.js"></script>
</body>

</html>