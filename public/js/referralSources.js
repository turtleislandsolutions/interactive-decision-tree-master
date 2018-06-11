$(document).ready(function () {

    var source, template, resp, formVals;

    var oTable = $('#refTable').dataTable({ });

    $('.ref-add').click(function (e) {
        e.preventDefault();
        source   = $('#add-template').html();
        template = Handlebars.compile(source);
        $('.ref-container').html(template());
        $('form[name="ref-add-form"]').validate({
            submitHandler: function(form) {
                e.preventDefault();
                formVals = $(form).serializeArray();
                $.post('../private/referral_crud.php', formVals, function (data){
                    var resp = $.parseJSON(data);
                    if (resp.status === 'OK'){
                        $('.notify-text').html(resp.message);
                        $('.notify').addClass('alert-success').show().delay(2500).fadeOut();
                        $.post('../private/referral_crud.php',{'action':'read','id': resp.last_id}, function (d){
                            resp = $.parseJSON(d);
                            source   = $('#view-template').html();
                            template = Handlebars.compile(source);
                            $('.ref-container').html(template(resp));
                        });
                    } else {
                        $('.notify-text').html(resp.message);
                        $('.notify').addClass('alert-danger').show().delay(2500).fadeOut();

                    }
                });
            }
        });

    });

    //Request Edit
    $('.container').on('click', '.ref-edit', function (e) {
        e.preventDefault();
        var itemId = $(this).attr('data-id');
        $.post('../private/referral_crud.php', {'action': 'read', 'id': itemId}, function (data){
            resp = $.parseJSON(data);
            source   = $('#update-template').html();
            template = Handlebars.compile(source);
            $('.ref-container').html(template(resp));
            $('form[name="ref-edit-form"]').validate({
                submitHandler: function (form) {
                    formVals = $(form).serializeArray();
                    $.post('../private/referral_crud.php', formVals, function (data){
                        var resp = $.parseJSON(data);
                        if (resp.status === 'OK'){
                            $('.notify-text').html(resp.message);
                            $('.notify').addClass('alert-success').show().delay(2500).fadeOut();
                            var itemId = resp.last_id;
                            $.post('../private/referral_crud.php', {'action':'read','id': itemId}, function (data){
                                resp = $.parseJSON(data);
                                source   = $('#view-template').html();
                                template = Handlebars.compile(source);
                                $('.ref-container').html(template(resp));
                            });
                        } else {
                            $('.notify-text').html(resp.message);
                            $('.notify').removeClass('alert-success').addClass('alert-danger').show().delay(2500).fadeOut();
                        }
                    });
                }
            
            });
        });
    });

    //Cancel edit
    $('.container').on('click','.ref-cancel-update', function (e) {
        e.preventDefault();
        var itemId = $(this).attr('data-id');
        $.post('../private/referral_crud.php',{'action':'read','id': itemId}, function (d){
            resp = $.parseJSON(d);
            source   = $('#view-template').html();
            template = Handlebars.compile(source);
            $('.ref-container').html(template(resp));
        });
    });

    //Delete Referral
    $('.container').on('click','.ref-delete', function (e) {
        e.preventDefault();
        var ok = confirm('This will delete this record.  Are You Sure?');
        if (ok){
            var itemId = $(this).attr('data-id');
            $.post('../private/referral_crud.php', {'action':'delete','id': itemId}, function (data){
                var resp = $.parseJSON(data);
                if (resp.status === 'OK'){
                    $('.notify-text').html(resp.message);
                    $('.notify').addClass('alert-success').show().delay(2500).fadeOut();
                    $.post('../private/referral_crud.php',{'action':'read','id': resp.last_id}, function (d){
                        resp = $.parseJSON(d);
                        source   = $('#deleted-template').html();
                        template = Handlebars.compile(source);
                        $('.ref-container').html(template(resp));
                    });
                } else {
                    $('.notify-text').html(resp.message);
                    $('.notify').addClass('alert-danger').show().delay(2500).fadeOut();

                }
            });
        }
    });

    //Show list of available trees
    $('.container').on('click','.ref-assign', function (e) {
        e.preventDefault();
        var itemId = $(this).attr('data-id');
        $.post('../private/assign_to_tree.php',{'id': itemId}, function (data){
            $('.ref-container').html(data);
        });
    });

    //Change the referral's tree assignment
    $('.container').on('click','.ref-assign-do', function (e) {
        e.preventDefault();
        var itemId = $(this).attr('data-id');
        var formVals = $(this).closest('form').serializeArray();
        $.post('../private/assign_to_tree.php',{'action': 'update','id': itemId,'assign': formVals}, function (data){
            $('.ref-container').html(data);
            $('.notify-text').html('Tree Assignments Updated');
            $('.notify').addClass('alert-success').show().delay(2500).fadeOut();
        });

    });

    //Cancel assigning trees
    $('.container').on('click','.ref-assign-cancel', function (e) {
        e.preventDefault();
        var itemId = $(this).attr('data-id');
        $.post('../private/referral_crud.php',{'action':'read','id': itemId}, function (d){
            resp = $.parseJSON(d);
            source   = $('#view-template').html();
            template = Handlebars.compile(source);
            $('.ref-container').html(template(resp));
        });
    });

    //Click a table row
    $('tbody tr').click(function (event){
        event.preventDefault();
        var itemId = $(this).attr('data-id');
        $.post('../private/referral_crud.php', {'action':'read','id': itemId}, function (data){
            resp = $.parseJSON(data);
            source   = $('#view-template').html();
            template = Handlebars.compile(source);
            $('.ref-container').html(template(resp));
        });
    });

    $('body').popover({selector: '[rel=popover]'});
});

$(document).ajaxError(function( event, jqxhr, settings, exception ) {

    $('.notify-text').html('<strong>Sorry!</strong> There was a problem talking to the server.');
    $('.notify').addClass('alert-danger').show().delay(2500).fadeOut();

});
