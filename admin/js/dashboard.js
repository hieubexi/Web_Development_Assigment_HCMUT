$(document).ready(function() {
    const numBooksURL = "http://localhost/bookstore/admin/api/numOfBooks.php"
    const numOrdersURL = "http://localhost/bookstore/admin/api/numOfOrders.php"
    const numUsersURL = "http://localhost/bookstore/admin/api/numOfUsers.php"
    const numCategoryURL = "http://localhost/bookstore/admin/api/numOfCategory.php"
    const orderURL = "http://localhost/bookstore/admin/api/getOrderOnProcessing.php"
    const orderUpdateURL = "http://localhost/bookstore/admin/api/updateOrderStatus.php"
    const ORDER_ACCEPT = "Accepted"
    const ORDER_REJECT = "Rejected"

    $.ajax({
        url: numCategoryURL,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            $("#category").html(resObj + " Danh mục")
        }
    })

    $.ajax({
        url: numBooksURL,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            $("#book").html(resObj + " Sách")
        }
    })

    $.ajax({
        url: numOrdersURL,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            $("#order").html(resObj + " Đơn hàng")
        }
    })

    $.ajax({
        url: numUsersURL,
        type: "GET",
        dataType: 'json',
        success: function(resObj) {
            $("#user").html(resObj + " Khách hàng")
        }
    })

    let orderTable = $("#orderTable").DataTable({
        columns: [
            {
                data: "username"
            },
            {
                data: "code"
            },
            {
                data: "discount"
            },
            {
                data: "invoice"
            },
            {
                data: "status"
            },
            {
                data: "Action"
            }
        ],
        columnDefs: [
            {
                targets: 0,
                width: "15%"
            },
            {
                targets: 2,
                width: "15%"
            },
            {
                targets: 3,
                width: "15%"
            },
            {
                targets: 4,
                width: "15%"
            },
            {
                targets: 5,
                defaultContent: "<button type='button' class='btn btn-primary orderDetail'><i class='fa fa-search'></i> Detail</button>" + " " + "&nbsp" + "<button type='button' class='btn btn-success accept_btn'><i class='fa fa-check'></i> Accept</button>" + " " + "&nbsp" + 
                "<button type='button' class='btn btn-warning reject_btn'><i class='fa fa-trash'></i> Reject</button>"
            }
        ]
    })

    $.ajax({
        url: orderURL,
        type: "get",
        dataType: "json",
        success: function(res) {
            loadOrderTable(res.data)
            // console.log(res[0]["image"])
        },
        error: function(error) {
            console.log(error.responseText)
        }
    })

    function loadOrderTable(object) {
        orderTable.clear()
        orderTable.rows.add(object)
        orderTable.draw()
    }

    $("#orderTable").on("click", ".accept_btn", function() {
        acceptOrderHandle(this)
    })

    $("#orderTable").on("click", ".reject_btn", function() {
        rejectOrderHandle(this)
    })

    $("#orderTable").on("click", ".orderDetail", function() {
        orderDetailHandle(this)
    })

    function orderDetailHandle(btn) {
        let selectedRow = $(btn).parents("tr")
        let data = orderTable.row(selectedRow)
        let orderData = data.data()
        location.href = "orderDetail.php?orderId=" + orderData.id
    }

    function acceptOrderHandle(btn) {
        let selectedRow = $(btn).parents("tr")
        let data = orderTable.row(selectedRow)
        let orderData = data.data()
        let orderStatus = {
            "id": orderData.id,
            "status": ORDER_ACCEPT
        }
        $.ajax({
            url: orderUpdateURL,
            type:"PUT",
            data: JSON.stringify(orderStatus),
            dataType: "json",
            success: function(res) {
                location.reload()
            }
        })
    }

    function rejectOrderHandle(btn) {
        let selectedRow = $(btn).parents("tr")
        let data = orderTable.row(selectedRow)
        let orderData = data.data()
        let orderStatus = {
            "id": orderData.id,
            "status": ORDER_REJECT
        }
        $.ajax({
            url: orderUpdateURL,
            type:"PUT",
            data: JSON.stringify(orderStatus),
            dataType: "json",
            success: function(res) {
                location.reload()
            }
        })
    }
})