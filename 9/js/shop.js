
$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_product_data.php",
        type: 'get',
        dataType: 'json',
        success: function (response) {

            response.forEach(element => {

                var productBox = document.createElement('productBox');
                productBox.className = 'd-flex justify-content-center col-md-4 mb-4 mt-4 text-center';

                var productForm = document.createElement('form');
                productForm.id = 'form' + element.productID;

                var figure = document.createElement('figure');
                figure.style.width = '200px';
                figure.style.height = '200px';
                figure.style.textAlign = 'center';
                figure.style.justifyContent = 'center';

                var productImg = document.createElement('img');
                productImg.src = '../images/' + element.productImgSrc;
                productImg.style.width = '100%';
                productImg.style.height = '100%';
                figure.appendChild(productImg);

                var productName = document.createElement('p');
                productName.textContent = element.productName;
                productName.className = 'text-center';

                var hiddenName = document.createElement('input');
                hiddenName.type = 'hidden';
                hiddenName.name = 'hiddenName';
                hiddenName.value = element.productName;

                var productPrice = document.createElement('p');
                productPrice.textContent = '$'+element.productPrice;
                productPrice.className = 'text-center text-muted';

                var hiddenPrice = document.createElement('input');
                hiddenPrice.type = 'hidden';
                hiddenPrice.name = 'hiddenPrice';
                hiddenPrice.value = element.productPrice;

                var productQty = document.createElement('input');
                productQty.type = 'number';
                productQty.value = '1';
                productQty.className = 'mb-2';

                var addToCartBtn = document.createElement('input');
                addToCartBtn.style.display = 'block';
                addToCartBtn.style.width = '100%';
                addToCartBtn.style.fontWeight = 'bold';
                addToCartBtn.type = 'submit';
                addToCartBtn.className = 'btn btn-warning text-center';
                addToCartBtn.value = 'Add to cart';

                addToCartBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    $ajax({
                        url: '../php/shop.php?product-id=' + element.productID,
                        type: 'post',
                        data: $('#form' + element.productID).serialize(),
                        success: function (response) {

                            window.alert(response);

                        },
                        error: function (response) {
                            console.log('Error sending data = ' + response.responseText);
                        }
                    })

                });

                productForm.appendChild(figure);
                productForm.appendChild(productName);
                productForm.appendChild(productPrice);
                productForm.appendChild(productQty);
                productForm.appendChild(addToCartBtn);
                productForm.appendChild(hiddenName);
                productForm.appendChild(hiddenPrice);

                productBox.appendChild(productForm);

                document.getElementById('shop').appendChild(productBox);
                
            });

        },
        error: function (response) {

            console.log('Error fetching data = ' + response.responseText);

        }
    });

});






