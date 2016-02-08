<?php
$ord_id = $_GET['ord_id'];
if($ord_id=="") $ord_id = date("mdhis");
?>
<html>
<head>
<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
	};
</script>
</head>
<body>
	<h3>Redirecting to Payment Gateway ...</h3>
	
	<form method="post" name="customerData" action="ccavRequestHandler.php">
	<input type="hidden" name="tid" id="tid" readonly />
	<input type="hidden" name="merchant_id" value="9205"/>
	<input type="hidden" name="order_id" value="<?=$ord_id;?>"/>
	<input type="hidden" name="amount" value="<?=$_GET['amt'];?>"/>
	<input type="hidden" name="currency" value="INR"/>
	<input type="hidden" name="redirect_url" value="http://golflan.com/cca/ccavResponseHandler.php"/>
	<input type="hidden" name="cancel_url" value="http://golflan.com/cca/ccavResponseHandler.php"/>
	<input type="hidden" name="language" value="EN"/>
	</form>
	
	<script language='javascript'>document.customerData.submit();</script>	
</body>
</html>


