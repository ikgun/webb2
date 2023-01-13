import { headerLoggedIn, headerLoggedOut } from "./exports.js";

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_user_data.php",
        type: 'get',
        dataType: 'json',
        success: function (response) {

            if (response.userID !== null) {

                $('header').append(headerLoggedIn);

            } else if (response.userID == null){

                $('header').append(headerLoggedOut);

            }

        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_cart_data.php",
        type: 'get',
        success: function (data) {

            if (data !== 'Your cart is empty!') {

                var response = JSON.parse(data);

                for (var i = 0; i < response.allProductNames.length; i++) {

                    var tr = document.createElement('tr');

                    var thName = document.createElement('th');
                    thName.textContent = response.allProductNames[i];
                    thName.className = "text-start";

                    var tdID = document.createElement('td');
                    tdID.textContent = response.allProductIDs[i];
                    tdID.style.display = 'none';

                    var tdPrice = document.createElement('td');
                    tdPrice.textContent = "$" + response.allProductPrices[i];

                    var tdQty = document.createElement('td');
                    tdQty.textContent = response.allProductQtys[i];

                    var tdItemTtl = document.createElement('td');
                    tdItemTtl.textContent = "$" + response.allProductTotals[i];

                    var tdRemoveBtn = document.createElement('td');
                    var removeBtn = document.createElement('button');
                    removeBtn.className = "btn btn-warning";
                    removeBtn.id = response.allProductIDs[i];
                    removeBtn.textContent = "Remove";
                    removeBtn.style.fontWeight = 'bold';
                    tdRemoveBtn.appendChild(removeBtn);

                    removeBtn.addEventListener('click', function (e) {
                        
                        alertify.defaults.theme.ok = "btn btn-success";
                        alertify.defaults.theme.cancel = "btn btn-danger";
                        alertify.confirm(
                            'Remove item', 
                            'Do you really want to remove item(s) from your cart?',
                            function () {
                                $.ajax({
                                    url: "../php/remove_item.php?product_id=" + e.target.id,
                                    type: 'post',
                                    success: function (response) {

                                        $(e.target).removeClass('btn-warning');
                                        $(e.target).addClass('btn-danger');
                                        e.target.textContent = response;
                                        e.target.disabled = 'true';

                                    },
                                    error: function (response) {

                                        console.log('Error fetching data = ' + response.responseText);

                                    }
                                });
                                
                            },function () {});

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
                document.getElementById('table').style.display = 'none';
                document.getElementById('continue').style.display = 'none';
                var msg = $('#msg');
                msg.text(data);
                msg.css('display', 'block');
            }

        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});

$('#continue').click(function () {

    alertify.defaults.theme.ok = "btn btn-success";
    alertify.alert('Checkout', 'There is no checkout as this is not a real website', function () {});

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