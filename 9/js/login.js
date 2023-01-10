$().ready(function () {
    $("#login-form").validate();

    $('#login-btn').click(function (e) {
        if (document.getElementById('login-form').checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "../php/login.php",
                type: 'post',
                data: $('#login-form').serialize(),
                success: function (response) {

                    if(response == 'welcome.html'){
                        window.location.href = '../html/' + response;
                    }else{
                        var errorMsg = $('#error-msg');
                        errorMsg.text(response);
                        errorMsg.css('display', 'block');
                    }

                },
                error: function (response) {

                    console.log('Error fetching data = ' + response.responseText);

                }
            });
        }
        return true;
    });
});