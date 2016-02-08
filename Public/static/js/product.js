function addToCart(){
    for (var i = 1; i <=4; i++) {
        var attr= "attributeID"+i;
        if (typeof $("#"+attr+" option:selected" ).val() != "undefined") {
            if($('#'+attr+" option:selected" ).val()==""){
                $('#cart_error').show();
                $('#cart_error').text($('#'+attr+" option:selected" ).text());
                return false;
            }
        }
    }
    var pr_ID = $('#product_ID').val();
    var pr_price_ID = $('#product_price_ID').val();
    $.ajax({
        url: "/cart/addProductToCart",
        type: 'POST',
        data: {pdoductID : pr_ID, productPriceID : pr_price_ID},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
                   $('#cart_total').text(resp.cart_quantity);
                   $('#add_to_cart_button').prop("disabled",true);;
                   $('#after-success').show();
            }else{

            }
        }
    });
    
}

function emptyCart(){
    if (confirm("Are you sure want to empty items from Cart?") == true) {    
            $.ajax({
                url: "/cart/emptyProductFromCart",
                type: 'POST',
                dataType:"json",
                beforeSend: function(msg){
                    block_screen();
                },
                success: function (resp) {
                    unblock_screen();
                    
                    if(resp.error == 0){
                            location.reload(true);
                        } else {

                        }
                }
            });
        } else {

        }
}

function productIncrement(prodId , priceMapID, prodCount)
{
    var no = $("#prodNumber_" + prodCount).val();
//    var total_amt = $("#prodTotal" ).text();
//    var total_amt_all = $("#totalAmtAllOver" ).text();
     if (no >= 0)
    {
        var latestNo =  parseInt(no) +1 ;
        $("#prodNumber_" + prodCount).val(latestNo);
        $.ajax({
            url: "/cart/increaseDecreaseCartProductQuantity",
            type: 'POST',
            data: {productID : prodId, priceMapID : priceMapID, incrementDecrementType : " + ", qty : no},
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
                if(resp.error == 0){
                    location.reload(true);
                } else {
                   // location.reload(true);
                }
            }
        });
//   
        
    }
}

function removeProductFromCart(prodId , priceMapID){
    if (confirm("Are you sure want to remove this item from Cart?") == true) {
        $.ajax({
            url: "/cart/deleteProductFromCart",
            type: 'POST',
            data: {productID : prodId, priceMapID : priceMapID},
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
                if(resp.error == 0){
                    location.reload(true);
                } else {
                   // location.reload(true);
                }
            }
        });
    } else {
        return false;
    }
}

function checkOutPop(){
    $('#myModal').modal('show');
}

function clearLoginError(){
    $("input").keypress(function (e) {
        $('.login-error').text("");
    }); 
}

function buyNow(){
    for (var i = 1; i <=4; i++) {
        var attr= "attributeID"+i;
        if (typeof $("#"+attr+" option:selected" ).val() != "undefined") {
            if($('#'+attr+" option:selected" ).val()==""){
                $('#cart_error').show();
                $('#cart_error').text($('#'+attr+" option:selected" ).text());
                return false;
            }
        }
    }
    
    var pr_ID = $('#product_ID').val();
    var pr_price_ID = $('#product_price_ID').val();
    
    $.ajax({
        url: "/cart/addProductToCart",
        type: 'POST',
        data: {pdoductID : pr_ID, productPriceID : pr_price_ID},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
                   //$('#cart_total').text(resp.cart_quantity);
//                   $('#add_to_cart_button').remove();
//                   $('#after-success').show();
                   $("#add_to_cart_button").prop('disabled', true);
                   window.location.href = "/cart";
            }else{

            }
        }
    });
    
}

function getPrice(attr_no){
//    alert(attr_no);
    clearCartError();
    var pr_ID = $('#product_ID').val();
    var attrNo = attr_no;
    var attr = $("#attributeID"+attrNo+" option:selected" ).text();
    var attrVal = $("#attributeID"+attrNo+" option:selected" ).val();
    if(attrVal == ""){
        attr = "";
    }
    //---------------------
    $.ajax({
        url: "/product/getProductAttributes",
        type: 'POST',
        data: {pdoductID : pr_ID, attrNo : attrNo, attr :attr},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
//                 alert(resp.product.length);
                 var optionSelect1 = "";
                 var optionSelect2 = "";
                 var optionSelect3 = "";
                 var optionSelect4 = "";
                 var optionArr = new Array();
                 for (var i = 0; i < resp.product.length; i++) {
                    optionArr[1]+= ' <option value="'+resp.product[i].attributeID1+'">'+resp.product[i].Description1+'</option>'; 
                    optionArr[2]+= ' <option value="'+resp.product[i].attributeID2+'">'+resp.product[i].Description2+'</option>'; 
                    optionArr[3]+= ' <option value="'+resp.product[i].attributeID3+'">'+resp.product[i].Description3+'</option>'; 
                    optionArr[4]+= ' <option value="'+resp.product[i].attributeID4+'">'+resp.product[i].Description4+'</option>'; 
//                     alert(resp.product[i].Description2);
                 }
                 for (var i = attr_no+1; i <= 4; i++) {
                     if (typeof $("#attributeID"+i+" option:selected" ).val() != "undefined") {
                         $("#attributeID"+i).children('option:not(:first)').remove();
                         $("#attributeID"+i).append(optionArr[i]);
                     }
                }
                $('#list_price').text(resp.product.listPrice);
                $('#our_price').text(resp.product.ourPrice);
                $('#product_price_ID').val(resp.product.priceMapID);
                $('#stock_in_hand').text(resp.product.stockOnHand);
            }else{

            }
        }
    });
    //---------------------
    
    
    
    var attributeID1 = null;
    var attributeID2 = null;
    var attributeID3 = null;
    var attributeID4 = null;
    var arrt1 , arrt2 , arrt3 , arrt4 = null;
    if (typeof $("#attributeID1 option:selected" ).val() != "undefined") {
        attributeID1 = $("#attributeID1 option:selected" ).text();
        arrt1 = $("#attributeID1 option:selected" ).val();
    }
    if (typeof $("#attributeID2 option:selected" ).val() != "undefined") {
        attributeID2 = $("#attributeID2 option:selected" ).text();
        arrt2 = $("#attributeID2 option:selected" ).val();
    }
    if (typeof $("#attributeID3 option:selected" ).val() != "undefined") {
        attributeID3 = $("#attributeID3 option:selected" ).text();
        arrt3 = $("#attributeID3 option:selected" ).val();
    }
    if (typeof $("#attributeID4 option:selected" ).val() != "undefined") {
        attributeID4 = $("#attributeID4 option:selected" ).text();
        arrt4 = $("#attributeID4 option:selected" ).val();
    }
    
    if(arrt1 == "" || arrt2=="" || arrt3 == "" || arrt3 == ""){
        return false;
    }
//    alert(attributeID1);
//    alert(attributeID2);
//    alert(attributeID3);
//    alert(attributeID4);
    var pr_ID = $('#product_ID').val();
    $.ajax({
        url: "/product/getProductPriceByAttr",
        type: 'POST',
        data: {pdoductID : pr_ID, attr1 : attributeID1, attr2 : attributeID2, attr3 : attributeID3, attr4 : attributeID4},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
                if(resp.product !=null){
                    $('#list_price').text(resp.product.listPrice);
                    $('#our_price').text(resp.product.ourPrice);
                    $('#product_price_ID').val(resp.product.priceMapID);
                    $('#deal_ID').val(resp.product.dealID);
                    $('#stock_in_hand').text(resp.product.stockOnHand);
                    if(resp.product.stockOnHand >0 ){
                        var html = '<button id="add_to_cart_button" type="button" class="btn btn-primary btn-sm btn-block" onclick="addTo();"  style="height: 40px !important"><span class="glyphicon glyphicon-shopping-cart mright10"></span>ADD TO CART</button>'+
                            '<button type="button" class="btn btn-primary btn-sm btn-block" onclick="buyNow();"  style="height: 40px !important">BUY NOW</button>';
//                        $('#stock_sec').html(html);
                        $('#stock_sec').show();
                        $('#stock_sec_avail').html('');
                    }else{
                        $('#stock_sec').hide();
                        $('#stock_sec_avail').html('<p style="font-size:26px;text-align:center;color:red">Out of stock.</p>');
                    }
                }
            }else{

            }
        }
    });
    
}

function clearCartError(){
    $('#cart_error').hide();
    $('#cart_error').text("");
}

function addDealToCart(){
    for (var i = 1; i <=4; i++) {
        var attr= "attributeID"+i;
        if (typeof $("#"+attr+" option:selected" ).val() != "undefined") {
            if($('#'+attr+" option:selected" ).val()==""){
                $('#cart_error').show();
                $('#cart_error').text($('#'+attr+" option:selected" ).text());
                return false;
            }
        }
    }
    var pr_ID = $('#product_ID').val();
    var pr_price_ID = $('#product_price_ID').val();
    var deal_ID = $('#deal_ID').val();
    if(deal_ID == "" || deal_ID == null){
        alert("Deal is not applicable on this attribute.");
        return false;
    }
    $.ajax({
        url: "/cart/addProductToCart",
        type: 'POST',
        data: {pdoductID : pr_ID, productPriceID : pr_price_ID, deal_ID : deal_ID},
        dataType: "json",
        async: false,
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
                   $('#cart_total').text(resp.cart_quantity);
                   $('#add_deal_to_cart_button').prop("disabled",true);;
                   $('#after-success').show();
            }else{

            }
        }
    });
    
}

function buyDealNow(){
    addDealToCart();
    window.location.href = "/cart";
}