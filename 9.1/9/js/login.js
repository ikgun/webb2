$().ready(function(){
    $('#login-btn').onclick(function() {

        $.ajax({
            url: "../js/login.php", 
            method: 'post',
            data: $('#login-form').serialize(),
            success: function(response){
    
                var errorMsg = $('#error');
                errorMsg.text(response);
                errorMsg.css('display','block');
                
            },
            error: function (response) {
    
                console.log('Error fetching data = ' + response.responseText);
                
            }
        });
    });
});