$(document).ready(() => {
    const apiURL = "../bookstore/admin/api/";

    loadSearchList();
    function loadSearchList(){
        $.ajax({
            url: apiURL + "allProducts.php",
            type: "post",
            dataType: "json",
            success: function(res) {
                $.each(res.data, (index, Product) =>
                {
                    $("#search-list").append(`<option class="search-item">${Product.name}</option>`)
                })
            },
            error: function(error) {
                console.log(error.responseText)
            }
        })
    }
})


function search(){
    let input = $("#search-input").val();
    location.href = `category.php?name=${input}`;
}
