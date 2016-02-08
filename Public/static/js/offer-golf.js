function showProducts(catID, subcatID){
	
	var country_iso = $("#country_iso").val();
	
	if(country_iso == ''){
		
		var country_iso = "IND";
		
	}
	
    $.ajax({
        url: "/product/getProducts",
        type: 'POST',
        data: {cat_ID : catID, sub_cat_ID :subcatID, country_iso : country_iso},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            //$('#shop-section').hide();
            var html ='<div class="" align="center"></div>';
            if(resp.error == 0){
//                alert(resp.products.length);
                for (var i = 0; i < resp.products.length; i++) {
//                    alert(resp.products[i].Title);
                html+='<form method="post" class="col-sm-4 min-height-product" action="" onsubmit="return false;" style="margin-bottom:20px;">'+
                            '<div class="item" >'+
                                '<a href="javascript:void(0)" onclick="window.location.href=\''+resp.products[i].shopUrl+'\'"><img class="prodImage" src="https://glmedia.golflan.com/'+resp.products[i].imgURL+'" width="275px" height="235px !important">'+
                                    '<div class="item-content" style="height:95px;width:235.6px;" align="center">'+
                                    '<h6 class="proshop_font" style="margin-top: 5px;">'+resp.products[i].Title+'</h6>'+
                                    '<div class="product-price  col-sm-12"> Starting from &nbsp; &nbsp; '+resp.currencyIcon +" &nbsp; "+resp.products[i].OurPrice+'</div>'+
                                    '</div>'+
                                '</a>'+
                            '</div>'+
                        '</form>';
                }
                $('#product-grid').html(html);
            }else{
                html+='<div class="product-item" style="min-height:400px;color:red;">coming soon..</div>';
                $('#product-grid').html(html);
            }
            unblock_screen();
        }
    });
}

function applyVoucherOnProshopOrder(){
    var voucherCode = $('#voucher_code').val();
    if(voucherCode!=""){
        var formData = $('#payment_form').serialize();
        $.ajax({
            url: "/product/applyVoucherOnProshopOrder",
            type: 'POST',
            data: {voucherCode : voucherCode},
            dataType: "json",
            beforeSend: function(msg){
//                block_screen();
            },
            success: function (resp) {
//                alert(resp.error_msg);
//                unblock_screen();
//                alert(resp.error);
//                $('#total_amt').text(resp.revised_amount);
                if(resp.error == 0){
                    $('#discount_amount').html(resp.discount_amount);
                    $('#order_total').html(resp.revised_amount);
                    $('#voucher-message').text(resp.error_msg+ ' ' + resp.voucher_description);
                    $('#total_amt_show').text(resp.revised_amount);
                    $('#voucher-section').remove();
                }else{
                    $('#voucher-message').text(resp.error_msg+ ' ' + resp.voucher_description);
                    $('#total_amt_show').text(resp.revised_amount);
                   
                }
            }
        });
    }
}

function clearVoucherError(){
    $('#voucher-message').html("");
}

function showProductsByBrand(brandID){
	
	var country_iso = $("#country_iso").val();
	
	if(country_iso == ''){
		
		var country_iso = "IND";
		
	}
	
    $.ajax({
        url: "/product/getProductsByBrand",
        type: 'POST',
        data: {brandID : brandID, country_iso : country_iso},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            //$('#shop-section').hide();
            var html ='<div class="" align="center"></div>';
            if(resp.error == 0){
//                alert(resp.products.length);
                for (var i = 0; i < resp.products.length; i++) {
//                    alert(resp.products[i].Title);
                html+='<form method="post" class="col-sm-4 min-height-product" action="" onsubmit="return false;">'+
                            '<div class="item" >'+
                                '<a href="javascript:void(0)" onclick="window.location.href=\''+resp.products[i].shopUrl+'\'"><img class="prodImage" src="https://glmedia.golflan.com/'+resp.products[i].imgURL+'" width="275px" height="235px !important">'+
                                    '<div class="item-content" style="height:157px;">'+
                                    '<h6 class="proshop_font">'+resp.products[i].Title+'</h6>'+
                                    '<div class="product-price  col-sm-12"> Starting from &nbsp; &nbsp; '+resp.currencyIcon +" &nbsp; "+resp.products[i].OurPrice+'</div>'+
                                    '</div>'+
                                '</a>'+
                            '</div>'+
                        '</form>';
                }
                $('#product-grid').html(html);
            }else{
                html+='<div class="product-item" style="min-height:400px;color:red;">coming soon..</div>';
                $('#product-grid').html(html);
            }
            unblock_screen();
        }
    });
}
