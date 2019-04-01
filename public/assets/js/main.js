
var spinnerHtml = '<div class="spinner-border text-success text-center" role="status"><span class="sr-only">Loading...</span></div>';


jQuery(document).ready(function () {

    console.log('main');

    jQuery('body').on('click', '[data-toggle="modal-url"]', function(){

        var remonte = jQuery(this).data("remote");
        var target = jQuery(this).data("target") + ' .modal-body';

        jQuery(target).html(spinnerHtml);

        //console.log( remonte );

        jQuery(target).load(remonte);

        jQuery('#invoiceItemsEditModal').modal();
    });

    jQuery('body').on('click', '#invoice_item_form_submit', function(){

        var id = jQuery(this).data('id');

        console.log('sss ' + id);

        invoiceItemSave(id);



    });

    }
);



function invoiceItemSave(itemId) {

    //var itemId

    //invoice_item_form_div


    //invoice_item_form_submit




    var datastring = $("#invoice_item_form_id").serialize();
    $.ajax({
        type: "POST",
        url: "/invoiceitem/edit/" + itemId,
        data: datastring,
        //dataType: "json",
        success: function(data) {

            //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
            // do what ever you want with the server response

            //console.log(data);

            jQuery('#invoiceItemsEditModal .modal-body').html(data);

        },
        error: function() {
            alert('error handling here');
        }
    });


}