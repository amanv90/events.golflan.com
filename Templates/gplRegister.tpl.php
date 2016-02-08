<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>GPL Season 2</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="<?php echo STATIC_URL; ?>/static/css/favicon.ico" rel="icon" type="image/png">
		<link href="http://fonts.googleapis.com/css?family=Domine:400,700%7CRoboto:400,300,500,700,900" rel="stylesheet" type="text/css">
		<link href="<?php echo STATIC_URL; ?>/static/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo STATIC_URL; ?>/static/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo STATIC_URL; ?>/static/css/style.css" rel="stylesheet" media="screen">
		 <link href="<?php echo STATIC_URL; ?>/static/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" id="css-main" href="<?php echo STATIC_URL; ?>/static/css/oneui.css">
		<script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-44429742-1', 'auto');
        ga('send', 'pageview');

    </script>
	</head>
	<body>
		
		<style>
		
			.modal-content {
      
				background-color:#ecf0f1;
			top: 300px;	
     
    }
		</style>
		<style>
		body {
    font-family: "Arial";
    font-size: 14px;
    color: #646464;
    background-color: #f5f5f5;
}
		</style>
		
		 <div class="modal fade" id="cancelSlotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <form class="form-horizontal" id="cancelSlotForm" autocomplete="off"  novalidate="novalidate" onsubmit="return false;">   
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!---<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                                <h4 class="modal-title" id="myModalLabel">Thank you for your submission. Our team will get in touch with you shortly.</h4>
                            </div>
                           
                            <div class="modal-footer1" style="text-align:center;">
                                <button type="button" id="backtohome">Back to home page</button>
                           </div>
                        </div>
                    </div>
                </form>
           </div>
<div class="" style="background-color:#FFFFFF;">
		  					<div class="row">
		  						<div class="col-xs-12">
		  							<a href="/" id="logo"><img style="padding-left: 15px;" src="/static/img/logo.jpg" alt=""></a>
		  							<input type="checkbox" id="toggle-main-nav" class="toggle-nav-input">
		  							
		  						
		  						</div><!-- .col-xs-12 -->
		  					</div><!-- .row -->
		  	</div>
			<div class="" style="background-color:#D3D3D3; height:1px;">
		  				<br>
		  	</div>
			
		
		<div id="site">
		  	<header id="header" role="banner" style="min-height:0px !important;">
		  		<div class="">
		  			
		  			<!-- #main-nav -->
		  			
		  		</div><!-- .header-row -->
		  		<div id="page-heading">
		  			<div class="container">
		  				<div class="row">
		  					<div class="col-sm-12">
		  						<h1 class="page-title"></h1>
		  					</div><!-- .col-sm-12 -->
		  				</div><!-- .row -->
		  			</div><!-- .container -->
		  		</div><!-- #page-heading -->
		  	</header><!-- #header -->
		  	<article id="content">
			  	<section class="">
	
        <!-- Register Content -->
		     <div class="content overflow-hidden">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                    <!-- Register Block -->
                    <div class="block block-themed animated fadeIn">
                        <div class="block-header bg-success">
                            
                            <h3 class="block-title">Confirm Your Registration</h3>
                        </div>
						<b></b><br>
							<label for="register-username">Golf Course:&nbsp;&nbsp;&nbsp; </label><?php echo $_POST['GCName'];?><br>
							<label for="register-username">Date of Play:&nbsp;&nbsp;&nbsp;</label><?php echo $_POST['date'];?><br>
							
							<hr>

		 <form class="js-validation-register form-horizontal" action="/demo" method="post">
			 
							<form id="golferChoices" action="" name="golferChoices">
						
						<div class="field">
							<span class="checkbox-radio-block">
								<input type="radio" checked="checked" value="new" id="customer_single" name="customer_choice[]" data-condition="customer_choice">
								<label for="customer_single">I am a single golfer</label>
							</span>
						</div>
						
						<div class="field">
							<span class="checkbox-radio-block">
								<input type="radio" value="current" id="customer_multiple" name="customer_choice[]" data-condition="customer_choice">
								<label for="customer_multiple">I want to register a team</label>
							</span>
						</div>
						
		</form>
				 <form class="js-validation-register form-horizontal" method="post" id="single_form" style="margin-top:10px;">
				<div id="SinglePlayer">
					<p>Please enter the details as follows. All fields are mandatory.<br></p>
				<input style="width:49%;float:left;margin-bottom:10px;" id="name_new" name="Name"  type="text" placeholder="First Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="mobile_new"  name="Mobile" required pattern="[789][0-9]{9}" type="text" placeholder="Mobile No." class="form-control">
				
				<input style="width:49%;float:left;margin-bottom:10px;" id="email_first" name="Email" required pattern="[^ @]*@[^ @]*""text" placeholder="Email Address" class="form-control" value="">				
<input id="date1" type="hidden" name="date1" class="form-control" value="<?php echo $_POST['date'];?>"/>
					<input id="GCName1" type="hidden" name="GCName1" class="form-control" value="<?php echo $_POST['GCName'];?>"/>
		
          <div1>  <input style="width:49%;float:right;" id="card_number_first" type="text" name="Card" placeholder="EGC Card No." class="form-control" />
         <br><br><input type="checkbox" class="Blocked" id="single_form_check" style="margin-top:10px; margin-left:10px;"/> Not a EGC Member</div1> 
       
					
					<!--<div class="" id="noticeweeks"><input style="width:49%;float:right;" id="email" name="Card" type="text" placeholder="EGC Card No." class="form-control" value=""></div>
			-->		<div class="">
					<div id="error_div"></div>		
							<button style="width:49%; float:right; margin-top:10px;" class="btn btn-block btn-success" id="submit_button"  type="button"><i class=""></i> Register</button>
					</div>	
			</div>
		</form>	
			
		<form class="js-validation-register form-horizontal push-50-t push-50" method="post" id="multi_form">

			<div id="MultiplePlayers" style="display:none;">
				<p>Please enter the details as follows, there can be 3 players in a team.</p>
				<div id="golferOne">
					<p style="font-size:15px;font-weight:700;">Your Details</p>
                    
                 <input style="width:49%;float:left;margin-bottom:10px;" id="name_new1" name="Name1" required type="text" placeholder="Full Name" class="form-control" value="">                
                 <input style="width:49%;float:right;margin-bottom:10px;"  id="mobile_new1" required pattern="[789][0-9]{9}" type="text" placeholder="Mobile No." class="form-control" value="">
                <input id="date2" type="hidden" name="date2" class="form-control" value="<?php echo $_POST['date'];?>"/>
                    <input id="GCName2" type="hidden" name="GCName2" class="form-control" value="<?php echo $_POST['GCName'];?>"/>
                <input style="width:49%;float:left;" id="email_first1" name="Email1" required pattern="[^ @]*@[^ @]*""text" type="text" placeholder="Email Address" class="form-control" value="">                
                   <div1>  <input style="width:49%;float:right;" id="card_number_first1" type="text" name="Card1" placeholder="EGC Card No." class="form-control" />
<br><br><input type="checkbox" class="Blocked" id="single_form_check1" style="margin-top:10px; margin-left:200px;"/> Not a EGC Member</div1>					
					<!--<input style="width:49%;float:right;" id="email" name="Card1" type="text" placeholder="EGC Card No." class="form-control" value="">
					-->
				</div>
				<div style="clear:both;"></div>
				<div id="golferTwo">
					<p style="font-size:15px;margin-top:20px;font-weight:700;">Second Golfer</p>
					<input style="width:49%;float:left;margin-bottom:10px;" id="name_new3" name="Name2"  type="text" placeholder="Full Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="mobile_new3" name="Mobile2" type="text" placeholder="Mobile No." class="form-control" value="">
				
				<input id="email_new3" name="Email2" type="text" placeholder="Email Address" class="form-control" value="">		
				
				</div>
				<div style="clear:both;"></div>
				<div id="golferThree">
					<p style="margin-top:10px;font-size:15px;margin-top:20px;font-weight:700;">Third Golfer</p>
					<input style="width:49%;float:left;margin-bottom:10px;" id="name_new4" name="Name3" type="text" placeholder="Full Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="mobile_new4" name="Mobile3" type="text" placeholder="Mobile No." class="form-control" value="">
				
				<input id="email_new4" name="Email3" type="text" placeholder="Email Address" class="form-control" value="">		
				</div><br>
				 <div id="error_div1"></div>	
							<button style="width:49%; float:right" class="btn btn-block btn-success" type="button" id="submit_button1"> Register</button>
				</div>	
			</div>
								 
        </div>
       
      </div>
      
    </div>
  </div>
  
</div>
                    <!-- END Register Block -->
                </div>
            </div>
        </div>
			  		
			  	</section><!-- .container -->
		  	</article><!-- #content -->  	
		  	
		</div><!-- #site -->
	  	
	    <!-- All Pages JS -->
	    <script src="<?php echo STATIC_URL; ?>/static/js/jquery-1.11.1.min.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/bootstrap.min.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/dropdown-menu.min.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/waypoints.min.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/waypoints-sticky.min.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/jquery.velocity.min.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/velocity.ui.js"></script>
	    <script src="<?php echo STATIC_URL; ?>/static/js/doubletaptogo.js"></script>
	    
	    <!-- Main JS -->
	    <script src="<?php echo STATIC_URL; ?>/static/js/main.js"></script>
			<script src="<?php echo STATIC_URL; ?>/static/js/jquery.validate1.min.js"></script>
  <script src="<?php echo STATIC_URL; ?>/static/js/base_pages_register.js"></script>
        <!-- Page JS Code -->
        
	<script type="text/javascript">

$(document).ready(function() {
 
$('.hide').click(function() {
$(this).next().toggle();
});
$('.hide:checked').next().hide();
 
	$( "#submit_button" ).click(function() {
		
	 var name_new = $("#name_new").val();
		
	  var mobile_new = $("#mobile_new").val();
		var card_number_first= $("#card_number_first").val();
			var email = $("#email_first").val();	
var date = $("#date1").val();
		var GCName = $("#GCName1").val();
		
		if(name_new == ''){
		
			alert("Please enter the name.");
			$("#name_new").focus();
			return false;
			
		}
		
		if(mobile_new == "")
		{
		
			alert("Please enter the mobile number.");
			$("#mobile_new").focus();
			return false;
			
		}
		
		if(!$.isNumeric(mobile_new)) {
		 
		 	alert("Mobile number should be numeric.");
			$("#mobile_new").focus();
			return false;

	    }
		
		if(mobile_new.length > 12){
		
			alert("Mobile number should not be greater than 12 digits.");
			$("#mobile_new").focus();
			return false;
			
		}
		
		if(email == "")
		{
		
			alert("Please enter the email id.");
			$("#email_first").focus();
			return false;
		}
		
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
		
     if(!emailReg.test(email)) {  
        alert("Please enter valid email id.");
	    $("#email_first").focus();
			return false;
     }  
		
	if($("#single_form_check").prop('checked') == false){
			
		if(card_number_first == "")
		{
		
			alert("Please enter the card number.");
			$("#card_number_first").focus();
			return false;
		}
			
	}
		
		
		$.ajax({
                                        url: "/demo",
                                        type: 'POST',
                                  
			                            data: "Name=" + name_new+ "&Mobile=" + mobile_new + "&Card=" + card_number_first + "&Email=" + email + "&date=" + date + "&GCName=" + GCName,
                                        dataType: "json",
                                        async: false,
                                        beforeSend: function (msg) {
//                                             block_screen();
                                        },
                                        success: function (resp) {
                                     
											if(resp == 1){
												
												$("#error_div").html("");
												
												$("#cancelSlotModal").modal('show');
												

//var url = '/demotpl';
//window.location.href = url;


											
												//$( "#single_form" ).submit();
												
												
											}else{
											
												$("#error_div").html("Card does not exist");
												
											}
											
                                        }
                                    });
		
		
		
	});
	
	
	
	
	
});
</script>
	<script type="text/javascript">


		
$(document).ready(function() {
	
	
	$('#backtohome').click(function() {
		
		var url = '/';
		window.location.href = url;

		
	});
	

 
$('.hide').click(function() {
$(this).next().toggle();
});
$('.hide:checked').next().hide();
 
	$( "#submit_button1" ).click(function() {
		
	 var name_new = $("#name_new1").val();
		
	  var mobile_new = $("#mobile_new1").val();
		var card_number_first= $("#card_number_first1").val();
			var email = $("#email_first1").val();	
var date2 = $("#date2").val();
		var GCName2 = $("#GCName2").val();
		
		var name_new3 = $("#name_new3").val();
	  var mobile_new3 = $("#mobile_new3").val();
		var email_new3 = $("#email_new3").val();	
		
		var name_new4 = $("#name_new4").val();
	 	 var mobile_new4 = $("#mobile_new4").val();
		var email_new4 = $("#email_new4").val();
		
		if(name_new == ''){
		
			alert("Please enter the name.");
			$("#name_new1").focus();
			return false;
			
		}
		
		if(mobile_new == "")
		{
		
			alert("Please enter the mobile number.");
			$("#mobile_new1").focus();
			return false;
			
		}
		
		if(!$.isNumeric(mobile_new)) {
		 
		 	alert("Mobile number should be numeric.");
			$("#mobile_new1").focus();
			return false;

	    }
		
		if(mobile_new.length > 12){
		
			alert("Mobile number should not be greater than 12 digits.");
			$("#mobile_new1").focus();
			return false;
			
		}
		
		if(email == "")
		{
		
			alert("Please enter the email id.");
			$("#email_first1").focus();
			return false;
		}
		
	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;  
		
     if(!emailReg.test(email)) {  
        alert("Please enter valid email id.");
	    $("#email_first1").focus();
			return false;
     }  
		
	if($("#single_form_check1").prop('checked') == false){
			
		if(card_number_first == "")
		{
		
			alert("Please enter the card number.");
			$("#card_number_first1").focus();
			return false;
		}
			
	}
		
		
		$.ajax({
                                        url: "/demo",
                                        type: 'POST',
                                  
			                            data: "Name1=" + name_new+ "&Mobile1=" + mobile_new + "&Card1=" + card_number_first + "&Email1=" + email + "&date1=" + date2 + "&GCName1=" + GCName2 + "&Name3=" + name_new3 + "&Mobile3=" + mobile_new3 + "&Email3=" + email_new3 + "&Name4=" + name_new4 + "&Mobile4=" + mobile_new4 + "&Email4=" + email_new4,
                                        dataType: "json",
                                        async: false,
                                        beforeSend: function (msg) {
//                                             block_screen();
                                        },
                                        success: function (resp) {
                                     
											if(resp == 1){
												
												$("#error_div1").html("");
												
												$("#cancelSlotModal").modal('show');

//var url = '/demotpl';
//window.location.href = url;


											
												//$( "#single_form" ).submit();
												
												
											}else{
											
												$("#error_div1").html("Card does not exist");
												
											}
											
                                        }
                                    });
		
		
		
	});
	
	
	
	
	
});
</script>
		<script>
			$(document).ready(function() {
			   $('input[type="radio"]').click(function() {
				   if($(this).attr('id') == 'customer_multiple') {
						$('#SinglePlayer').hide();
					    $('#MultiplePlayers').show();
				   }

				   else {
						  $('#SinglePlayer').show();
					    $('#MultiplePlayers').hide(); 
				   }
			   });
			});
		</script>
    <script type="text/javascript">
                $(function(){
	$('.Blocked').change( function() {
    var isChecked = this.checked;
    
    if(isChecked) {
        $(this).parents("div1:eq(0)").find(".form-control").prop("disabled",true); 
    } else {
        $(this).parents("div1:eq(0)").find(".form-control").prop("disabled",false);
    }
    
});
});
</script>
    
	</body>
</html>