

$(document).ready(function() {
    const apiURL = "../admin/api";
    const queryStr = window.location.search;
    const urlParam = new URLSearchParams(queryStr);
    const productId = parseInt(urlParam.get('id'));
    const userId = parseInt(getCookie("user_id"));

    let count_star =
        {
            "1":0,
            "2":0,
            "3":0,
            "4":0,
            "5":0,
            "nums_of_review": 0
        };

    if (userId) {
        $(".comment-rule>span").hide();
        $(".comment-rule>a").show();
    }

    else {
        $(".comment-rule>span").show();
        $(".comment-rule>a").hide();
    }

    loadNewestProducts();
    loadFavoriteProducts();
    loadReviewList();

    // Add To Cart handle
    $(".addToCart").on("click", addProduct);

    // Review handle
    // Rate Star
    $(".rating-star").hover(hoverStar, removeStar)
    $(".rating-star").on("click", activeStar)
    $(".rating").on("click", removeStar)
    $(".rating-star").on("click", clearRateStarErrorMessage)

    // Content
    $("#reviewContent").on("keyup", clearContentErrorMessage)

    // Submit Button
    $("#submitReview").on("click", addReview)

    //
    $(".breadcrumb li:first-child a").on('click', () => {
        $(".breadcrumb li:first-child form").submit();
    })


    function loadReviewList() {
        $.ajax({
            url: apiURL + "getAllReviewByProduct.php?productId=" + productId,
            type: "get",
            dataType: "json",
            success: function(resReviews) {
                if (resReviews.message)
                {
                    const message = `<span>Chưa có đánh giá!</span>`;

                    $(".comment-list").append(message);
                }
                else
                {
                    clearReviews()
                    loadPagination(resReviews, 4, loadReview);
                    loadStarBar();
                }
            },
            error: function(error) {
                console.log(error.responseText);
            }
        })
    }

    function loadReview(index, Review) {
        const reviewItem = `<div class="comment-block">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-md-2">
                                        <div class="name">${Review.username}</div>
                                        <div class="comment-date">${Review.created_at}</div>
                                    </div>
                                    <div class="col-xl-10 col-lg-10 col-md-10">
                                        <div class="ratings mb-1">
                                            <div class="ratings-box">
                                                <div class="ratings-star" style="width: ${Review.rate_star/5*100}%"></div>
                                            </div>
                                        </div>

                                        <div class="comment">
                                        ${Review.content}
                                        </div>


                                    </div>

                                </div>
                            </div>
                            <hr>`;

        $(".comment-list").append(reviewItem);
        count_star[Review.rate_star] += 1;
        count_star.nums_of_review += 1;
    }

    function loadProductList(type, numberOfProduct){
        $.ajax({
            url: "./filter.php",
            type: "POST",
            data: { "filter-list": {"sort": type}},
            dataType: "json",
            success: function (resProducts) {
                if (resProducts.message)
                {
                    const message = `<span>Chưa có sản phẩm!</span>`;

                    $(`.${type}`).find(".product-list").append(message);
                }
                else
                {
                    $.each(resProducts, function(index, product){
                        if (index == numberOfProduct) return false;

                        $(`.${type}`).find(".product-list").append(getProduct(product));
                    })
                }
            },
            error: function(error) {
                console.log(error.responseText)
            }
        });
    }


    function getProduct(product){
        let avgStar = 0;
        let numsReview = 0;
        let currentPrice = product['price'] * (100 - product['discount']) / 100;

        if (product['avg_star'])
            avgStar = product['avg_star'];
        if (product['nums_of_review'])
            numsReview = product['nums_of_review'];

        const productItem =
            `<!-- Product Item -->
                <li class="col-xl-3 col-lg-6 col-md-6">
                    <a href="./product.php?id=${product['id']}" class="list-item-link">
                        <div class="list-item card">
                            <div class="img-container">
                                <img src="${product['image_url']}" alt="" class="list-item-img">
                            </div>
                            <h5 class="list-item-name">
                                ${product['name']}
                            </h5>

                            <div class="list-item-description">


                                <div class="price">
                                    <span class="current-price">${numberWithCommas(currentPrice)} đ</span>
                                    <span class="original-price">
                                        <span class="line-through">${numberWithCommas(product['price'])}</span>
                                        <span class="discount">-${parseFloat(product['discount'])}%</span>
                                    </span>

                                </div>

                                <div class="ratings">
                                    <div class="ratings-box">
                                        <div class="ratings-star" style="width: ${avgStar/5*100}%"></div>
                                    </div>
                                    <span>(${numsReview})</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- End Product Item -->`

        return productItem;
    }

    function loadPagination(data, pageSize = 4, callback){
        $('#pages').pagination({
            dataSource: data,
            pageSize: pageSize,
            callback: function(data, pagination) {
                $.each(data, callback);
                $('.paginationjs-next a, .paginationjs-prev a, .paginationjs-page a').addClass('btn');

            }
        });
    }

    function loadStarBar(){
        $.fn.reverse = [].reverse;
        if (count_star.nums_of_review == 0) return;

        $(".bar-active").reverse().each(function(index, bar) {
            let width = count_star[index + 1] * 100 / count_star.nums_of_review;
            $(this).width(width + "%");
            $(this).parent()                    // Get element ".bar"
                   .next().text(Math.round(width) + "%");
        })

        $.ajax({
            url: apiURL + "getAvgStarByProduct.php?productId=" + productId,
            type: "get",
            dataType: "json",
            success: function(res) {
                if (res.message)
                    console.log(res.message)
                else
                {
                    $('.current-point').text(parseFloat(res.avg_star).toFixed(2))
                    $('.ratings__block .ratings-star').width(res.avg_star / 5 * 100 + "%")
                    $('.product__description .ratings-star').width(res.avg_star / 5 * 100 + "%")
                }
            },
            error: function(error) {
                console.log(error.responseText)
            }
        })

        $(".review_nums").text(count_star.nums_of_review)
    }

    function addProduct(){
        clearCartMessage();

        const product = getProductInCart();

        addProductToCart()

        // if (Object.keys(product).length)
        //     addProductToCart();
        // else
        //     updateProductInCart(product);
    }

    function getProductInCart(){
        let product = {};

        $.ajax({
            url: apiURL + "getProductInCart.php",
            type: "get",
            data: {"userId": userId},
            dataType: "json",
            async: false,
            success: function(resProducts) {
                if (resProducts.message)
                    console.log(resProducts.message)
                else
                {
                    $.each(resProducts, (index, Product)=>{

                        if (Product.product_id == productId)
                            product = Object.assign(product, Product);

                    })
                }

            },
            error: function(error) {
                console.log(error.responseText)
            }
        })

        return product;
    }

    function addProductToCart(){
        const quantity = $("#Qty").val();

        const product = {
            "user_id": userId,
            "product_id": productId,
            "quantity": quantity
        }

        $.ajax({
            url: apiURL + "addProductToCart.php",
            type: "post",
            data: JSON.stringify(product),
            dataType: "json",
            success: function(res) {
                const successMessage = `
                                        <div class="alert alert-success mt-1" style="text-align:center;" role="alert">
                                            <div>
                                                Đã thêm vào giỏ hàng
                                            </div>
                                        </div>
                                       `;

                $(".cartMessage").append(successMessage)
                console.log(successMessage)
            },
            error: function(error) {
                console.log(error.responseText)
            }
        })
    }

    function updateProductInCart(product){
        const quantity = $("#Qty").val();
        const cartId = product.id;

        const Item = {
            "id": cartId,
            "quantity": product.quantity + parseInt(quantity)
        }

        $.ajax({
            url: apiURL + "updateCart.php",
            type: "post",
            data: JSON.stringify(Item),
            dataType: "json",
            success: function(res) {
                const successMessage = `
                                        <div class="alert alert-success mt-1" style="text-align:center;" role="alert">
                                            <div>
                                                Đã thêm vào giỏ hàng
                                            </div>
                                        </div>
                                       `;

                $(".cartMessage").append(successMessage)
            },
            error: function(error) {
                console.log(error.responseText)
            }
        })
    }

    function addReview(){
        const rateStar = getRateStarReview();
        const content = $("#reviewContent").val();
        const close = $("#closeReview");

        const review = {
            "user_id": userId,
            "product_id": productId,
            "rate_star": rateStar,
            "content": content
        };

        if (!validateReview(review))
            return

        $.ajax({
            url: apiURL + "addReview.php",
            type: "post",
            data: JSON.stringify(review),
            dataType: "json",
            success: function(res) {
                if (res.rating_id)
                    close.trigger("click");
                    loadReviewList();
            },
            error: function(error) {
                console.log(error.responseText);
            }
        })
    }



    function hoverStar(){
        $(".rating-star").removeClass("active");
        $(this).prevAll()
               .addClass("active");
        $(this).addClass("active");
    }

    function removeStar(e){
        if (e.target != this)
            return;
        $(".rating-star").removeClass("active");
    }

    function activeStar(){
        $(".rating-star").removeClass("active");
        $(this).prevAll()
               .addClass("active");
        $(this).addClass("active");
        $(".rating-star").off("mouseenter mouseleave");
    }

    function getRateStarReview(){
        return $(".rating-star.active").length;
    }

})


function subQty() {
    var qty = document.getElementById('Qty')

    if (qty.value > 1) {
        qty.value--
    }

}

function plusQty() {
    var qty = document.getElementById('Qty')
    qty.value++
}

function validateNumber(event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}

function validateReview(Review) {
    const rateStar = Review.rate_star;
    const content = Review.content;
    const rateStarErrorMessage = `
                                    <div class="alert alert-danger mt-1" role="alert">
                                        <div>
                                            Bạn chưa đánh giá sản phẩm
                                        </div>
                                    </div>
                                 `;

    const contentErrorMessage = `
                                    <div class="alert alert-danger mt-1" role="alert">
                                        <div>
                                            Bạn cần nhập nội dung đánh giá
                                        </div>
                                    </div>
                                `;

    let validation = true;

    if (rateStar === 0)
    {
        $(".rating").append(rateStarErrorMessage)
        validation = false;
    }

    if (content.length === 0)
    {
        $(".validate-msg").append(contentErrorMessage)
        validation = false;
    }

    return validation;
}

function clearRateStarErrorMessage(){
    $(".rating").find(".alert").remove()
}

function clearContentErrorMessage(){
    $(".validate-msg").find(".alert").remove()
}

function clearCartMessage(){
    $(".cartMessage").find(".alert").remove()
}

function clearReviews(){
    $(".comment-list").html("");
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }


