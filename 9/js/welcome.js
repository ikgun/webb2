import { headerLoggedIn, headerLoggedOut } from "./exports.js";

$(window).on('load', function () {

    $.ajax({
        url: "../php/fetch_user_data.php",
        type: 'get',
        success: function (response) {

            var welcomeMsg = document.getElementById('welcome-user');

            if(response !== 'No user in database' && response !== 'No user logged in'){
               
                $('#header').append(headerLoggedIn);
                var response = JSON.parse(response);
                welcomeMsg.textContent = 'Welcome, ' + response[0].userName + '!';

            }else{

                $('#header').append(headerLoggedOut);
                welcomeMsg.textContent = 'Welcome!';

            }

           
        },
        error: function (response) {

            console.log(response.responseText);

        }
    });

});






