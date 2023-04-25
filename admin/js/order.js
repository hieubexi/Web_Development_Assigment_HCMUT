$(document).ready(function() {
    const URL = "http://localhost/bookstore/admin/api/"
    let orderTable = $("#orderTable").DataTable({
        columns: [{
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
        columnDefs: [{
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
                defaultContent: "<button type='button' class='btn btn-success orderDetail'><i class='fa fa-search'></i> Details</button>"
            }
        ]
    })

    $.ajax({
        url: URL + "orders.php",
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
    $(".close").click(function() {
        $("#modalItems").modal("hide")
        // console.log("Button")
    })

    $("#orderTable").on("click", ".orderDetail", function() {
        orderDetailHandle(this)
    })

    function loadOrderTable(object) {
        orderTable.clear()
        orderTable.rows.add(object)
        orderTable.draw()
    }

    function orderDetailHandle(btn) {
        let selectedRow = $(btn).parents("tr")
        let data = orderTable.row(selectedRow)
        let orderData = data.data()
        location.href = "orderDetail.php?orderId=" + orderData.id
    }
})