function success(){
    swal({   title: "Login Success!",   text: "redirecting....",   type: "success",   confirmButtonText: "OK" , timer: 1500 });
}

$(function() {
    var alertDiv = $('#alert');
    var form = $('form');
    var btn = form.find('input[type=submit]');
    var errDiv = alertDiv.find('div[data-msg=error]');
    var emptyDiv = alertDiv.find('div[data-msg=empty]');
    
    form.on('submit', function(e) {
        e.preventDefault();
        errDiv.hide();
        emptyDiv.hide();
        btn.button('loading');
        
        var username = form.find('input#username').val();
        var password = form.find('input#password').val();

        if(username == '' || password == '') {
            btn.button('reset');
            emptyDiv.fadeToggle();
            $('#box').shake();
        } else {
            $.post(form.attr('action'), form.serialize(), function(data) {

                if(data.message == 1) {
                    success();
                    btn.button('reset');
                    
                    setTimeout(function() {
                        location.reload(true);
                    }, 1600);
                } else if(data.message == 0){
                    btn.button('reset');
                    errDiv.fadeToggle();
                    $('#box').shake();
                }
            }, 'json');
        }
    });
})