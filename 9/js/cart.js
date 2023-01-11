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
