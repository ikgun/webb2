var loginBtn = document.getElementById('login-btn');
var signupBtn = document.getElementById('signup-btn');
var cartBtn = document.getElementById('cart-btn');
var logoutBtn = document.getElementById('logout-btn');

var accountBtn = document.getElementById('account-btn');

loginBtn.addEventListener('click', function(){
    window.location.href = '../html/login.html';
});

signupBtn.addEventListener('click', function(){
    window.location.href = '../html/signup.html';
});

cartBtn.addEventListener('click', function(){
    window.location.href = '../html/cart.html';
});

logoutBtn.addEventListener('click', function(){
    window.location.href = '../php/logout.php';
});

accountBtn.addEventListener('click', function(){
    window.location.href = '../html/account.html';
});

var deleteBtn = document.getElementById('delete-btn');

deleteBtn.addEventListener('click', function () {
    if (confirm('Do you really want to delete your account?')) {
        $.ajax({
            url: "../php/delete_user.php",
            type: 'get',
            success: function (response) {

                window.alert(response);
                window.location.href = '../html/welcome.html';

            },
            error: function (response) {

                console.log('Error fetching data = ' + response.responseText);

            }
        });
    }
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

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_user_data.php",
        type: 'get',
        success: function (response) {

            var welcomeMsg = document.getElementById('welcome-user');

            if (response !== 'No user logged in') {

                var response = JSON.parse(response);
                welcomeMsg.textContent = 'Hi, ' + response[0].userName + '!';
                document.getElementById('user-email').textContent = response[0].userEmail;

            } else {

                welcomeMsg.textContent = 'Hi!';

            }

        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});