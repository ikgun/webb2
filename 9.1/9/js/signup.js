$().ready(function(){
    $('#signup-btn').onclick(function() {

        $.ajax({
            url: "../js/signup.php", 
            method: 'post',
            data: $('#signup-form').serialize(),
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


