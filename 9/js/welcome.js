import { headerLoggedIn, headerLoggedOut } from "./exports.js";

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_user_data.php",
        type: 'get',
        dataType: 'json',
        success: function (response) {

            if (response.userID !== null) {

                $('header').append(headerLoggedIn);
                document.getElementById('welcome-user').textContent = 'Welcome, ' + response.userName + '!';
                

            } else if (response.userID == null){

                $('header').append(headerLoggedOut);

            }

        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});

$("#sub-form").validate();

$('#submitBtn').click(function (e) {

    if (document.getElementById('sub-form').checkValidity()) {

        e.preventDefault();
        $.ajax({
            url: "../php/subscribe.php",
            type: 'post',
            data: $('#sub-form').serialize(),
            success: function (response) {

                $("#submitBtn").attr("disabled", true);

                alertify.defaults.theme.ok = "btn btn-success";
                alertify.alert(
                    'Subscribe', response, function () { });

            },
            error: function (response) {

                console.log('Error fetching data = ' + response.responseText);

            }
        });
    }
    return true;


});






