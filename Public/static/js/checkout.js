function loginDuringCheckout(){
    var formData = $('#sign-in-form').serialize();
    if($('#sign-in-form').valid()){
        $.ajax({
            url: "/cart/loginUserCheckout",
            type: 'POST',
            data: formData,
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
                if(resp.error == 0){
                    //location.reload(true);
                    $('login-tab').removeClass("active");
                    $('shipping-details-tab').addClass("active");
                    $('.btn.btn-next.btn-fill.btn-warning.btn-wd.btn-sm').trigger("click");
                }else{
                    $('#error_msg').show();
                    $('#error_msg').text(resp.error_msg);
                }
            }
        });
    }
}

function submitSignupFormDuringCheckout(){
    var formData = $('#sign-up-form').serialize();
    if($('#sign-up-form').valid()){
        $.ajax({
            url: "/cart/saveUser",
            type: 'POST',
            data: formData,
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
                //  alert(resp.error);
                if(resp.error == 0){
                     location.reload(true);
                }else{
                    alert(resp.error_msg);
                }
            }
        });
    }
}

function updateShippingAddress(){
    var formData = $('#shipping-address-form').serialize(); 
    if($('#shipping-address-form').valid()){
        $.ajax({
            url: "/cart/updateShippingAddress",
            type: 'POST',
            data: formData,
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
//                alert(resp.error);
                if(resp.error == 0){
                     $('.btn.btn-next.btn-fill.btn-warning.btn-wd.btn-sm').trigger("click");
                }else{
                }
            }
        });
    }
}

function proceedToPayment(){
        $.ajax({
            url: "/product/generateOrder",
            type: 'POST',
            data: {},
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
//                alert(resp.error);
                if(resp.error == 0){
//                    alert(resp.order_Id);
                    $('#order_ID').val(resp.order_Id);
                    $('#auto_submit_form').submit();
                }else{
                }
            }
        });
        $('.btn.btn-next.btn-fill.btn-warning.btn-wd.btn-sm').trigger("click");
//    $('.btn.btn-next.btn-fill.btn-warning.btn-wd.btn-sm').trigger("click");
//    $('#payment-iframe').html('<iframe style="border:none !important;"  id="frame" width="100%" height="600" src="/Checkout.php">'+
//                                    '</iframe>');
}