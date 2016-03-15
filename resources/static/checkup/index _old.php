<?
include_once('../actions/pageInit.php');
$_SESSION['fid'] = "1490";
include_once('../actions/trackers.php');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Credit Card CheckUp Tool - CreditCards.com</title>
<meta name="keywords" content="credit card checkup tool, free credit card check up, credit card check tool">
<meta name="description" content="Use our free interactive credit card checkup calculator to compare your current credit cards against dozens of others to determine if swapping to a different credit card can save you money. Enter your details below to see the benefits of switching at CreditCards.com">

<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta http-equiv="Pragma" content="no-cache">
<meta name="author" content="CreditCards.com">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">

<link rel="stylesheet" href="/css/credit-cards.css" type="text/css" />
<link rel="stylesheet" href="/javascript/jquery/jquery.autocomplete.css" type="text/css" />
<link rel="stylesheet" href="/javascript/thickbox/thickbox-dark.css" type="text/css">

<script type="text/javascript" src="/javascript/application.js"></script>
<script type="text/javascript" src="/javascript/tooltip2.js"></script>
<script type="text/javascript" src="/javascript/jquery/jquery.js"></script>
<script type='text/javascript' src='/javascript/jquery/jquery.autocomplete.min.js'></script>
<script type="text/javascript" src="/javascript/thickbox/thickbox.js"></script>

<script language="javascript">
var cardLibrary = [];
</script>

<!-- set cardLibrary data -->
<script type="text/javascript" src="/checkup/auto_complete_data.js"></script>

<script language="javascript">

var autoCard;

$().ready(function() {

    $("#user_card_name").autocomplete(cardLibrary, {
        matchContains: true,
        minChars: 0,
        width: 400,
        max: 1000,
        formatItem: function(row, i, max, term) {
            return row.name.replace(new RegExp("�", "gi"), "");
        },
        formatResult: function(row) {
            return row.name.replace(new RegExp("�", "gi"), "");
        }
    });

    $('#user_card_name').result(function(event, data, formatted) {

        document.getElementById("user_apr").value = data['apr'];
        document.getElementById("user_annual_fee").value = data['annualFee'];

        var image = "";

        if( data['marketable'] == 1) {
            image = 'http://www.imgsynergy.com/cccom/' + data['image'];
        } else {
            image = 'http://allcardrates.com/ratehub/cardimages/' + data['image'];
        }

        if(data['image'] == "")
            image = "http://www.imgsynergy.com/cccom/card-not-available.gif";

        autoCard = data['name'];

        document.getElementById("user_card_image").innerHTML = '<img src="' + image + '" width="95" height="60" />';
        document.getElementById("card_image").value = data['image'];
        document.getElementById("marketable").value = data['marketable'];
    });
});

function checkAutoValue(val) {
    if(val != autoCard) {
        document.getElementById("user_card_image").innerHTML = '<img src="http://www.imgsynergy.com/cccom/card-not-available.gif" width="95" height="60" />';
        document.getElementById("card_image").value = '';

        document.getElementById("user_apr").value = '';
        document.getElementById("user_annual_fee").value = '';
    }
}

function validateRateForm(frm) {

    if (frm.user_card_name.value == "") {
        alert("Please enter the name of your current credit card.");
        frm.user_card_name.focus();
        return false;

    } else if (frm.user_apr.value == "") {
        alert("Please enter your current interest rate. ( ex. 12.45 )");
        frm.user_apr.focus();
        return false;

    } else if (frm.user_annual_fee.value == "") {
        alert("Please enter your current annual fee. ( ex. 50 )");
        frm.user_annual_fee.focus();
        return false;

    } else if (frm.user_principle.value == "") {
        alert("Please enter the amount you owe. ( ex. 4500 )");
        frm.user_principle.focus();
        return false;

    } else if (frm.user_monthly_charges.value == "") {
        alert("Please enter your estimated monthly charges. ( ex. 250 )");
        frm.user_monthly_charges.focus();
        return false;

    } else if (frm.user_payment.value == "") {
        alert("Please enter your monthly payment. ( ex. 275 )");
        frm.user_payment.focus();
        return false;
    }

    frm.user_card_name.value = escape(frm.user_card_name.value);
    frm.user_annual_fee.value = escape(frm.user_annual_fee.value);
    frm.user_principle.value = escape(frm.user_principle.value);
    frm.user_monthly_charges.value = escape(frm.user_monthly_charges.value);
    frm.user_payment.value = escape(frm.user_payment.value);

    return true;
}

/* onKeyPress validation function */
function validVal(event, keyRE) {
    if (    ( typeof(event.keyCode) != 'undefined' && event.keyCode > 0 && String.fromCharCode(event.keyCode).search(keyRE) != (-1) ) ||
        ( typeof(event.charCode) != 'undefined' && event.charCode > 0 && String.fromCharCode(event.charCode).search(keyRE) != (-1) ) ||
        ( typeof(event.charCode) != 'undefined' && event.charCode != event.keyCode && typeof(event.keyCode) != 'undefined' && event.keyCode.toString().search(/^(8|9|13|45|46|35|36|37|39)$/) != (-1) ) ||
        ( typeof(event.charCode) != 'undefined' && event.charCode == event.keyCode && typeof(event.keyCode) != 'undefined' && event.keyCode.toString().search(/^(8|9|13)$/) != (-1) ) ) {
        return true;
    } else {
        return false;
    }
}

</script>

<script src="/javascript/AC_RunActiveContent.js" language="javascript"></script>

<style>
.savingsCallout {
    font-size: 16px;
    font-weight: bold;
    color: #cc0000;
}
</style>

</head>
<body>

<div id="skeleton">

<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/header.php"; ?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="mainLeftNav"><?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/left-nav.php"; ?></td>
        <td class="mainContentColumn">

            <div id="breadcrumb">
                <a href="http://www.creditcards.com">Credit Cards</a> &gt; <a href="/credit-card-tools/">Tools</a> &gt; Credit Card CheckUp
            </div>

            <div id="pageContentArea">

                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 20px; margin-right: 20px">
                    <tr>
                        <td><img src="/images/credit-corner-trans-top-lft.gif" width="6" height="6"></td>
                        <td background="/images/credit-corner-trans-hdr_fill.gif"><img src="/images/spacer.gif" width="1" height="6"></td>
                        <td><img src="/images/credit-corner-trans-top-rt.gif" width="6" height="6"></td>
                    </tr>
                    <tr>
                        <td background="/images/credit-corner-trans-body_leftfill.gif"><img src="/images/spacer.gif" width="6" height="1"></td>
                        <td width="100%" class="content" style="padding: 5px 0 0 5px;">

			                <table width="100%" border="0" cellpadding="0" cellspacing="0">
			                    <tr>
			                        <td valign="top">
			                            <h1 style="padding-top: 0;">Give Your Card a Free Check Up</h1>
			                        </td>
		                          <td rowspan="2" valign="top" style="padding: 0 20px 5px 20px; ">

		                           <a class="thickbox" href="#TB_inline?height=415&amp;width=740&amp;inlineId=hiddenModalContent" ><img src="../images/checkup-demo-btn.gif" border="0" /></a>

 <div id="hiddenModalContent" style="display:none ">

                    <object width="740" height="415"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=12621897&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1&autoplay=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=12621897&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1&autoplay=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="740" height="415"></embed></object>


				</div>


		                          </td>
			                    </tr>
			                    <tr>
			                        <td valign="top">
			                            <p style="font-size: 13px;">
                                            Credit card rates and fees have gone up for many people. You don't need <em>another</em> card, you need a <em>better</em> card. 
                                            A fast, free checkup can tell you if your current card is unhealthy for your budget. We'll compare your current credit card against others from our bank 
                                            partners and tell you which cards might save you the most money.
                                        </p>
                                        <p style="font-size: 13px;">Enter your details below to see if and how much you could save by switching.</p>
		                          </td>
			                    </tr>
			                </table>

                        </td>
                        <td background="/images/credit-corner-trans-body_rightfill.gif"><img src="/images/spacer.gif" width="6" height="1"></td>
                    </tr>
                    <tr>
                        <td><img src="/images/credit-corner-trans-bt-lft.gif" width="6" height="6"></td>
                        <td background="/images/credit-corner-trans-ftr_fill.gif"><img src="/images/spacer.gif" width="1" height="6"></td>
                        <td><img src="/images/credit-corner-trans-bt-rt.gif" width="6" height="6"></td>
                    </tr>
                </table>


<style>
.formSectionHeader {
    background-color: #afafaf;
    font-weight: bold;
    color: #fff;
}

.label {
    font-weight: bold;
    white-space: nowrap;
}

.formNote {
    font-size: 11px;
    font-style: italic;
    color: #666;
}
</style>

                <form action="loading.php" name="checkup" method="post" onsubmit="javascript: return validateRateForm(this);">

                <table cellspacing="0" cellpadding="5" width="100%" border="0" style="border: 2px solid #afafaf">
                    <tr>
                        <td class="formSectionHeader" colspan="3">Tell us about your current card</td>
                    </tr>
                    <tr>
                        <td class="label" width="120" height="30">Name of your card:</td>
                        <td>
                            <input name="user_card_name" id="user_card_name" type="text" style="width: 325px;" onblur="javascript:checkAutoValue(this.value);" /> <a href="javascript:;" onmouseover="ShowContent('ccToolTipDiv'); return true;" onmouseout="HideContent('ccToolTipDiv'); return true;"><img src="/images/icn_help.gif" border="0" style="padding-left: 5px;" align="top" /></a>
                            <div id="ccToolTipDiv"
                                   style="display:none;
                                  position:absolute;
                                  border: 1px solid black;
                                  width: 200px;
                                  background-color: white;
                                  padding: 5px;
                                  z-index: 100;">
                              Enter the name of your credit card and pick your card from the drop-down list. If your card is not listed in the drop-down box, simply type in the full name of your card and continue entering values for the remaining fields.
                            </div>
                        </td>
                        <td rowspan="3" id="user_card_image">

                            <img src="http://www.imgsynergy.com/cccom/card-not-available.gif" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Interest Rate:</td>
                        <td><input type="text" name="user_apr" id="user_apr" size="7" maxlength="7" onKeyPress="return validVal(event, /[0-9.]/);" /> %</td>
                    </tr>
                    <tr>
                        <td class="label">Annual Fee:</td>
                        <td><input type="text" name="user_annual_fee" id="user_annual_fee" size="7" maxlength="7" onKeyPress="return validVal(event, /[0-9.]/);" /> $</td>
                    </tr>
                    <tr>
                        <td class="formSectionHeader" colspan="3">Tell us how you use your card</td>
                    </tr>
                    <tr>
                        <td class="label">Amount you currently owe:</td>
                        <td colspan="2"><input type="text" name="user_principle" size="7" maxlength="7" onKeyPress="return validVal(event, /[0-9.]/);" /> $</td>
                    </tr>
                    <tr>
                        <td class="label">Estimated monthly charges:</td>
                        <td colspan="2"><input type="text" name="user_monthly_charges" size="7" maxlength="7" onKeyPress="return validVal(event, /[0-9.]/);" /> $</td>
                    </tr>
                    <tr>
                        <td class="label">Amount you pay off each month:</td>
                        <td colspan="2"><input type="text" name="user_payment" size="7" maxlength="7" onKeyPress="return validVal(event, /[0-9.]/);" /> $</td>
                    </tr>
                    <tr>
                        <td class="formSectionHeader" colspan="3">Tell us about your credit (optional)</td>
                    </tr>
                    <tr>
                        <td class="label">Your credit quality:</td>
                        <td colspan="2">
                            <select name="user_quality">
                                <option value=""> -- Select one -- (optional)</option>
                                <option value="excellent">Excellent credit</option>
                                <option value="good">Good credit</option>
                                <option value="fair">Fair credit</option>
                                <option value="bad">Bad credit</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="formNote">Note: Indicating your credit quality helps us list only cards that match your credit profile.</td>
                    </tr>
                </table>

                <div style="padding-left: 198px; *padding-left: 215px; margin-top: 15px; width:100px; float:left">
                    <input type="image" name="submit" src="/images/btn_run_checkup.png">

                </div>


<div style="text-align: right; margin-top: 17px;">
<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcheckup%2F&amp;layout=standard&amp;show_faces=false&amp;width=300&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe></div>

                 <p style="float:right;">Comments? Suggestions? <a href="/site-feedback.php">Drop us a note</a>.</p>

                <input type="hidden" name="card_image" id="card_image" value="" />
                <input type="hidden" name="marketable" id="marketable" value="" />
                </form>

                <div class="credit-card-details" style="padding: 30px 0; clear:both">
                    Interactive tools are made available to you as self-help tools for your independent use, and are not intended to provide financial advice. We cannot and do not guarantee their accuracy in regard to your individual circumstances. Reasonable efforts are made to maintain accurate information. However all credit card information is presented without warranty.
                </div>


            </div><!-- pageContentArea -->

        </td>
    </tr>
</table>


<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/footer.php"; ?>


<?
echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";
?>
<!-- Adobe Marketing Cloud Tag Loader Code
Copyright 1996-2013 Adobe, Inc. All Rights Reserved
More info available at http://www.adobe.com/solutions/digital-marketing.html -->
<script type="text/javascript">//<![CDATA[
var amc=amc||{};if(!amc.on){amc.on=amc.call=function(){}};
document.write("<scr"+"ipt type=\"text/javascript\" src=\"//www.adobetag.com/d1/v2/ZDEtY3JlZGl0Y2FyZHNjb20tNTY5NS0yMTg0/amc.js\"></sc"+"ript>");
//]]></script>
<!-- End Adobe Marketing Cloud Tag Loader Code -->
<script language="JavaScript" type="text/javascript">
/* You may give each page an identifying name, server, and channel on
the next lines. */
s.pageName="tools:checkup"
s.server=""
s.channel="tools"
s.pageType=""
s.prop1="tools:checkup"
s.prop2=""
s.prop3=""
s.prop4=""
s.prop5=""
s.prop6=""
s.prop7=""
s.prop8="checkup"
/* Conversion Variables */
s.campaign="<?= isset($_SESSION['aid']) ? $_SESSION['aid'] : 0;?>-<?= isset($_SESSION['banner_id']) ? $_SESSION['banner_id'] : 0;?>-<?= isset($_SESSION['cid']) ? $_SESSION['cid'] : 0;?>-<?= isset($_SESSION['did']) ? $_SESSION['did'] : 0;?>"
s.state=""
s.zip=""
s.events=""
s.products=""
s.purchaseID=""
s.eVar1=""
s.eVar2=""
s.eVar3=""
s.eVar4=""
s.eVar5=""
s.eVar6=""
s.eVar7=""
s.eVar8=""
s.eVar9=""
s.eVar10=""
s.eVar11=""
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript" type="text/javascript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><img src="http://creditcardscom.112.2o7.net/b/ss/ccardsccdc-us/1/H.25--NS/0"
height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.25. -->

</div> <!-- skeleton -->
</body>
</html>
