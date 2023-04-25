$(document).ready(function() {
    const userInfoURL = "http://localhost/bookstore/admin/api/getUserById.php?userId="
    const cartDetailURL = "http://localhost/bookstore/admin/api/getProductInCart.php"
    const addOrderURL = "http://localhost/bookstore/admin/api/addOrder.php"
    const deleteCartURL = "http://localhost/bookstore/admin/api/deleteCartItemByUserId.php"
    const updateUserAddrURL = "http://localhost/bookstore/admin/api/updateUserAddress.php"
    const checkDiscountCodeURL = "http://localhost/bookstore/admin/api/checkDiscountCode.php"
    var discount = 0.0
    var invoice = 0
    var items = []
    const ORDER_STATUS_PROCESSING = "Processing"
    
    $.ajax({
        url: checkDiscountCodeURL + "?discount_code=" + getCookie("discount_code"),
        type: "GET",
        dataType: 'json',
        success: function(response) {
            discount = parseFloat(response.discount)
        },
        error: function(response) {
            console.error(response)
        }
    })
    
    $.ajax({
        url: userInfoURL + getCookie("user_id"),
        type: 'GET',
        dataTye: 'json',
        success: function(resObj) {
            loadUserData(resObj)
        },
        error: function(e) {
            console.log(e)
        }
    })

    $.ajax({
        url: cartDetailURL + "?userId=" + getCookie("user_id"),
        type: 'GET',
        dataType: 'json',
        success: function(resObj) {
            if (Array.isArray(resObj)) {
                productInfoHandle(resObj)
            } else {
                $('.checkout_btn').prop('disabled', true);
            }
        },
        error: function(e) {
            console.error(e)
        }
    })


    function productInfoHandle(objectArr) {
        let sum = 0
        for(let i = 0; i < objectArr.length; i++) {
            let item = `
                <hr class="dash my-1">
                <div class="row">
                    <div class="col-sm-2 col-md-1 my-3">
                    <strong class="ml-2">${i + 1}</strong>
                    </div>
                    <div class="col-sm-4 col-md-5">
                        <div class="row">
                            <div class="col-sm-5 ">
                                <img src="${objectArr[i].p_img}" alt="${objectArr[i].p_name}" style="width: 120%;">
                            </div>
                            <div class="col-sm-7 item_info">
                                <h4>${objectArr[i].p_name}</h4>
                                <p><strong>Author:</strong> ${objectArr[i].p_author}</p>
                                <p><strong>NXB:</strong> ${objectArr[i].p_publisher}</p>
                                <p><strong>Code:</strong> ${objectArr[i].p_code}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-md-2 my-3">
                    <strong class="ml-1 red-color">${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(Math.ceil(parseFloat(objectArr[i].p_price)/1000 * (100.0 - parseFloat(objectArr[i].p_discount)) / 100.0) * 1000)}</strong>
                    </div>
                    <div class="col-sm-2 col-md-2 my-3">
                    <strong class="ml-3">${objectArr[i].quantity}</strong>
                    </div>
                    <div class="col-sm-2 col-md-2 my-3">
                    <strong class="red-color">${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(Math.ceil(parseFloat(objectArr[i].p_price)/1000 * (100.0 - parseFloat(objectArr[i].p_discount)) / 100.0) * 1000 * objectArr[i].quantity)}</strong>
                    </div>
                </div>
            `
            $(".product_list").append(item)
            let mobileItem = `
                <div class="row p-2">
                    <div class="col-xs-4">
                        <img src="${objectArr[i].p_img}" alt="${objectArr[i].p_name}">
                    </div>
                    <div class="col-xs-8">
                        <h4>${objectArr[i].p_name}</h4>
                        <strong class="mt-1">Quantity: ${objectArr[i].quantity}</strong>
                        <strong class="red-color mt-1">${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(Math.ceil(parseFloat(objectArr[i].p_price)/1000 * (100.0 - parseFloat(objectArr[i].p_discount)) / 100.0) * 1000)}</strong>
                    </div>
                </div>
            `
            $(".mobile_product_list").append(mobileItem)
            items.push({"product_id": objectArr[i].p_id, "quantity": objectArr[i].quantity})
            sum += Math.ceil(parseFloat(objectArr[i].p_price)/1000 * (100.0 - parseFloat(objectArr[i].p_discount)) / 100.0) * 1000 * objectArr[i].quantity
        }
        invoice = sum
        let summary = `
            <div class="row ">
                <div class="col-sm-10">
                <h5 class="summary-title">Tạm tính</h5>
                </div>
                <div class="col-sm-2">
                <h4 class="red-color">${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(sum)}</h4>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-10">
                <h5 class="summary-title">Chiết khấu</h5>
                </div>
                <div class="col-sm-2">
                <h4>${discount.toString()} %</h4>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-10">
                <h5 class="summary-title">TỔNG</h5>
                </div>
                <div class="col-sm-2">
                <h4 class="red-color"><strong>${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(Math.ceil(sum/1000 * (100 - discount)/100)*1000)}</strong></h4>
                </div>
            </div>
        `
        let mobileSummary = `
            <div class="row">
                <div class="col-xs-6">
                <h5 class="summary-title">Tạm tính</h5>
                </div>
                <div class="col-xs-6 text_align_end">
                <h4 class="red-color">${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(sum)}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <h5 class="summary-title">Chiết khấu</h5>
                </div>
                <div class="col-xs-6 text_align_end">
                    <h4>${discount.toString()}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 ">
                    <h5 class="summary-title">TỔNG</h5>
                </div>
                <div class="col-xs-6 text_align_end">
                <h4 class="red-color">${new Intl.NumberFormat('de-DE', {style: 'currency', currency: 'VND'}).format(Math.ceil(sum/1000 * (100 - discount)/100)*1000)}</h4>
                </div>
            </div>
        `
        $(".summary").append(summary)
        $(".mobile_summary").append(mobileSummary)
    }

    function loadUserData(object) {
        console.log(object)
        $("#fullName").val(object.fullName)
        $("#phone").val(object.phone)
        $("#email").val(object.email)
        $("#address").val(object.address)
    }

    $("body").on("change", "#address", function() {
        if (validateInput(this.value)) {
            $("#notification").html("")
            $('.checkout_btn').prop('disabled', false);
            updateUserAddress(this.value)
        } else {
            $("#notification").html("(*) Vui lòng nhập địa chỉ!") 
            $('.checkout_btn').prop('disabled', true);
        }
    })

    function updateUserAddress(stringAddr) {
        let data = {
            "id": getCookie("user_id"),
            "address": stringAddr
        }
        $.ajax({
            url: updateUserAddrURL,
            type: "PUT",
            dataType: "json",
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response.message)
            },
            error: function(errorObj) {
                console.error(errorObj.message)
            }
        })
    }

    $(".checkout_btn").on("click", function() {
        addOrder()
        deleteCart()
    })

    function addOrder() {
        let discount
        if (getCookie("discount") == "") {
            discount = 0.0
        }
        let data = {
            "user_id": getCookie("user_id"),
            "discount": discount,
            "invoice": invoice,
            "status": ORDER_STATUS_PROCESSING,
            "items": items
        }
        $.ajax({
            url: addOrderURL,
            type: "POST",
            dataType: "json",
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response)
            },
            error: function(errorObj) {
                console.error(errorObj.message)
            }
        })
    }

    function deleteCart() {
        let data = {
            "user_id": getCookie("user_id")
        }
        $.ajax({
            url: deleteCartURL,
            type: "DELETE",
            data: JSON.stringify(data),
            success: function(response) {
                console.log(response)
                location.href = "category.php"
            },
            error: function(errorObj) {
                console.error(errorObj.message)
            }
        })
    }

    function validateInput(string) {
        let address = string.trim()
        if (address != "") {
            return true
        }
        return false
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
})