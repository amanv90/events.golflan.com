<?php include('Crypto.php')?>
<?php

	error_reporting(0);
	
	$workingKey='C545235E0C05AA7D983B58E6D08B3C15';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	echo "test<br/>";
	var_dump($_POST["encResp"]);
	echo "<br/>";
	var_dump($rcvdString);
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

	if($order_status==="Success")
	{
		echo "<br>Thank you for your booking.";
		
	}
	else if($order_status==="Aborted")
	{
		echo "<br>Booking can't be completed. Please contact support for further help.";
	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Your transaction is declined. Booking can't be completed. Please contact support for further help.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}

	echo "</table><br>";
	echo "</center>";
?>
