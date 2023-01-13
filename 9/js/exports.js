function header() {

    var div = document.createElement('div');
    div.className = "d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom";
    
    var iconLink = document.createElement('a');
    iconLink.href = "../html/welcome.html";

    var iconFig = document.createElement('figure');
    iconFig.style.width = '40px';

    var iconImg = document.createElement('img');
    iconImg.src = '../images/home-icon.svg';
    iconImg.style.width = '100%';

    iconFig.appendChild(iconImg);
    iconLink.appendChild(iconFig);
    div.appendChild(iconLink);

    var nav = document.createElement('ul');
    nav.className = "nav col-12 col-md-auto mb-2 justify-content-center mb-md-0";

    var navItemHome = document.createElement('li');
    var navLinkHome = document.createElement('a');
    navLinkHome.className = "nav-link px-2 link-secondary";
    navLinkHome.href = "../html/welcome.html";
    navLinkHome.textContent = "Home";
    navItemHome.appendChild(navLinkHome);
    nav.appendChild(navItemHome);

    var navItemShop = document.createElement('li');
    var navLinkShop = document.createElement('a');
    navLinkShop.className = "nav-link px-2 link-dark";
    navLinkShop.href = "../html/shop.html";
    navLinkShop.textContent = "Shop";
    navItemShop.appendChild(navLinkShop);
    nav.appendChild(navItemShop);

    div.appendChild(nav);

    return div;

}

export function headerLoggedIn() {

    var h = header();

    var div = document.createElement('div');
    div.className = "col-md-3 text-end";

    var accountBtn = document.createElement('button');
    accountBtn.className = "btn btn-outline-primary me-1";
    accountBtn.textContent = "Account";
    accountBtn.addEventListener('click', function () {
        window.location.href = '../html/account.html';
    });

    var logoutBtn = document.createElement('button');
    logoutBtn.className = "btn btn-primary me-1";
    logoutBtn.textContent = "Logout";
    logoutBtn.addEventListener('click', function () {
        window.location.href = '../php/logout.php';
    });

    div.appendChild(accountBtn);
    div.appendChild(logoutBtn);
    div.appendChild(addToCartBtn());
    h.appendChild(div);

    return h;

}

export function headerLoggedOut() {

    var h = header();

    var div = document.createElement('div');
    div.className = "col-md-3 text-end";

    var loginBtn = document.createElement('button');
    loginBtn.className = "btn btn-outline-primary me-1";
    loginBtn.textContent = "Login";
    loginBtn.addEventListener('click', function () {
        window.location.href = '../html/login.html';
    });

    var signupBtn = document.createElement('button');
    signupBtn.className = "btn btn-primary me-1";
    signupBtn.textContent = "Signup";
    signupBtn.addEventListener('click', function () {
        window.location.href = '../html/signup.html';
    });

    div.appendChild(loginBtn);
    div.appendChild(signupBtn);
    div.appendChild(addToCartBtn());
    h.appendChild(div);

    return h;

}

function addToCartBtn() {

    var btn = document.createElement('button');
    var span1 = document.createElement('span');
    span1.textContent = 'Cart';
    var span2 = document.createElement('span');
    span2.className = "badge bg-primary rounded-pill ms-1";
    btn.className = "btn btn-outline-primary";
    btn.addEventListener('click', function () {
        window.location.href = '../html/cart.html';
    });
    btn.addEventListener('mouseover', function () {
        span2.classList.remove('bg-primary');
        span2.classList.add('bg-light');
        span2.style.color = 'black';
    });
    btn.addEventListener('mouseout', function () {
        span2.classList.add('bg-primary');
        span2.classList.remove('bg-light');
        span2.style.color = 'white';

    });
    $.ajax({
        url: "../php/fetch_cart_data.php",
        type: 'get',
        success: function (data) {
            if (data !== 'Your cart is empty!') {

                var response = JSON.parse(data);
                for (var i = 0; i < response.allProductNames.length; i++) {
                    span2.textContent = response.itemCount;
                }
            } else {
                span2.textContent = '0';
            }
        }
    });
    btn.appendChild(span1);
    btn.appendChild(span2);
    return btn;
}