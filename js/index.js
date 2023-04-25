$(document).ready(function(){
    loadNewestProducts();

    function loadNewestProducts(){
        const filterList = {"sort": "newest"}

        $.ajax({
            url: "./filter.php",
            type: "POST",
            data: {"filter-list": filterList},
            dataType: "json",
            success: function(resProducts) {
                $.each(resProducts, (index, product)=>{
                    if (index == 4) return false;
                    loadProduct(product)
                })
            },
            error: function(error) {
                console.log(error.responseText)
            }
        })
    }

    function loadProduct(product){
        let avgStar = 0;
        let numsReview = 0;
        let currentPrice = product['price'] * (100 - product['discount']) / 100;

        if (product['avg_star'])
            avgStar = product['avg_star'];
        if (product['nums_of_review'])
            numsReview = product['nums_of_review'];

        const productItem =
            `<!-- Product Item -->
                <li class="col-xl-3 col-lg-6">
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

        $(".product-list").append(productItem);
    }
})

function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}