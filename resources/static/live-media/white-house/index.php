<?
include_once('../../actions/pageInit.php');
$_SESSION['fid'] = "1540";
include_once('../../actions/trackers.php');

define('DB_POST_URL', 'http://whitehouse.creditcards.com/submit_question.php');

//$pageMode = "0";
//$pageMode = "1";
$pageMode = "2";

//$activateInteractivePage = 1;
//$activateInteractivePage = $_GET['live'];

$currentTime = mktime();
$liveTime = mktime(13, 0, 0, 2, 22, 2010);

$errorFlags = array();
$errorMessages = array();

$curlError = false;
$curlComplete = false;

if(isset($_POST['validate'])) {
	
	//error if no question
	if(!isset($_POST['question']) || ($_POST['question'] == '')) {
		$errorFlags['question'] = true;
		$errorMessages['question'] = "Error: Please enter a question below";
	}
	
	if(!verifyCaptcha( $_POST )) {
		$errorFlags['captcha'] = true;
        $errorMessages['captcha'] = "Error: Validation Code is incorrect";
	}
	
	$_POST['name'] = str_replace("'","",$_POST['name']);
	$_POST['question'] = str_replace("'","",$_POST['question']);
	
	if( count($errorFlags) == 0 ) {
		//curl call
		$ch = curl_init(DB_POST_URL);

		// Execute
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
		
		// Check if any error occured
		if(curl_exec($ch) === false) {
		    
		    $curlError = true;
		    $curlMessage = "Due to the high volume of questions being submitted, we were unable to submit your question. Please try again.";
			
		} else {
		    $curlComplete = true;
		}

		// Close handle
		curl_close($ch); 
	}
}

function verifyCaptcha( $params ) {

    $captchaText = $_SESSION[ 'CAPTCHAString' ];
    $userEntry = $params[ 'captcha_entry' ];

    if ( $userEntry !== $captchaText )
        return false;
    else
        return true;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>White House Online Town Hall � Credit Card Reform - hosted by CreditCards.com</title>

<meta name="keywords" content="credit card reform, new credit card laws, 2010 credit card laws, White House town hall">
<meta name="description" content="Participate in the White House online town hall hosted by CreditCards.com. Discussions will center on the 2010 CARD Act and how changes in the new credit card laws will affect U.S. consumer cardholders. This is your chance to ask the White House your credit card reform related questions in an online Q&A event.">

<meta name="Robots" content="ALL">
<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta http-equiv="Pragma" content="no-cache">
<meta name="author" content="CreditCards.com">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
<link rel="stylesheet" href="/css/credit-cards.css" type="text/css">
<script src="/javascript/application.js"></script>

<link rel='stylesheet' id='sexy-bookmarks-css' href='/live-media/white-house/sexy-bookmarks.css?ver=2.6.1.3' type='text/css' media='all' />
<script type="text/javascript" language="javascript" src="/live-media/white-house/global.js"></script>

<link rel="stylesheet" type="text/css" href="/live-media/white-house/style.css" />
<?php

if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsHeaderScript.php'); }
?>

</head>
<body>

<div id="wrapper">

    <table id="site-header" cellspacing="0" cellpadding="0">
        <tr>
            <td class="arch-logo left"><a href="http://www.creditcards.com" target="_blank"><img src="/live-media/images/creditcards.gif" border="0" alt="CreditCards.com" /></a></td>
            <td align="center"><img src="/live-media/images/credit-card-reform.jpg" border="0" alt="Ask The White House" /></td>
            <td class="arch-logo right"><a href="http://www.whitehouse.gov" target="_blank"><img src="/live-media/images/the-white-house.jpg" border="0" alt="Ask The White House" /></a></td>
        </tr>
    </table>
    
    <?
    //pre and during nav
    if($pageMode < 2 ) {
    ?>
    <table id="top-nav" cellspacing="0" cellpadding="0">
        <tr>
            <td class="divider"></td>
            <td><a href="javascript:;" onclick="javascript:window.open('faq.php', 'faq', 'width=437,height=422,scrollbars=1');">FAQ</a></td>
            <td class="divider"></td>
            <td><a href="javascript:;" onclick="javascript:window.open('reminder.php', 'reminder', 'width=437,height=622,scrollbars=1');">Set Reminder</a></td>
            <td class="divider"></td>
            <td><a href="javascript:;" onclick="javascript:inviteFriend();">Invite a Friend</a></td>
            <td class="divider"></td>
            <td><a href="http://www.whitehouse.gov" target="_blank">Visit WhiteHouse.gov</a></td>
            <td class="divider"></td>
            <td><a href="http://www.creditcards.com" target="_blank">Visit CreditCards.com</a></td>
            <td class="divider"></td>
        </tr>
    </table>
    <?
    } else { 
    //post event nav
    ?>
    <table id="top-nav" cellspacing="0" cellpadding="0">
        <tr>
            <td class="divider"></td>
            <td><a href="javascript:;" onclick="javascript:window.open('faq.php', 'faq', 'width=437,height=422,scrollbars=1');">FAQ</a></td>
            <td class="divider"></td>
            <td><a href="/reform" target="_blank">More On Reform</a></td>
            <td class="divider"></td>
            <td><a href="/credit-card-news/credit-card-videos-1264.php" target="_blank">More Videos</a></td>
            <td class="divider"></td>
            <td><a href="/credit-card-news.php" target="_blank">More News</a></td>
            <td class="divider"></td>
            <td><a href="http://www.whitehouse.gov" target="_blank">Visit WhiteHouse.gov</a></td>
            <td class="divider"></td>
            <td><a href="http://www.creditcards.com" target="_blank">Visit CreditCards.com</a></td>
            <td class="divider"></td>
        </tr>
    </table>
    <? } ?>
    
    <div id="content">

<?
//pre and during nav
if($pageMode == 0 ) {
?>    
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="left-column">
                    
                    <div id="video-feed-alternate">
                        
                        <img src="/live-media/images/white-house-town-hall-post.jpg" />
                        
                        <? if($curlComplete) { ?>
                        <div id="submit-success">
                            <span class="error">Your question has been submitted.</span>
                            <br />
                            <br />
                            <a href="index.php">Submit another question</a>
                        </div>
                        <? } ?>
                        
                        <form action="" method="post" id="question-form">
                        <table cellspacing="5" style="margin-top: 25px;">
                            <tr>
                                <td class="label">Name:</td>
                                <td><input type="text" name="name" style="width: 200px;" value="<?=(isset($_POST['validate']) ? $_POST['name'] : '') ?>" /></td>
                            </tr>
                            <tr>
                                <td class="label">State:</td>
                                <td>
                                    <select name="state" id="state_select">
                                        <option value="">-- select state --</option>
                                        <option value="Alabama">Alabama</option>
										<option value="Alaska">Alaska</option>
										<option value="Arizona">Arizona</option>
										<option value="Arkansas">Arkansas</option>
										<option value="California">California</option>
										<option value="Colorado">Colorado</option>
										<option value="Connecticut">Connecticut</option>
										<option value="Delaware">Delaware</option>
										<option value="District Of Columbia">District Of Columbia</option>
										<option value="Florida">Florida</option>
										<option value="Georgia">Georgia</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Idaho">Idaho</option>
										<option value="Illinois">Illinois</option>
										<option value="Indiana">Indiana</option>
										<option value="Iowa">Iowa</option>
										<option value="Kansas">Kansas</option>
										<option value="Kentucky">Kentucky</option>
										<option value="Louisiana">Louisiana</option>
										<option value="Maine">Maine</option>
										<option value="Maryland">Maryland</option>
										<option value="Massachusetts">Massachusetts</option>
										<option value="Michigan">Michigan</option>
										<option value="Minnesota">Minnesota</option>
										<option value="Mississippi">Mississippi</option>
										<option value="Missouri">Missouri</option>
										<option value="Montana">Montana</option>
										<option value="Nebraska">Nebraska</option>
										<option value="Nevada">Nevada</option>
										<option value="New Hampshire">New Hampshire</option>
										<option value="New Jersey">New Jersey</option>
										<option value="New Mexico">New Mexico</option>
										<option value="New York">New York</option>
										<option value="North Carolina">North Carolina</option>
										<option value="North Dakota">North Dakota</option>
										<option value="Ohio">Ohio</option>
										<option value="Oklahoma">Oklahoma</option>
										<option value="Oregon">Oregon</option>
										<option value="Pennsylvania">Pennsylvania</option>
										<option value="Rhode Island">Rhode Island</option>
										<option value="South Carolina">South Carolina</option>
										<option value="South Dakota">South Dakota</option>
										<option value="Tennessee">Tennessee</option>
										<option value="Texas">Texas</option>
										<option value="Utah">Utah</option>
										<option value="Vermont">Vermont</option>
										<option value="Virginia">Virginia</option>
										<option value="Washington">Washington</option>
										<option value="West Virginia">West Virginia</option>
										<option value="Wisconsin">Wisconsin</option>
										<option value="Wyoming">Wyoming</option>
										<option value="Puerto Rico">Puerto Rico</option>
										<option value="Virgin Islands">Virgin Islands</option>
										<option value="Northern Mariana Islands">Northern Mariana Islands</option>
										<option value="Marshall Islands">Marshall Islands</option>
										<option value="Guam">Guam</option>
										<option value="American Samoa">American Samoa</option>
										<option value="Palau">Palau</option>
										<option value="Micronesia">Micronesia</option>
                                    </select>
                                </td>
                            </tr>
                            
                            <? if($errorFlags['question']) { ?>
                            <tr>
                                <td colspan="2" align="center"><span class="error"><?=$errorMessages['question'] ?></span><br /></td>
                            </tr>
                            <? } ?>
                            
                            <tr>
                                <td class="label">Ask your question:</td>
                                <td><textarea name="question" style="width: 250px; height: 100px;"><?=(isset($_POST['validate']) ? $_POST['question'] : '') ?></textarea></td>
                            </tr>
                            
                            <? if($errorFlags['captcha']) { ?>
                            <tr>
                                <td colspan="2" align="center"><span class="error"><?=$errorMessages['captcha'] ?></span><br /></td>
                            </tr>
                            <? } ?>
                            
                            <tr>
                                <td class="label">Verification Code:</td>
                                <td valign="top"><input type="text" name="captcha_entry" size="7"> <img style="padding-left: 10px;" src="/lib/captcha/captcha.php" align="top" /></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="padding-top: 10px;"><input type="image" name="submit" src="/live-media/images/btn-submit.gif" /></td>
                            </tr>
                        </table>
                        
                        <input type="hidden" name="validate" value="1" />
                        </form>
                        
                    </div><!-- video-feed-alternate -->
                    
                    <br clear="all" />                    
                    
                </td>
                <td class="right-column">
                     
                    <div id="countdown">
                        
                        <h2>
	                        Monday, February 22, 2010
	                        <br />
	                        <span style="font-size: 13px; color: #000;">2:00 EST / 1:00 CST</span>
	                    </h2>
                        
                        <div class="counter">
	                        
	                        <object height="65" width="200" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
							    <param value="200" name="width"/>
							    <param value="65" name="height"/>
							    <param value="/live-media/images/countdown-clock.swf" name="src"/>
							    <embed height="65" width="200" src="/live-media/images/countdown-clock.swf" type="application/x-shockwave-flash"/>
							</object>
	                        
	                    </div>
                    </div>
                    
                        <iframe src="http://www.facebook.com/widgets/livefeed.php?app_id=304166609331&width=310&height=500" width="310" height="500" marginwidth="0" scrolling="no" frameborder="0" id="facebookiframe"></iframe>
                    
                </td>
            </tr>
        </table>

<? } else if( $pageMode == 1 ) { ?>
        
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="left-column">
                    
                    <div id="video-feed">
                        
                        <div id="video-object">
                            <object width="415" height="260">
                            <param name="movie" value="http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf"></param>
                            <param name="allowScriptAccess" value="always"></param>
                            <param name="wmode" value="opaque"></param>
                            <param name="bgcolor" value="#FFFFFF"></param>
                            <param name="scale" value="showall"></param>
                            <param name="quality" value="best"></param>
                            <param name="align" value="l"></param>
                            <param name="allowfullscreen" value="true"></param>
                            <param name="play" value="false"></param>
                            <param name="menu" value="false"></param>
                            <param name="loop" value="false"></param>
                            <param name="flashvars" value="player=http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf&src=rtmp://cp68969.live.edgefcs.net/live/WHLive1@4853&scaleMode=stretch&link=&path_to_image=http://www.whitehouse.gov/sites/default/themes/whitehouse/img/facebook_bubble.gif&width=415&height=260"></param>
                            <embed src="http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" menu="false" width="415" height="260" flashvars="player=http://www.whitehouse.gov/sites/default/modules/wh_multimedia/EOP_OVP_player.swf&src=rtmp://cp68969.live.edgefcs.net/live/WHLive1@4853&scaleMode=stretch&link=&path_to_image=http://www.whitehouse.gov/sites/default/themes/whitehouse/img/facebook_bubble.gif&width=415&height=260"></embed>
                            </object>
                        </div>
                        
                        <div style="text-align: right; font-size: 10px; padding-top: 4px;"><a href="javascript:;" onclick="javascript:launchViewer();">Launch Small Video Player</a></div>
                        <br clear="all" />
                    </div>
                    
                    <br clear="all" />                    
                    
                    <div id="during-event-rules">
                        <span class="title">How the hall works</span>
                        <ul>
                            <li>Submit your question in the box to the right, or via Twitter (hashtag #cardlaw)</li>
                            <li>Watch the live video stream above to see if White House economic adviser Austan Goolsbee answers your question</li>
                            <li>Your questions and comments, along with those of other readers, will appear in the window on the right</li>
                            <li>Moderator will post as many comments/questions as possible, but makes no guarantees that yours will appear</li>
                            <li>Keep it respectful. All questions are welcome; abusive or foul language is not.</li>
                        </ul>
                        <br clear="all" />
                    </div>
                    
                    <div id="during-event-description">
                        <img src="/live-media/images/white-house-town-hall.jpg" />
                    </div>
                    
                    <br clear="all" />
                    
                </td>
                <td class="right-column">
                     
                    <? if($currentTime < $liveTime) { ?>
                    <div id="countdown">
                        
                        <h2>
                            Monday, February 22, 2010
                            <br />
                            <span style="font-size: 13px; color: #000;">2:00 EST / 1:00 CST</span>
                        </h2>
                        
                        <div class="counter">
                            
                            <object height="65" width="200" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
                                <param value="200" name="width"/>
                                <param value="65" name="height"/>
                                <param value="/live-media/images/countdown-clock.swf" name="src"/>
                                <embed height="65" width="200" src="/live-media/images/countdown-clock.swf" type="application/x-shockwave-flash"/>
                            </object>
                            
                        </div>
                    </div>
                    <? } ?>
                    
                    <div id="chat-window">
                        <iframe src="http://www.coveritlive.com/index2.php/option=com_altcaster/task=viewaltcast/altcast_code=47aa4cfccf/height=550/width=300" scrolling="no" height="550px" width="300px" frameBorder="0" id="coveritliveiframe"><a href="http://www.coveritlive.com/mobile.php/option=com_mobile/task=viewaltcast/altcast_code=47aa4cfccf" >Credit Card Reform - An Online Town Hall Event</a></iframe>
                    </div>
                    
                </td>
            </tr>
        </table>
        
<? } else { ?>
        
        <center><object width="640" height="385"><param name="movie" value="http://www.youtube.com/v/hDYMMbgm8R8&hl=en_US&fs=1&showinfo=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/hDYMMbgm8R8&hl=en_US&fs=1&showinfo=0&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="385"></embed></object></center>
        
        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
            <tr>
                <td class="left-column">
                    
                    <img src="/live-media/images/town-hall-copy-post.jpg" style="border: 4px solid #000;" alt="Live Town Hall Event with the White House" />
                    
                    <p style="padding: 15px 8px; font-size: 14px;">
                        On Feb. 22, 2010, the White House and CreditCards.com readers met in an online town hall, in which economic adviser Austan Goolsbee (top left) answered questions from the White House asked by CreditCards.com readers, as relayed by White House Director of Online Operations Jesse Lee. The event is over, but you can read the <a href="/credit-card-news/white-house-town-hall-credit-card-reform-transcript.php">transcript</a> of the conversation, and see complete coverage of the <a href="/reform">Credit CARD Act</a>.
                    </p>
                    
                </td>
                <td class="right-column">
                    
                    <div id="chat-window">
                        <iframe src="http://www.coveritlive.com/index2.php/option=com_altcaster/task=viewaltcast/altcast_code=47aa4cfccf/height=550/width=300" scrolling="no" height="550px" width="300px" frameBorder="0" id="coveritliveiframe"><a href="http://www.coveritlive.com/mobile.php/option=com_mobile/task=viewaltcast/altcast_code=47aa4cfccf" >Credit Card Reform - An Online Town Hall Event</a></iframe>
                    </div>
                    
                </td>
            </tr>
        </table>
        
<? } ?>
        <table width="100%">
            <tr>
                <td valign="bottom" style="font-size: 14px; font-weight: bold;">Share:</td>
                <td>
                    <div class="sexy-bookmarks sexy-bookmarks-expand sexy-bookmarks-bg-wealth">
			            <ul class="socials">
			                    <li class="sexy-twitter">
			                        <a target="_blank" href="http://twitter.com/home?status=Credit+Card+Reform+Town+Hall+with+The+White+House+-+http://www.creditcards.com/askthewhitehouse" rel="nofollow" class="external" title="Tweet This!">Tweet This!</a>
			                    </li>
			                    <li class="sexy-facebook">
			                        <a target="_blank" href="http://www.facebook.com/share.php?v=4&amp;src=bm&amp;u=http://www.creditcards.com/askthewhitehouse&amp;t=Credit+Card+Reform+Town+Hall+with+The+White+House" rel="nofollow" class="external" title="Share this on Facebook">Share this on Facebook</a>
			                    </li>
			                    <li class="sexy-stumbleupon">
			                        <a target="_blank" href="http://www.stumbleupon.com/submit?url=http://www.creditcards.com/askthewhitehouse&amp;title=Credit+Card+Reform+Town+Hall+with+The+White+House" rel="nofollow" class="external" title="Share this on StumbleUpon">Share this on StumbleUpon</a>
			                    </li>
			                    <li class="sexy-delicious">
			                        <a target="_blank" href="http://del.icio.us/post?url=http://www.creditcards.com/askthewhitehouse&amp;title=Credit+Card+Reform+Town+Hall+with+The+White+House" rel="nofollow" class="external" title="Share this on del.icio.us">Share this on del.icio.us</a>
			                    </li>
			                    <li class="sexy-friendfeed">
			                        <a target="_blank" href="http://www.friendfeed.com/share?title=Credit+Card+Reform+Town+Hall+with+The+White+House&amp;link=http://www.creditcards.com/askthewhitehouse" rel="nofollow" class="external" title="Share this on FriendFeed">Share this on FriendFeed</a>
			                    </li>
			                    <li class="sexy-squidoo">
			                        <a target="_blank" href="http://www.squidoo.com/lensmaster/bookmark?http://www.creditcards.com/askthewhitehouse" rel="nofollow" class="external" title="Add to a lense on Squidoo">Add to a lense on Squidoo</a>
			                    </li>
			                    <li class="sexy-comfeed">
			                        <a target="_blank" href="/rss-feed-credit-card-news-headlines.php" rel="nofollow" class="external" title="RSS News Feed">RSS News Feed</a>
			                    </li>
			                    <li class="sexy-mail">
			                        <a href="javascript:;" onclick="javascript:inviteFriend();" rel="nofollow" class="external" title="Email this page to a friend">Email this page to a friend</a>
			                    </li>
			            </ul>
			            <div style="clear:both;"></div>
			        </div>
                </td>
                <td valign="bottom" align="right">
                    <a href="/newsletter.php" target="_blank">Subscribe to Newsletter</a>
                    <br />
                    <br />
                    <div class="actionIcon" onclick="javascript:toggleTip(this);">
                        <img src="/images/icn_link.gif" align="absmiddle"> <a href="javascript:;">Link to this page</a>
                    </div>
                    <div style="position:absolute;">
                        <div id="linkCodeDiv" style="position:relative; top:-110px; *left:-200px; left:-200px; display: none;"><textarea readonly onclick="javascript:this.focus(); this.select();"; style="width:400px; height:75px; background-color:#fff; border: 2px solid #ccc;"><a href="http://www.creditcards.com/askthewhitehouse">White House Online Town Hall - Credit Card Reform</a></textarea></div>
                    </div>
                </td>
            </tr>
        </table>
        
        
        
    </div>
    
    <div id="footer">
	    &copy; Copyright <?= date('Y') ?> Credit Cards.com. All Rights Reserved. <a href="/terms.php" target="_blank"> Terms of Use</a>
	</div>
    
</div>

<?php

echo "<IMG SRC='".$GLOBALS['RootPath']."sb.php?a_aid=".$_SESSION['aid']."&a_bid=".$_SESSION['hid']."' border=0 width=1 height=1>\n";
echo "<IMG SRC='".$GLOBALS['RootPath']."xtrack.php?".$_SERVER['QUERY_STRING']."' border=0 width=1 height=1>";

$channel = 'news';
$pageName = 'news:ask-the-white-house';
$analyticsServer = '';
$pageType = '';
$prop1 = 'ask-the-white-house';
$prop2 = '';
$prop3 = '';
$prop4 = '';
$prop5 = '';
$prop6 = '';
$prop7 = '';
$prop8 = '';
$prop16 = '';
$analyticsState = '';
$analyticsZip = '';
$analyticsEvents = '';
$analyticsProducts = '';
$purchaseId = '';
$eVar1 = '';
$eVar2 = '';
$eVar3 = '';
$eVar4 = '';
$eVar5 = '';
$eVar6 = '';
$eVar7 = '';
$eVar8 = '';
$eVar9 = '';
$eVar10 = '';
$eVar11 = '';
if (DTM_ANALYTICS_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/analyticsFooterScript.php'); }
if (SITE_CATALYST_ENABLED) { include_once($_SERVER['DOCUMENT_ROOT'].'/inc/legacyAnalyticsScript.php'); }
?>


</div> <!-- skeleton -->

<? if(isset($_POST['validate'])) { ?>
<script type="text/javascript">
document.getElementById('state_select').value = '<?=$_POST['state'] ?>';
</script>
<? } ?>

</body>
</html>
