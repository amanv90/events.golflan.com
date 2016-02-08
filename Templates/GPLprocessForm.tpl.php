<?php

// Define some constants
define( "RECIPIENT_NAME", "GolfLan" );
define( "RECIPIENT_EMAIL", "customer.care@golflan.com" );
define( "EMAIL_SUBJECT", "Request For GPL" );

// Read the form values
$success = false;
$senderName = isset( $_POST['Name'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['Name'] ) : "";
$senderEmail = isset( $_POST['Email'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['Email'] ) : "";
$message = isset( $_POST['Email'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['Email'] ) : "";
$message .= "Hi,

Request Generated for a GolfLan Premier League 
1. Name =".$_POST['Name']."
2. Email=".$_POST['Email']."
3. Contact No =".$_POST['contactNo']."
4. Card No. =".$_POST['cardNo']."
5. Select Date. =".$_POST['selectDateGPL']."



Happy Golfing!!!
Team GolfLAN
India's Leading Online Golf Consulting Company
If you need any assistance or have any questions, feel free to contact us by emailing us at customer.care@GolfLAN.com or call us at 1800-208-7899. We'll keep you posted!";

echo $_POST['Name']."----".$_POST['contactNo']."--".$_POST['Email'];
// If all values exist, send the email
if ( $senderName && $senderEmail && $message ) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $senderName . " <" . $senderEmail . ">";
  $success = mail( $recipient, EMAIL_SUBJECT, $message, $headers );
}

// Return an appropriate response to the browser
if ( isset($_GET["ajax"]) ) {
  echo $success ? "success" : "error";
} else {
?>
<html>
  <head>
    <title>Thanks!</title>
  </head>
  <body>
  <?php if ( $success ) echo "<p>Thanks You! We'll get back to you shortly.</p>" ?>
  <?php if ( !$success ) echo "<p>There was a problem sending your message. Please try again.</p>" ?>
  <p>Click your browser's Back button to return to the page.</p>
  </body>
</html>
<?php
}

//header('Location: ' . $_SERVER['HTTP_REFERER']);
header( "refresh:0;url=GPL" );
?>


