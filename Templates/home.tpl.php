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
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="<?php echo STATIC_URL; ?>/static/js/jquery.prettySocial.min.js"></script>
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
	<style>
        body {
            font: 12px/20px ;
			font-family: "Arial";
            padding: 0;
            margin: 0;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAMAAAAp4XiDAAAAGFBMVEX29vb19fXw8PDy8vL09PTz8/Pv7+/x8fGKuegbAAAAyUlEQVR42pXRQQ7CMBRDwST9pfe/MahEmgURbt7WmpVb6+vG0dd9REnn66xRy/qXiCgmEIIJhGACIZhACCYQgvlDCDFIEAwSBIMEwSBBMEgQDBIEgwTBIEEwCJEMQiSDENFMQmQzCZEbNyGemd6KeGZ6u4hnXe2qbdLHFjhf1XqNLXHev4wdMd9nspiEiWISJgqECQJhgkCYIBAmCIQJAmGCQJggECYJhAkCEUMEwhCBMEQgDJEIQ2RSg0iEIRJhiB/S+rrjqvXQ3paIJUgPBXxiAAAAAElFTkSuQmCC);
        }
        .social-container {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -190px;
            margin-top: 240px;
            width: 380px;
            height: 100px;
			
        }
        .social-container .links {
            margin-bottom: 80px;
            text-align: center;
        }
        .social-container .links a {
            margin: 0 20px;
            color:#000000;
            text-decoration: none;
            font-size: 34px;
            font-weight: bold;
            text-shadow: 0px 2px 3px #fff;
        }
        .social-container .links a:hover {
            color: #ED452A;
        }
        .source {
            width: 350px;
            margin: 0 auto;
            background: #eee;
            color: #666;
            font-weight: bold;
            display: block;
            white-space: pre;

            -webkit-border-radius: 3px;
               -moz-border-radius: 3px;
                    border-radius: 3px;

            -webkit-box-shadow: inset #ccc 0px 0px 6px 0px;
               -moz-box-shadow: inset #ccc 0px 0px 6px 0px;
                    box-shadow: inset #ccc 0px 0px 6px 0px;
        }
		
		.firstTd {
			width:100px;	
		}
		
		.thirdTd {
			width:100px;
			padding-left:10px;
		}
		
		.buttonRegister {
			background-color: #000000;
			color: #FFFFFF;
			width: 80px;
			FONT-SIZE: 12px;
			padding: 6px;
			border: none !important;
		}
		
    </style>
		<style>
th, td {
    border-bottom: 1px solid #ddd;
	padding-top: 10px;
	padding-bottom: 4px;
}

</style>
	<style>
.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
		
		
		
</style>
		
		<style>
		
			.modal-content {
      			
				background-color:#ecf0f1;
			    width: 700px;
				height:790px;
				top:-60px;
    }
		</style>
		
	</head>
	<body>
		
		
		 <div class="modal fade" id="cancelSlotModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
               
                    <div class="modal-dialog">
                        <div class="modal-content">
                           
							<div class="modal-body1">
                               <img src = "/static/img/gplChart.jpg" />
                            </div>

                           
                        </div>
                    </div>
               
           </div>
		<div class="modal fade" id="cancelSlotModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
               
                    <div class="modal-dialog">
                        <div class="modal-content">
                           
							<div class="modal-body1">
                               <img src ="/static/img/EventCalender.jpg" />
                            </div>

                           
                        </div>
                    </div>
               
           </div>
		
		<div>
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
			
		</div>
		<div id="site" style="background-color:#F3F3F3;">
			<br><br>
		  	<header id="header" class="header-content" role="banner" style="width:1150px; margin-left:53px; background:url(/static/img/gpl.jpg)":>
		  		<div class="">
		  			
		  			<nav role="" id="">
		  				<div class="container">
		  					<div class="row">
		  						<div class="col-xs-12">
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
		  	<article id="content">
			  	<section class="container content-padding-lg" style="padding-top:3.8rem !important;padding-bottom:1.8rem !important;">
					<div class="row animated">
						<div class="col-sm-8 col-xs">
							<div class="bs-example bs-example-tabs">
							    <ul id="myTab" class="nav nav-tabs">
							      <li class="active"><a href="#tab1" data-toggle="tab">All Games</a></li>
							      <li class=""><a href="#tab2" data-toggle="tab">North</a></li>
							      <li class=""><a href="#tab3" data-toggle="tab">South</a></li>
							      <li class=""><a href="#tab4" data-toggle="tab">West</a></li>
							    </ul>
			

							    <div id="myTabContent" class="tab-content">
							      <div class="tab-pane fade active in" id="tab1">
									  <table style="width:100%">
											<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="21-Feb-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Golden Greens Golf Course"> 
	<td class="firstTd">28-Feb-16</td>
    <td>North</td>        
    <td class="thirdTd">1st Qualifier</td>
    <td>Golden Greens Golf Course</td>
    <td style="padding-right:70px;">Gurgaon</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button>
	</td>
	</form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="05-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Panchkula Golf Club"> 
	   <td class="firstTd">05-March-16</td>
    <td>North</td>        
    <td class="thirdTd">2nd Qualifier</td>
    <td>Panchkula Golf Club</td>
    <td>Chandigarh</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="06-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Unitech Golf and Country Club"> <td>06-March-16</td>
    <td>North</td>        
    <td class="thirdTd">3rd Qualifier</td>
    <td>Unitech Golf and Country Club</td>
    <td>Noida</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="13-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Clover Greens Golf Club"> <td>13-March-16</td>
    <td>South</td>        
    <td class="thirdTd">1st Qualifier</td>
    <td>Clover Greens Golf Club</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>


<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="20-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="The Bombay Presidency Golf Club"> <td>20-March-16</td>
    <td>West</td>        
    <td class="thirdTd">1st Qualifier</td>
    <td>The Bombay Presidency Golf Club</td>
    <td>Mumbai</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>


<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="10-April-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Jaypee Greens Wish Town Golf Course"> <td>10-April-16</td>
    <td>North</td>        
    <td class="thirdTd">4th Qualifier</td>
    <td>Jaypee Greens Wish Town Golf Course</td>
    <td>Noida</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="17-April-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Eagleton Golf Club"> <td>17-April-16</td>
    <td>South</td>        
    <td class="thirdTd">2nd Qualifier</td>
    <td>Eagleton Golf Club</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="24-April-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="The Bombay Presidency Golf Club"> <td>24-April-16</td>
    <td>West</td>        
    <td class="thirdTd">2nd Qualifier</td>
    <td>The Bombay Presidency Golf Club</td>
    <td>Mumbai</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>


<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="08-May-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Champion Reef Golf County"> <td>08-May-16</td>
    <td>South</td>        
    <td class="thirdTd">3rd Qualifier</td>
    <td>Champion Reef Golf County</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="14-May-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Oxford Golf & Country Club"> <td>14-May-16</td>
    <td>West</td>        
    <td class="thirdTd">3rd Qualifier</td>
    <td>Oxford Golf & Country Club</td>
    <td>Pune</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="15-May-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="The Bombay Presidency Golf Club"> <td>15-May-16</td>
    <td>West</td>        
    <td class="thirdTd">4th Qualifier</td>
    <td>The Bombay Presidency Golf Club</td>
    <td>Mumbai</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="12-June-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Golfshire Club"> <td>12-June-16</td>
    <td>South</td>        
    <td class="thirdTd">4th Qualifier</td>
    <td>Golfshire Club</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
										  </table>
									</div>
							      <div class="tab-pane fade" id="tab2">
							       <table style="width:100%">  
									  <tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="21-Feb-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Golden Greens Golf Course"> <td>28-February-16</td>
    <td>North</td>        
    <td class="thirdTd">1st Qualifier</td>
    <td>Golden Greens Golf Course</td>
    <td>Gurgaon</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="05-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Panchkula Golf Club"> <td>05-March-16</td>
    <td>North</td>        
    <td class="thirdTd">2nd Qualifier</td>
    <td>Panchkula Golf Club</td>
    <td>Chandigarh</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
									
				<tr> 
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="06-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Unitech Golf and Country Club"> <td>06-March-16</td>
    <td>North</td>        
    <td class="thirdTd">3rd Qualifier</td>
    <td>Unitech Golf and Country Club</td>
    <td>Noida</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>				
<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="10-April-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Jaypee Greens Wish Town Golf Course"> <td>10-April-16</td>
    <td>North</td>        
    <td class="thirdTd">4th Qualifier</td>
    <td>Jaypee Greens Wish Town Golf Course</td>
    <td>Noida</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
									  </table>
									</div>
							      <div class="tab-pane fade" id="tab3">
							       <table style="width:100%">  
									  <tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="13-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Clover Greens Golf Club"> <td>13-March-16</td>
    <td>South</td>        
    <td class="thirdTd">1st Qualifier</td>
    <td>Clover Greens Golf Club</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
				<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="17-April-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Eagleton Golf Club"> <td>17-April-16</td>
    <td>South</td>        
    <td class="thirdTd">2nd Qualifier</td>
    <td>Eagleton Golf Club</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>		
									  <tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="08-May-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Champion Reef Golf County"> <td>08-May-16</td>
    <td>South</td>        
    <td class="thirdTd">3rd Qualifier</td>
    <td>Champion Reef Golf County</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
									  <tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="12-June-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Golfshire Club"> <td>12-June-16</td>
    <td>South</td>        
    <td class="thirdTd">4th Qualifier</td>
    <td>Golfshire Club</td>
    <td>Bangalore</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
									  </table>
									</div>
							   
				                    <div class="tab-pane fade" id="tab4">
							     <table style="width:100%">      
									<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="20-March-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="The Bombay Presidency Golf Club"> <td>20-March-16</td>
    <td>West</td>        
    <td class="thirdTd">1st Qualifier</td>
    <td>The Bombay Presidency Golf Club</td>
    <td>Mumbai</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
					<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="24-April-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="The Bombay Presidency Golf Club"> <td>24-April-16</td>
    <td>West</td>        
    <td class="thirdTd">2nd Qualifier</td>
    <td>The Bombay Presidency Golf Club</td>
    <td>Mumbai</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>				
									 <tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="14-May-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="Oxford Golf & Country Club"> <td>14-May-16</td>
    <td>West</td>        
    <td class="thirdTd">3rd Qualifier</td>
    <td>Oxford Golf & Country Club</td>
    <td>Pune</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>

<tr>
   <form class="" action="/gplRegister" method="post"><input class="hidden" type="text"
name="date" placeholder="Home Course" value="15-May-2016"><input class="hidden" type="text"
name="GCName" placeholder="Home Course" value="The Bombay Presidency Golf Club"> <td>15-May-16</td>
    <td>West</td>        
    <td class="thirdTd">4th Qualifier</td>
    <td>The Bombay Presidency Golf Club</td>
    <td>Mumbai</td>
       <td><button class="buttonRegister" type="submit" style="background-color:#000000; color:#FFFFFF; width:80px;">Register</button></td></form>
  </tr>
										</table>
									</div> <br>
				  </form>* Each golfer is allowed to register only once in the qualifying rounds.
							  </div>
								
						</div>
			  		</div>
					<div class="col-sm-3 col-xs" style="margin-left:45px;">						 
						<a href="javascript:void();" id="game_format" class="button" style="width:265px; font-size:20px;"><b>Game Format</b></a>
						<a href="javascript:void();" id="game_format1" class="button" style="width:265px; font-size:20px; background-color:#FF8000;margin-top:10px;"><b>Calendar</b></a>
						<div style="margin-top:20px;" class="fb-page" data-href="https://www.facebook.com/GOLFLAN" data-tabs="timeline" data-width="300" data-height="300" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/GOLFLAN"><a href="https://www.facebook.com/GOLFLAN">GolfLan.com</a></blockquote></div></div>
							
						<div style="margin-top:20px;">
 <a class="twitter-timeline" href="https://twitter.com/hashtag/gpl2" data-widget-id="695207801107296256">#gpl2 Tweets</a>
						</div>
					</div>
			  	</section>
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
		
		<script type="text/javascript" language="javascript">
			
			$(document).ready(function() {
			
				$( "#game_format" ).click(function() {
					
			$("#cancelSlotModal").modal('show');
					
				});
				
				
				
			});
		</script>
		
		<script type="text/javascript" language="javascript">
			
			$(document).ready(function() {
			
				$( "#game_format1" ).click(function() {
					
			$("#cancelSlotModal1").modal('show');
					
				});
				
				
				
			});
		</script>

		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
	</body>
</html>
