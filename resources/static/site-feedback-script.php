<?php

$MailToAddress = "productfeedback@creditcards.com"; // your email address
$redirectURL = "site-feedback-thankyou.php"; // the URL of the thank you page.

# optional settings
// the subject of the message you will receive
$MailSubject = "[Feedback Form - " . $_REQUEST['PRODUCT'] . ": CreditCards.com] " . $_REQUEST['EMAIL'];

$MailToCC = ""; // CC (carbon copy) also send the email to this address (leave empty if you don't use it)
# in the $MailToCC field you can have more then one e-mail address like "d@wherever.com, b@wherever.com, c@wherever.com"

# If you are asking for an email address in your form, you can name that input field "email".
# If you do this, the message will apear to come from that email address and you can simply click the reply button to answer it.
# You can use this script to submit your forms or to receive orders by email.
# You need to send the form as POST!

# If you have a multiple selection box or multiple checkboxes, you MUST name the multiple list box or checkbox as "name[]" instead of just "name" 
# you must also add "multiple" at the end of the tag like this: <select name="myselect[]" multiple> 
# and the same way with checkboxes

# DO NOT EDIT BELOW THIS LINE ============================================================
# ver. 1.2
$Message = "";
    if (!is_array($_POST))
    return;
reset($_POST);
// THIS IS TEMP. If you see this code after 8/10/2015, Please remove the new declaration of value and uncomment the following original code
//$values = $_POST;

$values = array_merge($_POST, $_SERVER);

	while(list($key, $val) = each($values)) {
		$GLOBALS[$key] = $val;
		if (is_array($val)) {
			$Message .= "$key: ";
			foreach ($val as $vala) {
				$vala =stripslashes($vala);
				$Message .= "$vala, ";
			}
			$Message .= "<br>";
		}
		else {
			$val = stripslashes($val);
			if (($key == "Submit") || ($key == "submit")) { }
			else { 	if ($val == "") { $Message .= "$key: <br>"; }
					else { $Message .= "$key: $val<br>"; }
			}
		}
	} // end while

//add on IP address
$Message .= "<br>IP Address: " . $_SERVER['REMOTE_ADDR'];
$Message = "<font face=verdana size=2>".$Message;

mail( $MailToAddress, $MailSubject, $Message, "Content-Type: text/html; charset=ISO-8859-1\r\nFrom:mailfwd@creditcards.com\r\nBCc: ".$MailToCC);
header('Location: ' . $redirectURL . '?PRODUCT=' . $_REQUEST['PRODUCT']);
?>