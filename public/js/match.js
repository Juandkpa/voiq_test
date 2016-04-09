
$(document).ready(function(){
    /**
     * Manage loading image
     */
    $('#loadingImg')
        .hide()  // hide it initially
        .ajaxStart(function() {
            $(this).show();
        })
        .ajaxStop(function() {
            $(this).hide();
        })
    ;

    /**
     * Handler for manage matching ajax request
     */
    $('#btnMatch').click(function(){

        var $frm = $('#frmMatch');
        var data = $frm.serialize();
        var url = $frm.data('url');

        if($frm[0].checkValidity()){
            var fnCallback = function(response){
                $('#matching').html(response);
            };
            var fnError = function(){
                alert("Error in matching!");
            };
            $.post(url, data, fnCallback).fail(fnError);
            return false;
        }
    });
});