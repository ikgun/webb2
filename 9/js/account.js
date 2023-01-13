import { headerLoggedIn, headerLoggedOut } from "./exports.js";

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_user_data.php",
        type: 'get',
        success: function (response) {

            var welcomeMsg = document.getElementById('welcome-user');

            if (response !== 'No user logged in') {

                $('#header').append(headerLoggedIn);
                var response = JSON.parse(response);
                welcomeMsg.textContent = 'Hi, ' + response[0].userName + '!';
                document.getElementById('user-email').textContent = response[0].userEmail;

            } else {

                $('#header').append(headerLoggedOut);
                welcomeMsg.textContent = 'Hi!';

            }

        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});

$('#delete-btn').click(function () {

    alertify.defaults.theme.ok = "btn btn-success";
    alertify.defaults.theme.cancel = "btn btn-danger";
    alertify.confirm(
        'Delete account',
        'Do you really want to delete your account?',
        function () {
            $.ajax({
                url: "../php/delete_user.php",
                type: 'post',
                success: function (response) {
    
                    window.alert(response);
                    window.location.href = '../html/welcome.html';
    
                },
                error: function (response) {
    
                    console.log('Error fetching data = ' + response.responseText);
    
                }
            });

        }, function(){});

    // if (confirm('Do you really want to delete your account?')) {
    //     $.ajax({
    //         url: "../php/delete_user.php",
    //         type: 'post',
    //         success: function (response) {

    //             window.alert(response);
    //             window.location.href = '../html/welcome.html';

    //         },
    //         error: function (response) {

    //             console.log('Error fetching data = ' + response.responseText);

    //         }
    //     });
    // }
});

$('#change-name-btn').click(function () {
    document.getElementById('change-name-form').style.display = 'block';
});

$('#change-email-btn').click(function () {
    document.getElementById('change-email-form').style.display = 'block';
});

$('#cancel-name-btn').click(function (e) {
    e.preventDefault();
    document.getElementById('change-name-form').style.display = 'none';
});

$('#cancel-email-btn').click(function (e) {
    e.preventDefault();
    document.getElementById('change-email-form').style.display = 'none';
});

$("#change-name-form").validate();

$('#submit-name-btn').click(function (e) {
    if (document.getElementById('change-name-form').checkValidity()) {
        e.preventDefault();
        $.ajax({
            url: "../php/change_name.php",
            type: 'post',
            data: $('#change-name-form').serialize(),
            success: function (response) {

                var errorMsg = $('#name-error-msg');
                errorMsg.text(response);
                errorMsg.css('display', 'block');

            },
            error: function (response) {

                console.log('Error fetching data = ' + response.responseText);

            }
        });
    }
    return true;
});

$("#change-email-form").validate();

$('#submit-email-btn').click(function (e) {
    if (document.getElementById('change-email-form').checkValidity()) {
        e.preventDefault();
        $.ajax({
            url: "../php/change_email.php",
            type: 'post',
            data: $('#change-email-form').serialize(),
            success: function (response) {

                var errorMsg = $('#email-error-msg');
                errorMsg.text(response);
                errorMsg.css('display', 'block');

            },
            error: function (response) {

                console.log('Error fetching data = ' + response.responseText);

            }
        });
    }
    return true;
});

