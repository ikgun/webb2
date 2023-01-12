var loginBtn = document.getElementById('login-btn');
var signupBtn = document.getElementById('signup-btn');
var cartBtn = document.getElementById('cart-btn');
var logoutBtn = document.getElementById('logout-btn');

var accountBtn = document.getElementById('account-btn');

loginBtn.addEventListener('click', function () {
    window.location.href = '../html/login.html';
});

signupBtn.addEventListener('click', function () {
    window.location.href = '../html/signup.html';
});

cartBtn.addEventListener('click', function () {
    window.location.href = '../html/cart.html';
});

logoutBtn.addEventListener('click', function () {
    window.location.href = '../php/logout.php';
});

accountBtn.addEventListener('click', function () {
    window.location.href = '../html/account.html';
});

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_cart_data.php",
        type: 'get',
        success: function (response) {

            if (response !== 'Your cart is empty!') {

                var response = JSON.parse(response);

                for (var i = 0; i < response.allProductNames.length; i++) {

                    var tr = document.createElement('tr');

                    var thName = document.createElement('th');
                    thName.textContent = response.allProductNames[i];
                    thName.className = "text-start";

                    var tdPrice = document.createElement('td');
                    tdPrice.textContent = "$" + response.allProductPrices[i];

                    var tdQty = document.createElement('td');
                    tdQty.textContent = response.allProductQtys[i];

                    var tdItemTtl = document.createElement('td');
                    tdItemTtl.textContent = "$" + response.allProductTotals[i];

                    var tdRemoveBtn = document.createElement('td');
                    var removeBtn = document.createElement('button');
                    removeBtn.className = "btn btn-primary";
                    removeBtn.textContent = "Remove";
                    tdRemoveBtn.appendChild(removeBtn);
                    
                    removeBtn.addEventListener('click', function () {
                    
                        $.ajax({
                            url: "../php/remove_item.php?product_id=" + removeBtn.id,
                            type: 'post',
                            success: function (response) {
                                
                                var errorMsg = $('#error-msg');
                                errorMsg.text(response);
                                errorMsg.css('display', 'block');

                            },
                            error: function (response) {

                                console.log('Error fetching data = ' + response.responseText);

                            }
                        });

                    });

                    tr.appendChild(thName);
                    tr.appendChild(tdPrice);
                    tr.appendChild(tdQty);
                    tr.appendChild(tdItemTtl);
                    tr.appendChild(tdRemoveBtn);

                    document.getElementById('totals-row').parentNode.insertBefore(tr, document.getElementById('totals-row'));
                    document.getElementById('cartTotal').textContent = "$" + response.cartTotal;
                    document.getElementById('itemCount').textContent = response.itemCount;
                }


            } else {
                console.log(response);
            }



        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});