var playerCount = 1;
var indianPrice = 0;
var expatPrice =0;
var currIcon = '';

var playTimes = ["07:00", "08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];
var daysAvailable = [];
var tentaviDaysAvailable = [];
var dateTimeArr = Array();
var tentativeDateTimeArr = Array();
var payNPlayBookingCount = 1;
var payNPlayBookingSlotID = 0;
function updatCalendar(){
    var gid = $('#gid').val();
    var bookType= $('#booking_type').val();
    if(gid !="" && (bookType == 2)){
        $.ajax({
            url: "/golfcourse/getGolfCourseSlots",
            type: 'POST',
            data: {gid :gid},
            dataType: "json",
            success: function (resp) {
                if(resp.error == 0){
                    var arrLength = resp.avail_days.length;
                    daysAvailable = [];
                    for(var k in resp.avail_days){
                        daysAvailable.push(k);
//                        alert(k);
                        dateTimeArr[k] =new Array();
                        for (var i = 0; i < resp.avail_days[k].length; i++) {
                            dateTimeArr[k].push(resp.avail_days[k][i]);
                        }
                    }
                    //---- Tentative ----------
                    var arrLength = resp.tentative_avail_days.length;
                    tentaviDaysAvailable = [];
                    for(var k in resp.tentative_avail_days){
                        tentaviDaysAvailable.push(k);
                        tentativeDateTimeArr[k] =new Array();
                        for (var i = 0; i < resp.tentative_avail_days[k].length; i++) {
                            tentativeDateTimeArr[k].push(resp.tentative_avail_days[k][i]);
                        }
                    }
                    //-------------------------
//                    for (var i = 0; i < arrLength; i++) {
//                        daysAvailable.push(resp.avail_days[i]);
//                    }
                    var timeLength = resp.avail_time.length;
                    var timeAvailable = [];
                    for (var i = 0; i < timeLength; i++) {
                        if(resp.avail_time[i] != null){
                            var timeA = resp.avail_time[i].toString().split(":")
                            timeAvailable.push(timeA[0]+":"+timeA[1]);
                        }
                    }
                    //-- Calendar re initiate ---
                    var someDate = new Date();
//                    var numberOfDaysToAdd = 4;
                    someDate.setDate(someDate.getDate() + PAY_MIN_DAYS); 
                    $('#play_date').datepicker('remove');
                    $('#play_date').datepicker({
                        startDate :someDate,
                        format:'dd/mm/yyyy',
                        beforeShowDay: enableAllTheseDays,
                        autoclose: true
                    });
                    $('#play_date').datepicker().on('changeDate', function (ev) {
                        var timeHtml = '<option value=""></option>';
                        var dateData = new Date(ev.date);
                        var m = dateData.getMonth();
                        var d = dateData.getDate();
                        var y = dateData.getFullYear();
                        // First convert the date in to the mm-dd-yyyy format 
                        // Take note that we will increment the month count by 1 
                        var currentdate = y + '-' +(m + 1) + '-' +  d ;
                        timeAvailable =[];
                        var tentativeTimeAvailable =[];
                        if ( typeof tentativeDateTimeArr[currentdate] != "undefined"){
                            for (var i = 0; i < tentativeDateTimeArr[currentdate].length; i++) {
                                var timeA = tentativeDateTimeArr[currentdate][i].split(":");
                                tentativeTimeAvailable.push(timeA[0]+":"+timeA[1]);
                            }
                        }
                        if ( typeof dateTimeArr[currentdate] != "undefined"){
                            if($('#booking_type').val() == 2){
                                for (var i = 0; i < dateTimeArr[currentdate].length; i++) {
                                    var timeA = dateTimeArr[currentdate][i].split(":");
                                    timeAvailable.push(timeA[0]+":"+timeA[1]);
                                    if ( $.inArray( timeA[0]+":"+timeA[1], tentativeTimeAvailable ) > -1 ){
                                        timeHtml+='<option value="'+timeA[0]+":"+timeA[1]+'">'+timeA[0]+":"+timeA[1]+'&nbsp;&nbsp;<span class="badge tentative_avail_time_badge" >Tentative Avail</span></option>';
                                    }else{
                                        timeHtml+='<option value="'+timeA[0]+":"+timeA[1]+'">'+timeA[0]+":"+timeA[1]+'&nbsp;&nbsp;<span class="badge avail_time_badge" ></span></option>';
                                    }
                                }
                            }else{
                                for (var i = 0; i < playTimes.length; i++) {
                                    timeHtml+="<option>"+playTimes[i]+"</option>";
                                }
                            }
                        }
                        $('#play_time').html(timeHtml);
                    });
                    $('#play_date').val('');
                    $('#play_time').val('');
                }else{
                    alert(resp.error_msg);
                }
            }
        });
    }else{
        updatCalendarForComplimentary();
    }
       
    
}

function enableAllTheseDays(date) {
    var m = date.getMonth();
    var d = date.getDate();
    var y = date.getFullYear();

    // First convert the date in to the mm-dd-yyyy format 
    // Take note that we will increment the month count by 1 
    var currentdate = y + '-' +(m + 1) + '-' +  d ;
    if ($.inArray(currentdate, daysAvailable) != -1 ) {
        return true;
    }else{
        return false;;
        
    }
    
}

function addDays(numDays) {

    var date = new Date();
    date.setDate(date.getDate() + COMP_MIN_DAYS);

    var dateMsg = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();

    return dateMsg;

}


function updatCalendarForComplimentary(){
   // var someDate = new Date();
	var NoDaysAdvance = COMP_MIN_DAYS;

    if (NoDaysAdvance == '')
    {
        NoDaysAdvance = 0;
    }
    var date_start = addDays(NoDaysAdvance);

	
    $('#play_date').datepicker('remove');
    $('#play_date').datepicker({
        startDate : date_start,
        format:'dd/mm/yyyy',
        autoclose: true
    });
    var timeHtml = "";
    for (var i = 0; i < playTimes.length; i++) {
        timeHtml+="<option>"+playTimes[i]+"</option>";
    }
    $('#play_time').html(timeHtml);
}

function submit_comp1_booking(){
    if($('#play_date').val() == ""){
        alert("Plese select Play date.");
        $('#play_date').focus();
        return false;
    }else if($('#play_time').val() == ""){
        alert("Plese select Play time.");
        $('#play_time').focus();
        return false;
    }
    $('#comp_play_date').val($('#play_date').val());
    $('#comp_play_time').val($('#play_time').val());
    var formData = $('#form-compl').serialize();
    var booking_type = $('#booking_type').val();
    if($('#form-compl').valid()){
        var url= "/golfcourse/bookComplSlot";
        if(booking_type == 3) {
            url= "/golfcourse/bookLearnComplSlot";
        }
//        alert(url);
        $.ajax({
            url: url,
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
                    $('#myModal').modal('hide');
                    window.confirm("Your request has been received We would be sending confirmation within 48 to 72 hours. \n Happy Golfing!!!");
                    window.location = "/index.php";
                    //$('.booking-check').text("Your slot has been booked and details are mailed to your registered Email id. \n Happy Golfing!!!");
                }else{
                    $('.booking-check').show();
                    $('.booking-check').text(resp.error_msg);
                }
            }
        });
    }
}

function updatRateCard(){
    var bookingType = $('#booking_type').val();
    var gid = $('#gid').val();
    var play_date =$('#play_date').val();
    var play_time = $('#play_time').val();
    if($('#play_date').val()=="" || $('#play_time').val()==""){
        return false;
    }
   if(bookingType == 2){
        var formData = $('#form-pay').serialize();
        $.ajax({
            url: "/golfcourse/updatRateCard",
            type: 'POST',
            data: {pay_gid : gid, pay_play_date :play_date, pay_play_time : play_time},
            dataType: "json",
            async: false,
            success: function (resp) {
                if(resp.error == 0){
                     if(resp.list_price_indian == resp.price_indian){
                        $('#gc-price').hide();
                        $('#golflan-price').show();
                        $('#golflan-price').html(resp.currencyIcon+' '+resp.price_indian);
                    }else{
                        $('#gc-price').show();
                        $('#golflan-price').show();
                        $('#gc-price').html(resp.currencyIcon+' '+resp.list_price_indian);
                        $('#golflan-price').html(resp.currencyIcon+' '+resp.price_indian);
                    }
                    indianPrice = resp.price_indian;
                    expatPrice = resp.price_expat;
                    currIcon = resp.currencyIcon;
                    calculateTotal();
                 }else{
                   alert(resp.error_msg);
                   calculateTotal();
                }
            }
        });
    }
}

function addPlayer(){
    playerCount++;
//    alert(playerCount);
    var newElem = $('#player_1').clone().attr('id', 'player_' + playerCount);
    newElem.find("input:text").val("");
    if(playerCount < 5){
        newElem.find('.player_number').text('PLAYER ' + playerCount);
        newElem.find('#checkboxG1').attr('id','checkboxG' + playerCount);
        newElem.find('#labelcheckboxG1').attr('id','labelcheckboxG' + playerCount).attr('for', 'checkboxG' +playerCount);
        $('#more_players').append(newElem);
        $('#player_' + playerCount).append('\
            <div class="col-sm-3" style="padding-top:1%">\n\
                <div class="form-group chkbx-align"><br />\n\
                    <img id="'+playerCount+'" src="https://glmedia.golflan.com/remove.png" class="css-label img_remove" onclick="removePlayer(this)"/>\n\
                </div>\n\
            </div>');
    }else{
        alert("You can't add more than 4(Four) Players.");
    }
    if(playerCount==4){
        $('#add_palyer_button').hide();
    }
    calculateTotal();
}

function removePlayer(obj){
    var id = obj.id;
    $('#player_' + id).slideUp('slow', function () {
        $(this).remove();
        reInitializeIds();
        playerCount--;
        calculateTotal();
        if(playerCount<4){
            $('#add_palyer_button').show();
        }
    });
}

function reInitializeIds(){
    playerCount = 1;
    $('.img_remove').each(function(i, obj) {
        obj.id = playerCount+1;
        playerCount++;
    });
    playerCount = 1; 
    $('.player').each(function(i, obj) {
        obj.id ='player_' + playerCount;
        $('#player_' + playerCount+' .player_number').html('PLAYER ' + playerCount);
        playerCount++;
    });
}

function calculateTotal(){
    var totalAmt = 0 ;
    var count = 1;
    $('.player').each(function(i, obj) {
        totalAmt+= indianPrice;
        count++;
    });
    $("#total_amt_show").html(currIcon+' '+totalAmt);
    $('#total_amt').val(totalAmt);
}


function submit_paynPlay_booking(){
//    $('#pay_play_date').val($('#play_date').val());
//    $('#pay_play_time').val($('#play_time').val());
    $('#pay_booking_count').val(payNPlayBookingCount);
    $('#pay_slotID').val(payNPlayBookingSlotID);
    if(!$("#form-pay").validationEngine('validate')){
        return false;
    }else{
    }
    if($('#gid').val() == ""){
        alert("Plese select Golf course");
        $('#gid').focus();
        return false;
    }else if($('#play-date').val() == ""){
        alert("Plese select Play date and time");
        $('#play-date').focus();
        return false;
    }
    var date = new Date($('#play-date').val());
    var dayNum = date.getDay();
//    if((date.getDay()==0 || date.getDay()==6) && $('.player').length <3){
//        var remaining = 3 - $('.player').length ;
//        alert("On Weekends( i.e Saturday & Sunday ) Minimun  players has to be 3.\n Please select "+remaining+" more Player(s).");
//        $('add_palyer_button').focus();
//        return false;
//    }
//    if(!document.getElementById('agree').checked) {
//        alert("Please Accept Terms and Conditions.");
//        return false;
//    }
    $('#total_amt').val($('#total_amt_show').text());
    var formData = $('#form-pay').serialize();
    var url= "/golfcourse/bookPayNPlaySlot";
    var payNLearn = false;
    var bookingType = $('#booking_type').val();
    if(bookingType == 4){
        if($('#play_date').val() == ""){
            alert("Plese select Play date.");
            $('#play_date').focus();
            return false;
        }else if($('#play_time').val() == ""){
            alert("Plese select Play time.");
            $('#play_time').focus();
            return false;
        }
        url= "/golfcourse/bookPayNLearnSlot";
        payNLearn = true;
        var coachID = $('#avail_coaches').val();
        if(coachID==""){
            $('.booking-check').show();
            $('.booking-check').text("Please select coach.");
            return false;
        }
    }
//    alert(url);
    $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: "json",
            beforeSend: function(msg){
                var email = $('#form-validation-field-2').val();
                var gc = $('#sideview').html();
                _bOut.push(["addEvent",email,"Attemped to book pay n play at " + gc]);
                setTimeout(function(){ 
                }, 1500);
                block_screen();
            },
            success: function (resp) {
                unblock_screen();
                if(resp.error == 0){
                    //window.confirm("Your slot has been booked and details are mailed to your registered Email id. \n Happy Golfing!!!");
                    if(payNLearn){
//                        window.location = "/payment_learn.php?book_id="+resp.book_ID;
                        payNLearnfun(resp.book_ID);
                    }else{
                        payNPlay(resp.book_ID);
//                        window.location = "/payment.php?book_id="+resp.book_ID;
                    }
                    //$('.booking-check').text("Your slot has been booked and details are mailed to your registered Email id. \n Happy Golfing!!!");
                }else{
                    alert(resp.error_msg);
                }
            }
            
        });
}

function payNcheckout(){
    if($("#payment_form").validationEngine('validate')){
        $('#payment_form').submit();
    }
    
}

function applyVoucher(){
    $('#voucher-code').val($('#popup-voucher-code').val());
    if($('#voucher-code').val()!=""){
        var voucherCode= $('#voucher-code').val();
        var formData = $('#payment_form').serialize();
        $.ajax({
            url: "/golfcourse/applyVoucher",
            type: 'POST',
            data: formData,
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
//                alert(resp.error_msg);
                unblock_screen();
//                alert(resp.error);
//                $('#total_amt').text(resp.revised_amount);
                if(resp.error == 0){
//                    $('#voucher-message').text(resp.error_msg+ ' ' + resp.voucher_description);
                    $('#pay_popup_voucher').html(resp.voucher_description);
                    $('#pay_popup_final_amount').text(resp.revised_amount); //new
                    $('#voucher-section').remove();
                    $('#voucher-message').text(resp.error_msg); //new
                }else{
                    $('#voucher-message').text(resp.error_msg+ ' ' + resp.voucher_description);
                    $('#total_amt_show_checkout').text(resp.revised_amount);
                   
                }
            }
        });
    }
}

function payNPlay(bookId){
    var bookingID = bookId;
    var gid = $('#gid').val();
    $.ajax({
        url: "/golfcourse/getUserDetailsByBookingID",
        type: 'POST',
        data: {bookingID : bookingID},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
                $('#voucher_gid').val(gid);
                $('#billing_cust_name').val(resp.user.Login_Name);
                $('#billing_cust_tel').val(resp.user.Mobile);
                $('#billing_cust_email').val(resp.user.Email);
                $('#Order_Id').val(bookingID);
                var currencyIcon = "";
                if(resp.user.currencyIcon !="" && resp.user.currencyIcon != null){
                    currencyIcon = '<i class="fa ' + resp.user.currencyIcon + '" ></i>';
                }else{
                    currencyIcon = resp.user.currencyISO;
                }
                $('#total_amt_show_checkout').text(currencyIcon +" "+resp.user.totAmount);
                 //---------- New Summary Popup ------------------
                $('#pay_popup_gc_name').html(resp.gcDetails.GCName);
                $('#pay_popup_play_date').html(resp.user.dateOfPlay);
                $('#pay_popup_play_time').html(resp.user.slotOfPlay);
                $('#pay_popup_game_type').html(resp.gcDetails.HoleType+" Holes");
                $('#pay_popup_golfers').html(resp.golfers_count);
                $('#pay_popup_golfers_detail').html("( "+resp.golfers_count +" * "+ resp.per_player + ")");
                $('#pay_popup_green_fee_total').html(resp.user.totAmount);
                $('#pay_popup_convenience_fee').html('Nil');
                $('#pay_popup_final_amount').html(currencyIcon +" "+resp.user.totAmount);
                $('#pay_popup_total_payable').html(resp.user.totAmount);
                $('#pay_popup_voucher').html("Nil");
            }else{
                alert(resp.error_msg);
            }
        }

    });
    $('#myModal').modal('hide');
    $('#checkoutModal').modal('show');
    $('#payment_form').attr('action', '/paynplay/checkout');
    $('#book_type').val("");
}


function getCoachesByGID(gid){
    if( gid != "" && gid != null){
        $.ajax({
            url: "/golfcourse/getCoaches",
            type: 'POST',
            data: {gid : gid},
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
//                alert(resp.error_msg);
                unblock_screen();
//                alert(resp.error);
//                $('#total_amt').text(resp.revised_amount);
                if(resp.error == 0){
                    var html="<option value=''>--Select--</option>";
                    for (var i = 0; i < resp.coaches.length; i++) {
                        if(resp.coaches[i] != null){
                           html+="<option value='"+resp.coaches[i].coachID+"'>"+resp.coaches[i].coachCategory+"</option>";
                           $('#avail_coaches').html(html);
                           if(i==0){
                               $('#gc-price').show();
                                $('#golflan-price').show();
                               $('#total_amt_show').text("");
                               $('#gc-price').text("");
                               $('#golflan-price').text("");
                           }
                        }
                    }
                }else{
                   
                }
            }
        });
    }
}

function getcoachPriceById(){
    var coachID = $('#avail_coaches').val();
    if( coachID != "" && coachID != null){
        $.ajax({
            url: "/golfcourse/getCoachPriceByID",
            type: 'POST',
            data: {coachID : coachID},
            dataType: "json",
            beforeSend: function(msg){
                block_screen();
            },
            success: function (resp) {
//                alert(resp.error_msg);
                unblock_screen();
//                alert(resp.error);
//                $('#total_amt').text(resp.revised_amount);
                if(resp.error == 0){
                    $('#gc-price').show();
                    $('#golflan-price').show();
                    $('#total_amt_show').text(resp.coach.coachFee);
                    $('#gc-price').text(resp.coach.coachFee);
                    $('#golflan-price').text(resp.coach.coachFee);
                }else{
                   
                }
            }
        });
    }
}

function payNLearnfun(bookId){
    var bookingID = bookId;
    var gid = $('#gid').val();
    $.ajax({
        url: "/golfcourse/getLearnUserDetailsByBookingID",
        type: 'POST',
        data: {bookingID : bookingID},
        dataType: "json",
        beforeSend: function(msg){
            block_screen();
        },
        success: function (resp) {
            unblock_screen();
            if(resp.error == 0){
                $('#voucher_gid').val(gid);
                $('#billing_cust_name').val(resp.user.Login_Name);
                $('#billing_cust_tel').val(resp.user.Mobile);
                $('#billing_cust_email').val(resp.user.Email);
                $('#Order_Id').val(bookingID);
                var currencyIcon = "";
                if(resp.user.currencyIcon !="" && resp.user.currencyIcon != null){
                    currencyIcon = '<i class="fa ' + resp.user.currencyIcon + '" ></i>';
                }else{
                    currencyIcon = resp.user.currencyISO;
                }
                $('#total_amt_show_checkout').text(currencyIcon +" "+resp.user.totAmount);
            }else{
                alert(resp.error_msg);
            }
        }

    });
    $('#myModal').modal('hide');
    $('#checkoutModal').modal('show');
    $('#payment_form').attr('action', '/paynlearn/checkout');
    $('#book_type').val("learn");
}
