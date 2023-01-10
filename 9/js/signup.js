$().ready(function () {

    $("#signup-form").validate();

    $('#signup-btn').click(function (e) {
        if (document.getElementById('signup-form').checkValidity()) {
            e.preventDefault();
            $.ajax({
                url: "../php/signup.php",
                type: 'post',
                data: $('#signup-form').serialize(),
                success: function (response) {

                    var errorMsg = $('#error');
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
    
});


