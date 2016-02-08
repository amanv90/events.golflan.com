<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Elements | Leisure</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="<?php echo STATIC_URL; ?>/static/css/favicon.ico" rel="icon" type="image/png">
		<link href="http://fonts.googleapis.com/css?family=Domine:400,700%7CRoboto:400,300,500,700,900" rel="stylesheet" type="text/css">
		<link href="<?php echo STATIC_URL; ?>/static/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo STATIC_URL; ?>/static/css/font-awesome.min.css" rel="stylesheet">
		<link href="<?php echo STATIC_URL; ?>/static/css/style.css" rel="stylesheet" media="screen">
		 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
 		 <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	
	
	<body>
		<div id="site">
		  	<header id="header" class="header-content" role="banner">
		  		<div class="header-row clearfix">
		  			
		  			<nav role="navigation" id="main-nav">
		  				<div class="container">
		  					<div class="row">
		  						<div class="col-xs-12">
		  							<a href="index.html" id="logo"><img src="<?php echo STATIC_URL; ?>/static/img/logo.jpg" alt=""></a>
		  							<input type="checkbox" id="toggle-main-nav" class="toggle-nav-input">
		  							
		  						
		  						</div><!-- .col-xs-12 -->
		  					</div><!-- .row -->
		  				</div><!-- .container -->
		  				<form id="search-form" action="search.html" class="hidden-xs">
		  					<div class="container">
		  						<div class="row">
		  							<div class="col-lg-12 text-center">
		  								<input type="text" class="search-field" placeholder="Type something to search  ...">
		  								<a href="#" class="close-search fa fa-search"></a>	
		  							</div>
		  						</div>
		  					</div>
		  				</form><!-- #search-form -->
		  			</nav><!-- #main-nav -->
		  			<nav role="navigation" id="secondary-nav">
		  				<div class="container">
		  					<input type="checkbox" class="toggle-nav-input" id="toggle-secondary-nav">
		  					
		  				</div><!-- .container -->
		  			</nav><!-- #secondary-nav -->
		  			<label class="toggle-nav-label" for="toggle-main-nav"><i class="fa fa-bars fa-lg"></i> Menu</label>
		  			<label class="toggle-nav-label" for="toggle-secondary-nav"><i class="fa fa-info-circle fa-lg"></i>Services</label>
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
			<div class="container">
 

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Your Registration</h4>
        </div>
        <div class="modal-body">
          
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
			<hr/>
				 <form class="js-validation-register form-horizontal push-50-t push-50" action="/demo" method="post">

			
				
				<div id="SinglePlayer">
					<p>Please enter the details as follows. All fields are mandatory.<br></p>
				<input style="width:49%;float:left;margin-bottom:10px;" id="email" name="Name"required type="text" placeholder="First Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="register-Lname" name="Mobile" required pattern="[789][0-9]{9}" type="text" placeholder="Mobile No." class="form-control" value="">
				
				<input style="width:49%;float:left;margin-bottom:10px;" id="email" name="Email" required pattern="[^ @]*@[^ @]*""text" placeholder="Email Address" class="form-control" value="">				
		
          <div1>  <input style="width:49%;float:right;" id="email" type="text" name="Card" placeholder="EGC Card No." class="form-control" />
         <br><br><input type="checkbox" class="Blocked" /> i am not a member</div1> 
       
					
					
					
					<!--<div class="" id="noticeweeks"><input style="width:49%;float:right;" id="email" name="Card" type="text" placeholder="EGC Card No." class="form-control" value=""></div>
			--><div class="">
											<button  class="btn btn-block btn-success" type="submit" onclick="myFunction()"><i class="fa fa-plus pull-right"></i> Register</button>
										</div>	
			</div>
		</form>	
			
		<form class="" action="/demo" method="post">

			<div id="MultiplePlayers" style="display:none;">
				<p>Please enter the details as follows, there can be 3 players in a team.</p>
				<div id="golferOne">
					<p style="font-size:15px;font-weight:700;">Your Details</p>
					
				 <input style="width:49%;float:left;margin-bottom:10px;" id="email" name="Name1" required type="text" placeholder="Full Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="email" name="Mobile1" required pattern="[789][0-9]{9}" type="text" placeholder="Mobile No." class="form-control" value="">
				
				<input style="width:49%;float:left;" id="email" name="Email1" required pattern="[^ @]*@[^ @]*""text" type="text" placeholder="Email Address" class="form-control" value="">				
				   <div1>  <input style="width:49%;float:right;" id="email" type="text" name="Card" placeholder="EGC Card No." class="form-control" />
         <br><br><input type="checkbox" class="Blocked" /> i am not a member</div1> 
					
					<!--<input style="width:49%;float:right;" id="email" name="Card1" type="text" placeholder="EGC Card No." class="form-control" value="">
					-->
				</div>
				<div style="clear:both;"></div>
				<div id="golferTwo">
					<p style="font-size:15px;margin-top:20px;font-weight:700;">Second Golfer</p>
					<input style="width:49%;float:left;margin-bottom:10px;" id="email" name="Name2" required type="text" placeholder="Full Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="email" name="Mobile2" required pattern="[789][0-9]{9}" type="text" placeholder="Mobile No." class="form-control" value="">
				
				<input id="email" name="Email2" required pattern="[^ @]*@[^ @]*""text" type="text" placeholder="Email Address" class="form-control" value="">		
				
				</div>
				<div style="clear:both;"></div>
				<div id="golferThree">
					<p style="margin-top:10px;font-size:15px;margin-top:20px;font-weight:700;">Third Golfer</p>
					<input style="width:49%;float:left;margin-bottom:10px;" id="email" name="Name3"required  type="text" placeholder="Full Name" class="form-control" value="">				
				 <input style="width:49%;float:right;margin-bottom:10px;" id="email" name="Mobile3" required pattern="[789][0-9]{9}" type="text" placeholder="Mobile No." class="form-control" value="">
				
				<input id="email" name="Email3"required pattern="[^ @]*@[^ @]*""text" type="text" placeholder="Email Address" class="form-control" value="">		
				</div>
				 <div class="">
							<button class="btn btn-block btn-success" type="submit" onclick="submitSignupForm();"><i class="fa fa-plus pull-right"></i> Register</button>
				</div>	
			</div>
								 
        </div>
       
      </div>
      
    </div>
  </div>
  
</div>
		  	<article id="content">
			  	<section class="container content-padding-lg">
			  		<div class="row animated">
						
						<div class="col-sm-6 col-xs">
							<div class="bs-example bs-example-tabs">
							    <ul id="myTab" class="nav nav-tabs">
							      <li class="active"><a href="#tab1" data-toggle="tab">All Games</a></li>
							      <li class=""><a href="#tab2" data-toggle="tab">North</a></li>
							      <li class=""><a href="#tab3" data-toggle="tab">South</a></li>
							      <li class=""><a href="#tab3" data-toggle="tab">West</a></li>
							    </ul>
							    <div id="myTabContent" class="tab-content" style="width:650px;">
							      <div class="tab-pane fade active in" id="tab1">
							       <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="" data-toggle="modal" data-target="#myModal">Register</button></p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course<button type="button" class="" data-toggle="modal" data-target="#myModal">Register</button></p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>
							        <p> 21-Feb-2016&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st Qualifier&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;New Delhi&nbsp;&nbsp;&nbsp;&nbsp;ITC Classic Golf Course</p>

									</div>
							      <div class="tab-pane fade" id="tab2">
							        <p>Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Tityre, tu patulae recubans sub tegmine fagi  dolor. Tu quoque, Brute, fili mi, nihil timor populi, nihil!</p>
							        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
							      </div>
							      <div class="tab-pane fade" id="tab3">
							        <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth.</p>
							        <p>Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Tityre, tu patulae recubans sub tegmine fagi  dolor. Tu quoque, Brute, fili mi, nihil timor populi, nihil!</p>
							      </div>
							    </div>
							  </div>
						</div>
			  		</div><!-- .row -->
			  		<?php //echo $activateMailVerify;?>
			  	</section><!-- .container -->
		  	</article><!-- #content -->  	
		  	<footer id="footer" role="contentinfo">
		  		<div class="container">
		  			<div class="row" id="main-footer">
		  				<aside class="col-lg-2 col-md-3 col-sm-4 widget">
		  					<h5 class="widget-title">Leisure Club</h5>
		  					<p>St Andrews Scotland,
		  					United Kingdom KY16 8PN<br><br>
		  					
		  					Tel  +44 (0) 1334 837000<br>
		  					Fax +44 (0) 1334 837099</p>
		  				</aside><!-- .widget -->
		  				<aside class="col-lg-2 col-md-3 col-sm-4 widget">
		  					<h5 class="widget-title">The Resort</h5>
		  					<p>
		  						<a href="members.html">Member Bookings</a><br>
		  						<a href="events.html">Open Competitions</a><br>
		  						<a href="contact.html">Location</a><br>
		  						<a href="contact.html">Contact us</a><br>
		  						<a href="resort.html">Our Team</a><br>
		  					</p>
		  				</aside><!-- .widget -->
		  				<aside class="col-lg-2 col-md-3 col-sm-4 widget">
		  					<h5 class="widget-title">The Club</h5>
		  					<p>
		  						<a href="resort.html">Clubhouse</a><br>
		  						<a href="resort.html">Officers &amp; Council </a><br>
		  						<a href="resort.html">History</a><br>
		  						<a href="resort.html">Locality</a><br>
		  						<a href="media-gallery.html">Gallery</a><br>
		  					</p>
		  				</aside><!-- .widget -->
		  				<aside class="col-lg-2 col-md-3 col-sm-4 widget">
		  					<h5 class="widget-title">The Courses</h5>
		  					<p>
		  						<a href="activities.html">Headfort Old</a><br>
		  						<a href="activities.html">Headfort New</a><br>
		  						<a href="activities.html">Rankings</a><br>
		  						<a href="activities.html">Practice Facilities</a><br>
		  						<a href="media-gallery.html">Flora and Fauna</a><br>
		  					</p>
		  				</aside><!-- .widget -->
		  				<aside class="col-lg-2 col-md-3 col-sm-4 widget">
		  					<h5 class="widget-title">Visitors</h5>
		  					<p>
		  						<a href="room-view.html">Visitor Booking</a><br>
		  						<a href="members.html">Green Fees</a><br>
		  						<a href="resort.html">Societies / Groups</a><br>
		  						<a href="testimonials.html">Testimonials</a><br>
		  					</p>
		  				</aside><!-- .widget -->
		  				<aside class="col-lg-2 col-md-3 col-sm-4 widget">
		  					<a href="index.html"><img src="images/logo-leisure.png" alt=""></a>
		  				</aside><!-- .widget -->
		  			</div><!-- end .row -->
		  			<div class="row" id="absolute-footer">
		  				<div class="col-lg-12">
		  					<aside class="widget">
		  						<p>Leisure - HTML Template. Designed with special care by <a href="http://demo.curlythemes.com" target="_blank"><abbr title="Premium WordPress Themes & Plugins">Curly Themes</abbr></a>. All Rights Reserved. 
		  						<span class="pull-right hidden-xs">
		  							<a href="#" class="fa fa-boxed fa-rss" data-toggle="tooltip" data-placement="left" title="Leisure RSS"></a>
		  							<a href="http://www.pinterest.com/raducretu/curly-themes/" class="fa fa-boxed fa-pinterest" data-toggle="tooltip" data-placement="left" title="Leisure Pintrest Board"></a>
		  							<a href="https://www.facebook.com/cthemes" class="fa fa-boxed fa-facebook" data-toggle="tooltip" data-placement="left" title="Leisure on Facebook"></a>
		  							<a href="https://twitter.com/CurlyThemes" class="fa fa-boxed fa-twitter" data-toggle="tooltip" data-placement="left" title="Leisure on Twitter"></a>
		  						</span>
		  						</p>
		  					</aside><!-- .widget -->
		  				</div>
		  			</div><!-- #absolute-footer -->
		  		</div><!-- .container -->
		  	</footer><!-- #footer -->
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
		<script type="text/javascript">
$(document).ready(function() {
 
$('.hide').click(function() {
$(this).next().toggle();
});
$('.hide:checked').next().hide();
 
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
			<script>
function myFunction() {
    alert("I am an alert box!");
}
</script>
	</body>
</html>