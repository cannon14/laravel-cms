<?
include_once('../actions/pageInit.php');
if (empty($pagefid)) $pagefid = "1581";
$_SESSION['fid'] = $pagefid;
include_once('../actions/trackers.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?=( empty($this->title) ? 'CardMatch - CreditCards.com' : $this->title )?></title>

<meta name="keywords" content="<?=( empty($this->keywords) ? '' : $this->keywords )?>">
<meta name="description" content="<?=( empty($this->description) ? '' : $this->description )?>">

<link rel="stylesheet" href="css/main.css" type="text/css">


<script type="text/javascript" src="js/top_up-min.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/autotab.js"></script>
<script type="text/javascript" src="js/cardmatch.js"></script>


<script language="javascript" type="text/javascript">
function processInquiry()
{
    new Ajax.Request('./index.php',
    {
        method:'post',
        parameters: {action: '<?php echo $this->processInquiryAction ?>'},
        onSuccess: function(transport){
            var action = transport.responseText;
            document.location = './index.php?action=' + action;
        }
    });
}

function clearField(fld, val)
{
    if ((val == "First Name") || (val == "Last Name") || (val == "I"))
    {
        fld.value = "";
    }
}

function clearTextBackground(fld)
{
    fld.style.backgroundImage="none";
}

TopUp.images_path = "/cardmatch/images/";

</script>

</head>
<body>
	
<div class="wrapper">
	<table border="0" align="center" cellpadding="0" cellspacing="0" class="topbar">
		<tr>
        	<td rowspan="2" id="logo">
            	<img src="images/credit-card-match-logo.gif" alt="Online credit check with CardMatch" width="271" height="64" border="0" align="left" usemap="#cardmatch_logo" />
            	<map id="cardmatch_logo" name="cardmatch_logo">
                    <area alt="cardmatch" href="http://www.creditcards.com/" coords="80,35,271,70" shape="rect">
                </map>      
            </td>
        <td align="right" valign="top" class="top-search-cards">
            <img src="images/credit-card-offer-visa.gif" alt="Visa credit cards" width="41" height="26" border="0">
            <img src="images/credit-card-offer-mastercard.gif" alt="MasterCard credit cards" width="41" height="26" border="0">
            <img src="images/credit-card-offer-amex.gif" alt="American Express credit cards" width="41" height="26" border="0">
            <img src="images/credit-card-offer-discover.gif" alt="Discover credit cards" width="41" height="26" border="0">
        </td>
    </tr>
    
</table>

<table class="cm-sub-header" width="800" height="34" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
    <tr>
        <td style="padding: 20px 0 0;">
            <h2 style="color:#1A4F86;font-size:19px;">Better offers via CARD<i>MATCH</i>!</h2>
            <p style="font: 14px arial;">
                We match your credit profile with credit card offers from our participating partners and invite you to apply for cards you are more likely to qualify for. 
                You could be matched with special offers only available here.
            </p>


        </td>
        
    </tr>
</table>
