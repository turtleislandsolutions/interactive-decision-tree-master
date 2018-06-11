$(document).ready(function () {

    if (typeof $.cookie('idt-admin') !== 'undefined'){
        $('input[name="username"]').val($.cookie('idt-admin'));
        $('input[name="rememberMe"]').prop('checked',true);
    }

    $('button').click(function (event) {
        event.preventDefault();
        $.each($('input.form-control'), function () {
            if ($(this).val() === ''){
                $('.login-error').css('visibility','visible').html('All Fields Are Required');
                return false;
            }
        });

        var user = $('input[name="username"]').val();
        var pass = $('input[name="password"]').val();
        var remember = $('input[name="rememberMe"]');
        $.post('backend.php',{'username':user,'password':pass,'action':'login'}, function (data) {
            var resp = $.parseJSON(data);
            if (resp.status === 'OK'){
                if (remember.is(':checked')){
                    $.cookie('idt-admin',user,{expires:365});
                } else {
                    if (typeof $.cookie('idt-admin') !== 'undefined'){
                        $.removeCookie('idt-admin');
                    }
                }
                window.location = 'editTree.php';
            } else {
                $('.login-error').css('visibility','visible').html(data.message);
                return;
            }

        });

    });







});
