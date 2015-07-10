$(function() {
    var alertDiv = $('#alert');
    var form = $('form');
    var btn = form.find('input[type=submit]');
    var succDiv = alertDiv.find('div[data-msg=success]');
    var errDiv = alertDiv.find('div[data-msg=error]');
    var emptyDiv = alertDiv.find('div[data-msg=empty]');

    form.on('submit', function(e) {
        e.preventDefault();
        succDiv.hide();
        errDiv.hide();
        emptyDiv.hide();
        btn.button('loading');

        var username = form.find('input#username').val();
        var password = form.find('input#password').val();

        if (username == '' || password == '') {
            btn.button('reset');
            emptyDiv.fadeToggle();
            $('#box').shake();
        } else {
            $.post(form.attr('action'), form.serialize(), function(data) {
                if (data.message == 1) {
                    succDiv.fadeToggle();
                    btn.button('reset');

                    setTimeout(function() {
                        location.reload(true);
                    }, 1600);
                } else if (data.message == 0) {
                    btn.button('reset');
                    errDiv.fadeToggle();
                    $('#box').shake();
                }
            }, 'json');
        }
    });
})