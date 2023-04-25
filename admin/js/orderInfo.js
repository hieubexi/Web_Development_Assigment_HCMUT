$(document).ready(function() {
    const queryStr = window.location.search
    const urlParam = new URLSearchParams(queryStr)
    const orderId = urlParam.get('orderId')
    const orderInfoURL = "http://localhost/bookstore/admin/api/orderInfo.php?orderId="
    const orderItemsURL = "http://localhost/bookstore/admin/api/orderItems.php?orderId="
    const updateOrderURL = "http://localhost/bookstore/admin/api/updateOrder.php"
    const orderItemsQtyURL = "http://localhost/bookstore/admin/api/updateQtyItem.php"
    const orderCalSumURL = "http://localhost/bookstore/admin/api/calSumItem.php?orderId="
    const productURL = "http://localhost/bookstore/admin/api/allProducts.php"
    const addOrderItemURL = "http://localhost/bookstore/admin/api/addOrderItem.php"
    var userId = ""
    var orderItem
    var sum = 0

    $.ajax({
        url: orderInfoURL + orderId,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            loadData(resObj.data[0])
        }
    })

    $.ajax({
        url: orderItemsURL + orderId,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            if (resObj.data != undefined) {
                orderItem = resObj.data
                loadItemList(resObj.data)
            }
        }
    })

    $.ajax({
        url: productURL,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            loadProductOption(resObj.data)
        }
    })

    function loadData(orderObj) {
        userId = orderObj.userid
        $("#username").val(orderObj.username)
        $("#lName").val(orderObj.lastname)
        $("#address").val(orderObj.address)
        $("#phone").val(orderObj.phone)
        $("#discount").val(orderObj.discount)
        $("#code").val(orderObj.code)
        $("#sum").val(orderObj.invoice)
        $("#status").val(orderObj.status)
    }

    function loadItemList(array) {
        for (let i = 0; i < array.length; i++) {
            sum += array[i].current_price * array[i].quantity
            let item = `
                <div class="row mt-5 mb-5 order_item">
                    <div class="col-1 mt-5">
                        <span>${i + 1}</span>
                    </div>
                    <div class="col-5">
                        <div class="row">
                            <div class="col-3">
                                <img src="${array[i].img}" alt="${array[i].img}" style="width: 100%;">

                            </div>
                            <div class="col-9">
                                <h4><strong>${array[i].name}</strong></h4>
                                <h5>Author: ${array[i].author}</h5>
                                <h5>NXB: ${array[i].publisher}</h5>
                                <h5>Code: ${array[i].code}</h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-2 mt-5">
                        <h5 class="item_price">${array[i].current_price}VND</h5>
                    </div>
                    <div class="col-2">
                        <input data-id="${array[i].id}" data-uprice="${array[i].current_price}" type="number" class="form-control qty" style="width: 50%; margin-top: 35px;" value="${array[i].quantity}" min="0">
                    </div>
                    <div class="col-2 mt-5">
                        <h5 class="temp_sum">${array[i].current_price * array[i].quantity} VND</h5>
                    </div>
                </div>
            `
            $(".orderItemList").append(item)
        }
    }

    function loadProductOption(array) {
        let check = false
        for (let i = 0; i < array.length; i++) {
            if (orderItem != undefined) {
                for (let j = 0; j < orderItem.length; j++) {
                    if (array[i].id == orderItem[j].product_id) {
                        check = true
                        break;
                    }
                }
                if (!check) {
                    let product = `
                        <option value="${array[i].id}">${array[i].name}</option>
                    `
                    $("#product_select").append(product)
                } else {
                    check = false
                }
            } else {
                let product = `
                        <option value="${array[i].id}">${array[i].name}</option>
                    `
                $("#product_select").append(product)
            }
        }
    }

    $("#back_btn").on("click", function() {
        location.href = "all_orders.php"
    })

    $("#create_btn").on("click", function() {
        location.href = "addOrder.php"
    })

    $("#update_btn").on("click", function() {
        updateOrderHandle()
    })

    $("#update_user_btn").on("click", function() {
        updateUserHandle()
    })

    $("body").on("change", ".qty", function() {
        qtyHandle(this)
    })

    function calSumItem() {
        $.ajax({
            url: orderCalSumURL + orderId,
            type: "GET",
            dataType: 'json',
            success: function(resObj) {
                console.log("Update Sum Items!")
            }
        })
    }

    function updateOrderHandle() {
        console.log(sum)
        let code = $("#code").val()
        let discount = $("#discount").val().trim()
        let invoice = sum
        let status = $("#status").val()
        let data = {
            "id": orderId,
            "code": code,
            "user_id": userId,
            "discount": discount,
            "invoice": invoice,
            "status": status
        }
        console.log(data)
        $.ajax({
            url: updateOrderURL,
            type:"PUT",
            data: JSON.stringify(data),
            dataType: "json",
            success: function(res) {
                location.reload()
            }
        })
    }

    function updateUserHandle() {
        if (userId != "") {
            location.href = "update_users.php?user_upd=" + userId
        } else {
            location.href = "add_users.php"
        }
    }

    function qtyHandle(inputEle) {
        let data = {
            "id": inputEle.dataset.id,
            "quantity":inputEle.value > 0 ? inputEle.value : 0
        }
        $.ajax({
            url: orderItemsQtyURL,
            type:"PUT",
            data: JSON.stringify(data),
            dataType: "json",
            success: function(res) {
                calSumItem()
                location.reload()
            }
        })

    }


    $("#addProduct").on("click", function() {
        let qty = $("#qty_item").val()
        if (qty == "") {
            alert("Vui lòng nhập số lượng!")
        } else {
            qty = parseInt(qty)
            console.log(qty)
        }
        let productId = $("#product_select").val()
        console.log(productId)
        let data = {
            "order_id": orderId,
            "product_id": productId,
            "quantity": qty
        }
        $.ajax({
            url: addOrderItemURL,
            type:"POST",
            data: JSON.stringify(data),
            dataType: "json",
            success: function(res) {
                calSumItem()
                location.reload()
            }
        })
    })

    // $("#update_order_btn").on("click", function() {
    //     validateForm()
    // })

    // function validateForm() {
    //     let code = $("#code").val().trim()
    //     if (checkEmpty(code, "code") && userId != "") {
    //         let discount = $("#discount").val().trim()
    //         let invoice = $("#sum").val().trim()
    //         let status = $("#status").val()
    //         let data = {
    //             "id": orderId,
    //             "code": code,
    //             "user_id": userId,
    //             "discount": discount,
    //             "invoice": invoice,
    //             "status": status
    //         }
    //         $.ajax({
    //             url: updateOrderURL,
    //             type:"PUT",
    //             data: JSON.stringify(data),
    //             dataType: "json",
    //             success: function(res) {
    //                 console.log("Update Order")
    //                 location.reload()
    //             }
    //         })
    //     }

    // }

    function checkEmpty(string, field) {
        if (string == "") {
            alert("Vui lòng nhập " + field + "!")
            return false
        }
        return true
    }

})