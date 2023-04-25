$(document).ready(function() {
    const user_id = getCookie("user_id")
    const userInfoURL = "http://localhost/bookstore/admin/api/getUserById.php"
    const updateUserInfoURL = "http://localhost/bookstore/admin/api/updateUserById.php"

    $.ajax({
        url: userInfoURL + "?userId=" + user_id,
        dataType: 'json',
        success: function(res) {
            console.log(res)
            loadUserData(res)
        },
        error: function(res) {
            console.error(res.message)
        }
    })
    function loadUserData(userObj) {
        $("#firstname").val(userObj.firstName)
        $("#lastname").val(userObj.lastName)
        $("#username").val(userObj.username)
        $("#phone").val(userObj.phone)
        $("#email").val(userObj.email)
        $("#address").val(userObj.address)
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

    $(".user_update_btn").on("click", function() {
        updateUser()        
    })

    function updateUser() {
        let fname = $("#firstname").val().trim()
        let lname = $("#lastname").val().trim()
        let email = $("#email").val().trim()
        let phone = $("#phone").val().trim()
        let address = $("#address").val().trim()
        check = true
        let user = {
            "id": user_id,
            "firstname": fname,
            "lastname": lname,
            "phone": phone,
            "email": email,
            "address": address
        }
        console.log(user)
        $.ajax({
            url: updateUserInfoURL,
            type: 'PUT',
            data: JSON.stringify(user),
            dataType: 'json',
            success: function(resObj) {
                alert("Cập nhật thành công!")
            },
            error: function(responseText) {
                console.error(responseText)
            }
        })
    }

    $("body").on("change", "#firstname", function() {
        if (validateEmpty(this.value.trim())) {
            $("#firstname_notification").html("")
            $('.user_update_btn').prop('disabled', false);
        } else {
            $("#firstname_notification").html("(*) Vui lòng nhập họ và tên đệm!") 
            $('.user_update_btn').prop('disabled', true);
        }
    })

    $("body").on("change", "#lastname", function() {
        if (validateEmpty(this.value.trim())) {
            $("#lastname_notification").html("")
            $('.user_update_btn').prop('disabled', false);
        } else {
            $("#lastname_notification").html("(*) Vui lòng nhập tên!") 
            $('.user_update_btn').prop('disabled', true);
        }
    })

    $("body").on("change", "#email", function() {
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        if (validateEmpty(this.value.trim())) {
            if (this.value.trim().match(validRegex)) {
                $("#email_notification").html("")
                $('.user_update_btn').prop('disabled', false);
            } else {
                $("#email_notification").html("(*) Email chưa đúng định dạng!") 
                $('.user_update_btn').prop('disabled', true);
            }
        } else {
            $("#email_notification").html("(*) Vui lòng nhập email!") 
            $('.user_update_btn').prop('disabled', true);
        }
    })

    $("body").on("change", "#phone", function() {
        let regex = /^\d+$/
        console.log(regex)
        if (validateEmpty(this.value.trim())) {
            if (!regex.test(this.value.trim())) {
                $("#phone_notification").html("(*) Số điện thoại chỉ chứa kí tự số!") 
                $('.user_update_btn').prop('disabled', true);
            } else if (this.value.trim().length != 10){
                $("#phone_notification").html("(*) Số điện thoại có độ dài là 10!") 
                $('.user_update_btn').prop('disabled', true);
            } else {
                $("#phone_notification").html("")
                $('.user_update_btn').prop('disabled', false);
            }
        } else  {
            $("#phone_notification").html("(*) Vui lòng nhập phone!") 
            $('.user_update_btn').prop('disabled', true);
        }
    })

    $("body").on("change", "#address", function() {
        if (validateEmpty(this.value.trim())) {
            $("#address_notification").html("")
            $('.user_update_btn').prop('disabled', false);
        } else {
            $("#address_notification").html("(*) Vui lòng nhập address!") 
            $('.user_update_btn').prop('disabled', true);
        }
    })

    function validateEmpty(string) {
        if (string == "") {
            return false
        }
        return true
    }
})