<?php

$MailToAddress = $_POST["EMAIL2"]; // your email address
$redirectURL   = "email-offer-ty.php"; // the URL of the thank you page.
$cardLink       = $_POST["cardLink"];
$cardTitle      = $_POST["cardTitle"];

$clean = array("&reg;", "&trade;", " ");
$dirty = array("®", "™", "\xc2\xa0");

$cardTitle = str_replace($dirty, $clean, $cardTitle);


# optional settings
$MailSubject = "Credit card offer you may be interested in"; // the subject of the message you will receive
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
$Message = "Here's a credit card offer you may be interested in from CreditCards.com.<br>
CreditCards.com is a free online resource where you can compare hundreds of credit card offers.<br>
<br>
<a href='http://www.CreditCards.com/credit-cards/$cardLink.php?aid=aa411e71'>$cardTitle</a><br>
<br>
<br>
Thank you!<br>
----------------------------------------------------------------------------------------------------------------------------------<br>
Note: This link was sent to you by someone using the \"Email Offer\" feature on CreditCards.com See our <a href=\"http://www.creditcards.com/privacy.php\">privacy policy</a> for details on how your information could be used. We will not sell your information to any third party. "
;

$Message = "<font face=verdana size=2>".$Message;

mail( $MailToAddress, $MailSubject, $Message, "Content-Type: text/html; charset=ISO-8859-1\r\nFrom:Customer Service <donotreply@creditcards.com>\r\nBCc: ".$MailToCC);
header("Location: ".$redirectURL);
?>