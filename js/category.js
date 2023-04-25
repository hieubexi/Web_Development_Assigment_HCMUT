
$(document).ready(function(){
    const apiURL = "../bookstore/admin/api/";
    const queryStr = window.location.search;
    const urlParam = new URLSearchParams(queryStr);
    const productName = urlParam.get('name');

    loadCategories();
    filter();


    $(document).on('click', '.category-item, .price-limit-item', addFilter)
               .on('click', '.filter-item a', removeFilter)
               .on('click', '.category-item, .price-limit-item, .filter-item a', filter)
               .on('change', '#nums_product, #product_sort', filter);

    // Load Category
    function loadCategories(){
        $.ajax({
            url: "./get_category.php",
            type: "POST",
            dataType: "json",
            success: function (resCategories) {
                $.each(resCategories, function (index, category) {
                    const categoryItem = `<li>
                                            <a href='#' class='tag category-item'>
                                            ${category['name']}
                                            </a>
                                        </li>`

                    $(".genre-list").append(categoryItem)
                });
            }
        });
    }

    // Get Price Limit
    function getPriceLimit(priceFilter){
        return priceFilter.find('span')     // Find tag containe price
                        .text()             // Get text of that tag
                        .replaceAll(',','') // Replace thousand separator
                        .split(" - ")       // Split to floor and ceil price
                        .map(Number);       // Map to number
    }

    // Get Page Size
    function getPageSize(){
        return parseInt($('#nums_product').val());
    }

    // Get Sort Type
    function getSortType(){
        return $('#product_sort').val();
    }

    // Get Filter List
    function getFilterList(){
        let filterList = {};

        $('.category-filter').each(function(){
            if (!filterList.hasOwnProperty('category'))
                filterList.category = [];
            filterList.category.push($.trim($(this).text()));
        })

        $('.price-limit-filter').each(function(){
            let priceLimit = getPriceLimit($(this))
            if (!filterList.hasOwnProperty('priceLimit'))
                filterList.priceLimit = {
                                        floor:[],
                                        ceil:[]
                                        };
            filterList.priceLimit.floor.push(priceLimit[0]);
            if (isNaN(priceLimit[1]))
                filterList.priceLimit.ceil.push(Number.MAX_SAFE_INTEGER);
            else
                filterList.priceLimit.ceil.push(priceLimit[1]);
        })

        filterList.sort = getSortType();
        filterList.name = productName;

        return filterList;
    }

    // Empty Product List
    function emptyProductList(){
        $('.product-list').html("");
    }


    // Check is Filter
    function isFilter(Item){
        let isFilter = false;

        $('.filter-item').each(function(){
            let filterName = $.trim($(this).text());
            let itemName   = $.trim(Item.text());

            if (itemName == filterName) isFilter = true;
        })

        return isFilter;
    }
    // Checki is Price Category
    function isPriceItem(Item){
        return Item.hasClass('price-limit-item');
    }

    // Add Filter
    function addFilter(){
        if (isFilter($(this))) return false;

        if (isPriceItem($(this)))
        {
            const filterItem = $(`<li class='tag filter-item price-limit-filter'>
                                    ${$(this).html()}
                                    <a href='#'>
                                        <i class='fa fa-times' aria-hidden='true'></i>
                                    </a>
                                </li>`)

            $('.filter').prepend(filterItem)
        }
        else
        {
            const filterItem = $(`<li class='tag filter-item category-filter'>
                                    ${$(this).html()}
                                    <a href='#'>
                                        <i class='fa fa-times' aria-hidden='true'></i>
                                    </a>
                                </li>`)

            $('.filter').append(filterItem)
        }
    }

    // Remove Filter
    function removeFilter(){
        $(this).parent().remove();
    }


    // Filter Product
    function filter() {
        emptyProductList();
        $("#search-input").val(productName);
        loadProductByFilter(getFilterList(), getPageSize());
    }

    // Load Filter Products
    function loadProductByFilter(filterList, pageSize){
        $.ajax({
            url: "./filter.php",
            type: "POST",
            data: { "filter-list": filterList},
            dataType: "json",
            success: function (resProducts) {
                loadPagination(resProducts, pageSize, loadProduct);
            },
            error: function (error) {
                console.log(error.responseText)
            }
        });
    }



    function loadProduct(index, product){
        let avgStar = 0;
        let numsReview = 0;
        let currentPrice = product['price'] * (100 - product['discount']) / 100;

        if (product['avg_star'])
            avgStar = parseFloat(product['avg_star']);
        if (product['nums_of_review'])
            numsReview = parseInt(product['nums_of_review']);

        const productItem = `<!-- Product Item -->
                            <li class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
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

        $('.product-list').append(productItem)
    }

    function loadNotFound(){
        const notFoundMessage = "<li class='p-2'>Không tìm thấy sản phẩm<li>";

        $(".product-list").append(notFoundMessage);
    }


    function loadPagination(data, pageSize = 4, callback){
        if (data.length === 0)
        {
            loadNotFound();
            return;
        }

        $('#pages').pagination({
            dataSource: data,
            pageSize: pageSize,
            callback: function(data, pagination) {
                emptyProductList();
                $.each(data, callback);
                $('.paginationjs-next a, .paginationjs-prev a, .paginationjs-page a').addClass('btn');
            }
        });
    }

})

function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
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