import { headerLoggedIn, headerLoggedOut } from "./exports.js";

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_user_data.php",
        type: 'get',
        success: function (response) {

            if (response !== 'No user logged in') {

                $('#header').append(headerLoggedIn);

            } else {

                $('#header').append(headerLoggedOut);
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
        success: function (response) {

            if (response !== 'Your cart is empty!') {

                var response = JSON.parse(response);

                console.log(response);

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
                                        e.target.style.cursor = 'not-allowed'

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
                msg.text(response);
                msg.css('display', 'block');
            }

        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});