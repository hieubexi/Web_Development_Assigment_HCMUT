<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT *
              FROM (products
              INNER JOIN (SELECT id AS c_id, name AS c_name FROM category) AS c ON products.category_id = c.c_id)
              WHERE products.id =" . $id;

    $result = mysqli_query($db, $query);

    $product = mysqli_fetch_assoc($result);

}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="./image/gucci_logo.png">
    <title>@GUXXI</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animsition.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/product.css" rel="stylesheet">
</head>

<body>
    <!--header starts-->
    <?php require_once "header.php" ?>
    <div class="page-wrapper">
        <!-- top Links -->
        <div class="top-links">
            <div class="container">
                <ul class="row links">
                    <li class="col-xs-12 col-sm-4 link-item active"><span>1</span><a href="category.php">Choose
                            Book</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>2</span><a href="cart.php">Check out</a></li>
                    <li class="col-xs-12 col-sm-4 link-item"><span>3</span><a href="">Payment</a></li>

                </ul>
            </div>
        </div>
        <!-- end:Top links -->
        <!-- start: Inner page hero -->

        <div class="product">
            <!-- Breakcrumb -->
            <nav class="container" aria-label="breadcrumb">
                <ol class="row breadcrumb">
                    <li class="d-inline-block breadcrumb-item">
                        <form action="category.php" method="POST">
                            <input type="text" value="<?php echo strtoupper($product['c_name']); ?>"
                                style="display:none" name="category">
                            <a href="javascript:{}" class="link-item">
                                <!-- <input type="submit" style="display:none"> -->
                                <?php echo strtoupper($product['c_name']); ?>
                            </a>
                        </form>

                    </li>
                    <li class="d-inline-block breadcrumb-item" aria-current="page">
                        <a href="#product" class="link-item">
                            <?php echo strtoupper($product['name']); ?>
                        </a>
                    </li>
                </ol>
            </nav>
            <!-- End Breakcrumb -->

            <!-- Product Information -->
            <div class="container card" id="product">
                <div class="product__information">
                    <div class="row">
                        <!-- Product Image -->
                        <div class="col-xl-5">
                            <div class="product-img__block">
                                <img src="<?php echo $product['image_url']; ?>" alt="" class="product-img">
                            </div>

                            <div class="row">
                                <div class=" col-xs-12 col-xl-6 mb-1">
                                    <div class="btn border-primary addToCart" style="width:100%; color:#f30">
                                        <i class="fa fa-shopping-cart mr-1" aria-hidden="true"></i>
                                        Thêm vào giỏ hàng
                                    </div>
                                </div>

                                <div class="col-xs-12 col-xl-6">
                                    <a href="cart.php"
                                        class="btn bg-primary-color btn-primary border-primary text-secondary-color addToCart"
                                        style="width:100%;">
                                        Mua ngay
                                    </a>
                                </div>
                                <div class="cartMessage col-xs-12"></div>
                            </div>

                        </div>
                        <!-- End Product Image -->

                        <!-- Product Description -->
                        <div class="col-xl-7">
                            <div class="product__description">
                                <h2 class="product__name">
                                    <?php echo $product['name']; ?>

                                </h2>

                                <!-- Product Attribute -->
                                <div class="product__list">
                                    <div class="row">
                                        <h5 class="product__publisher product__list-item col-xl-6 col-lg-6">
                                            <span style="margin-left: 8px">Nhà cung cấp: </span>
                                            <a href="#">
                                                <?php echo $product['publisher']; ?>
                                            </a>
                                        </h5>

                                        <h5 class="product__author product__list-item col-xl-6 col-lg-6">
                                            <span style="margin-left: 8px">Tác giả: </span>
                                            <?php echo $product['author']; ?>
                                        </h5>

                                        <h5 class="product__cover product__list-item col-xl-12">
                                            <span style="margin-left: 8px">Hình thức bìa: </span>
                                            <?php echo $product['cover']; ?>
                                        </h5>
                                    </div>
                                </div>

                                <!-- End Product Attribute -->

                                <!-- Price -->
                                <div class="price mb-1">
                                    <span class="current-price">
                                        <?php echo number_format($product['price'] * (100 - $product['discount']) / 100, 0, '.', ','); ?>

                                    </span>

                                    <span class="original-price line-through">
                                        <?php echo number_format($product['price'], 0, '.', ','); ?>

                                    </span>

                                    <span class="discount">
                                        <span>-</span>
                                        <?php echo number_format($product['discount'], 0); ?><span>%</span>
                                    </span>
                                </div>
                                <!-- End Price -->

                                <!-- Rating -->
                                <div class="ratings">
                                    <div class="ratings-box">
                                        <div class="ratings-star" style="width: 0%"></div>
                                    </div>
                                    <span>(<span class="review_nums">0</span>)</span>
                                </div>
                                <!-- End Rating -->

                                <!-- Quantity -->
                                <div class="quantity_container">
                                    <span>Số lượng: </span>

                                    <div class="quantity-control">
                                        <div class="d-inline-block px-1" id="subQty" onclick="subQty()">-</div>
                                        <input type="text" minvalue="1" maxvalue="999" value="1" class="quantity"
                                            id="Qty" onkeypress="validateNumber(event)">
                                        <div class="d-inline-block px-1" id="plusQty" onclick="plusQty()">+</div>
                                    </div>
                                </div>
                                <!-- End Quantity -->

                            </div>
                        </div>
                        <!-- End Product Description -->
                    </div>
                </div>
            </div>
            <!-- End Product Information -->

            <!-- Newest & Favorite -->
            <!-- Newest -->
            <div class="container card">
                <div class="newest">
                    <div class="top-links pb-0 mb-2">
                        <h5>MỚI NHẤT</h5>
                    </div>

                    <ul class="row product-list"></ul>
                </div>
            </div>
            <!-- End Newest -->

            <!-- Favorite -->
            <div class="container card">
                <div class="favorite">
                    <div class="top-links pb-0 mb-2">
                        <h5>YÊU THÍCH NHẤT</h5>
                    </div>

                    <ul class="row product-list"></ul>
                </div>
            </div>
            <!-- End Favorite -->


            <!-- Product Detail Information -->
            <div class="container card">
                <div class="product__detail-information">
                    <h4 class="title">Thông tin sản phẩm</h4>

                    <div class="product__detail-view">
                        <table class="product__detail-table">
                            <tbody>
                                <tr>
                                    <td>Mã hàng</td>
                                    <td>
                                        <?php echo $product['code']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tác giả</td>
                                    <td>
                                        <?php echo $product['author']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Người Dịch</td>
                                    <td>
                                        <?php echo $product['translator']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>NXB</td>
                                    <td>
                                        <?php echo $product['publisher']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Năm XB</td>
                                    <td>
                                        <?php echo $product['publication_year']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Trọng lượng (gr)</td>
                                    <td>
                                        <?php echo $product['weight']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kích Thước Bao Bì</td>
                                    <td>
                                        <?php echo $product['dimension']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Số trang</td>
                                    <td>
                                        <?php echo $product['page_num']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Hình thức</td>
                                    <td>
                                        <?php echo $product['cover']; ?>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- End Product Detail Information -->


            <!-- Begin Rate and Comment -->
            <div class="container card">
                <div class="comment">
                    <h4 class="title">Đánh giá sản phẩm</h4>

                    <div class="row ratings__container">
                        <div class="ratings__block col-xl-3 col-lg-3 col-md-4 col-xs-12">
                            <div class="ratings-point">
                                <span class="current-point">0</span>
                                <span>/</span>
                                <span class="max-point">5</span>
                            </div>

                            <div class="ratings mb-1">
                                <div class="ratings-box">
                                    <div class="ratings-star" style="width: 0%"></div>
                                </div>
                            </div>

                            <span>(<span class="review_nums">0</span> đánh giá)</span>

                        </div>

                        <div class="ratings-bar col-xl-6 col-lg-6 col-md-8 col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <span>5 sao</span>
                                    <div class="bar">
                                        <div class="bar-active" style="width:0%;"></div>
                                    </div>
                                    <span>0%</span>
                                </div>
                                <div class="col-xs-12">
                                    <span>4 sao</span>
                                    <div class="bar">
                                        <div class="bar-active" style="width:0%;"></div>
                                    </div>
                                    <span>0%</span>
                                </div>
                                <div class="col-xs-12">
                                    <span>3 sao</span>
                                    <div class="bar">
                                        <div class="bar-active" style="width:0%;"></div>
                                    </div>
                                    <span>0%</span>
                                </div>
                                <div class="col-xs-12">
                                    <span>2 sao</span>
                                    <div class="bar">
                                        <div class="bar-active" style="width:0%;"></div>
                                    </div>
                                    <span>0%</span>
                                </div>
                                <div class="col-xs-12">
                                    <span>1 sao</span>
                                    <div class="bar">
                                        <div class="bar-active" style="width:0%;"></div>
                                    </div>
                                    <span>0%</span>
                                </div>
                            </div>
                        </div>

                        <div class="comment-rule mt-md-2 col-xl-3 col-lg-3 col-md-12 col-xs-12">
                            <span>
                                Chỉ có thành viên mới có thể viết nhận xét. Vui lòng <a href="login.php">đăng nhập</a>
                                hoặc <a href="registration.php">đăng ký</a>.
                            </span>
                            <a href="" class="btn border-primary px-3" data-toggle="modal"
                                data-target="#comment-modal">Viết
                                Đánh Giá</a>
                            <!-- Modal -->
                            <div class="modal fade" id="comment-modal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header"
                                            style="display: flex; justify-content: space-between;">
                                            <h5 class="modal-title" id="modal-label">VIẾT ĐÁNH GIÁ SẢN PHÂM</h5>
                                            <div class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form__info">
                                                <div class="rating">
                                                    <span class="rating-star"></span>
                                                    <span class="rating-star"></span>
                                                    <span class="rating-star"></span>
                                                    <span class="rating-star"></span>
                                                    <span class="rating-star"></span>
                                                </div>
                                            </div>
                                            <div class="form__info">
                                                <textarea class="form-control" name="content" id="reviewContent"
                                                    placeholder="Nội Dung (giới hạn 1000 ký tự)" style="height: 300px"
                                                    maxlength="1000"></textarea>
                                                <div class="validate-msg"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="closeReview" class="btn border-secondary"
                                                data-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="button" id="submitReview"
                                                class="btn border-primary bg-primary-color text-secondary-color">
                                                Gửi nhận xét
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="top-links pb-0">
                        <ul class="row links">
                            <!-- <li class="link-item d-inline-block px-2">
                                <a href="#" style="font-size:1.2rem;">Mới nhất</a>
                            </li> -->
                            <li class="link-item active d-inline-block mx-1 px-1">
                                <a href="#" style="font-size:1.2rem;">Đánh giá</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Comment -->
                    <div class="comment-list"></div>

                    <div class="pages" id="pages"></div>
                    <!-- End Comment -->
                </div>
            </div>

            <!-- End Rate and Comment -->

        </div>
        <!-- End Product -->

        <!-- start: FOOTER -->
        <?php require_once "./footer.php" ?>
        <!-- end:Footer -->
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/animsition.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/headroom.js"></script>
    <script src="js/foodpicky.min.js"></script>
    <script src="js/pagination.js"></script>
    <script src="js/product.js"></script>

</body>

</html>