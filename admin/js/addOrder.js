$(document).ready(function() {
    const userURL = "http://localhost/bookstore/admin/api/allUsers.php"
    const productURL = "http://localhost/bookstore/admin/api/allProducts.php"
    const orderURL = "http://localhost/bookstore/admin/api/addOrder.php"

    $.ajax({
        url: userURL,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            loadUserDataList(resObj)
        }
    })

    $("#create_btn").on("click", function() {
        createOrder()
    })

    $("body").on("change", "#username", function() {
        // console.log(this.value)
        // console.log($("#username_data").children().get(0))
        let userOption = $("#username_data").children()
        for (let i = 0; i < userOption.length; i++) {
            if (userOption.get(i).value == this.value) {
                localStorage.setItem("user_id", userOption.get(i).dataset.id)
                console.log(localStorage.getItem("user_id"))
            }
        }
    })

    function loadUserDataList(userArr) {
        for (let i = 0; i < userArr.length; i++) {
            let data = `
                <option data-id="${userArr[i].id}" value="${userArr[i].username}">
            `
            $("#username_data").append(data)
        }
    }

    function loadProductOption(array) {
        for (let i = 0; i < array.length; i++) {
            let product = `
                <option value="${array[i].id}">${array[i].name}</option>
            `
            $("#product_select").append(product)
        }
    }

    function addProductToLocal() {
        let product_id = $("#product_select").val()
        let qty = $("#qty_item").val().trim()
        if (!localStorage.getItem("items")) {
            console.log("Items list in null")
            let item = [{
                "product_id": product_id,
                "quantity": qty
            }]
            let itemStr = JSON.stringify(item)
            localStorage.setItem("items", itemStr)
        } else {
            let items = localStorage.getItem("items")
            let itemsArr = JSON.parse(items)
            let exist = false
            for (let i = 0; i < itemsArr.length; i++) {
                if (itemsArr[i].product_id == product_id) {
                    exist = true
                    itemsArr[i].quantity = parseInt(qty) + parseInt(itemsArr[i].quantity)
                }
            }
            if (!exist) {
                let item = {
                    "product_id": product_id,
                    "quantity": qty
                }
                itemsArr.push(item)
            } 
            localStorage.setItem("items", JSON.stringify(itemsArr))
        }
    }

    function createOrder() {
        let username = $("#username").val().trim()
        if (username == "") {
            alert ("Vui lòng nhập username!")
        } else {
            // let discount = $("#discount").val().trim()
            // if (discount == "") {
            //     discount = "0.0"
            // }
            let status = $("#status").val()
            let user_id = localStorage.getItem("user_id")
            let data = {
                "user_id": user_id,
                "discount": "0.0",
                "invoice": "0",
                "status": status,
                "items":[]
            }
            $.ajax({
                url: orderURL,
                type: 'POST',
                data: JSON.stringify(data),
                dataType: 'json',
                success: function(res) {
                    location.href = "orderDetail.php?orderId=" + res.id
                }
            })
        }
    }

})