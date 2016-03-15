<?
include_once('../../actions/pageInit.php');
$_SESSION['fid'] = "1567";
include_once('../../actions/trackers.php');

define('DB_POST_URL', 'http://experian.creditcards.com/submit_question.php');

//$pageMode = $_GET['mode'];
//
//if(!isset($_GET['mode']))
//    $pageMode = 0;

//pre town hall
//$pageMode = "0";

//day of town hall
//$pageMode = "1";

//post town hall
$pageMode = "2";

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
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

<title>Credit reports and credit scores with Experian - Ask about credit - Hosted by CreditCards.com</title>

<meta name="description" content="Experian answers questions about credit scores and credit reports in an online town hall hosted by CreditCards.com. This is your chance to ask Experian your credit score related questions in an online Q&A event.">

<meta name="Robots" content="ALL">
<meta name="revisit-after" content="10 days">
<meta name="resource-type" content="document">
<meta name="distribution" content="global">
<meta http-equiv="Pragma" content="no-cache">
<meta name="author" content="CreditCards.com">
<meta name="copyright" content="Copyright <? echo date("Y"); ?> CreditCards.com">
<link rel="stylesheet" href="/css/credit-cards.css" type="text/css">
<script src="/javascript/application.js"></script>

<link rel='stylesheet' id='sexy-bookmarks-css' href='/live-media/experian/sexy-bookmarks.css?ver=2.6.1.3' type='text/css' media='all' />
<script type="text/javascript" language="javascript" src="/live-media/experian/global.js"></script>

<link rel="stylesheet" type="text/css" href="/live-media/experian/style.css" />

</head>
<body>

<div id="wrapper">

    <table id="site-header" cellspacing="0" cellpadding="0">
        <tr>
            <td class="arch-logo left"><a href="http://www.creditcards.com" target="_blank"><img src="/images/cclogo_165x63.png" border="0" alt="CreditCards.com" /></a></td>
            <td align="center"><img src="/live-media/images/header-transparent.png" border="0" alt="Ask About Credit" /></td>
            <td class="arch-logo right"><a href="http://www.experian.com" target="_blank"><img src="/live-media/images/experian-logo.png" border="0" alt="Experian, A world of insight" /></a></td>
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
            <td><a href="/credit-card-news/credit-card-videos-1264.php" target="_blank">More Videos</a></td>
            <td class="divider"></td>
            <td><a href="/credit-card-news.php" target="_blank">More News</a></td>
            <td class="divider"></td>
            <td><a href="http://www.creditcards.com" target="_blank">Visit CreditCards.com</a></td>
            <td class="divider"></td>
            <td><a href="http://www.experian.com" target="_blank">Visit Experian</a></td>
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
            <td><a href="/credit-card-news/credit-card-videos-1264.php" target="_blank">More Videos</a></td>
            <td class="divider"></td>
            <td><a href="/credit-card-news.php" target="_blank">More News</a></td>
            <td class="divider"></td>
            <td><a href="http://www.creditcards.com" target="_blank">Visit CreditCards.com</a></td>
            <td class="divider"></td>
            <td><a href="http://www.experian.com" target="_blank">Visit Experian</a></td>
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
                        
                        <h1>Video town hall on credit reports, scores</h1>

                        Get answers from one of the big three credit reporting companies!
                        <br clear="all" />

                        <div style="background-color: #000; float: right; padding: 5px; margin-top: 10px; width: 160px;">
                            <center><img src="/live-media/images/rod-griffin-150.jpg" /></center>

                            <div style="background-color: #000; color: #fff; padding: 5px 5px 0 5px;">
                                <strong>Rod Griffin, Director of Public Education, Experian</strong>
                            </div>
                        </div>

                        <p><strong>On Thursday, May 6, at 2 p.m. Eastern time</strong>, Experian's director of public education, <a href="javascript:;" onclick="javascript:window.open('faq.php#griffin', 'faq', 'width=437,height=422,scrollbars=1');">Rod Griffin</a>, will answer consumer questions about credit reporting and scoring.</p>
                        <p>Experian is one of the nation's three major credit reporting companies. We at CreditCards.com are soliciting your questions about credit scores and reports for him to answer during our live, interactive video town hall.</p>

                        <p>How can you submit a question?
                        
                            <UL style="margin-left: 0; padding-left: 20px;">
                                <LI><strong>Facebook:</strong> Use the box on this page</LI>
                                <LI><strong>Twitter:</strong> Use the hashtag #askexperian</LI>
                                <LI><strong><A HREF="#form">Use the form on this page</A></strong></LI>
                            </UL>

                            <p>You can also submit questions for Griffin LIVE during the event. We can't guarantee he'll answer your question, but we'll try to get through as many as we can.</p>
                            <p>Send us your questions now!</p>
                        </p>

                        <? if($curlComplete) { ?>
                        <div id="submit-success">
                            <span class="error">Your question has been submitted.</span>
                            <br />
                            <br />
                            <a href="index.php">Submit another question</a>
                        </div>

                        <? } else { ?>

                        <a name="form"></a>
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
                                <td class="label">Verification code:</td>
                                <td valign="top"><input type="text" name="captcha_entry" size="7"> <img style="padding-left: 10px;" src="/lib/captcha/captcha.php" align="top" /></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td style="padding-top: 10px;"><input type="image" name="submit" src="/live-media/images/btn-submit.gif" /></td>
                            </tr>
                        </table>
                        
                        <input type="hidden" name="validate" value="1" />
                        </form>

                        <? } ?>
                    </div><!-- video-feed-alternate -->
                    
                    <br clear="all" />                    
                    
                </td>
                <td class="right-column">
                     
                    <div id="countdown">
                        
                        <h2>
	                        Thursday, May 6, 2010
	                        <br />
	                        <span style="font-size: 13px; color: #000;">2 p.m. EST / 11 a.m. PST</span>
	                    </h2>
                        <!--
                        <div class="counter">
	                        
	                        <object height="65" width="200" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
                                    <param value="200" name="width"/>
                                    <param value="65" name="height"/>
                                    <param value="/live-media/experian/countdown-clock-experian.swf" name="src"/>
                                    <embed height="65" width="200" src="/live-media/experian/countdown-clock-experian.swf" type="application/x-shockwave-flash"/>
                                </object>
	                        
	                    </div>
                        -->
                    </div>

                    <!--
                    <script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
                    <fb:comments></fb:comments>
                    
                    <script type="text/javascript">
                    FB.init("395ee2590fa24b41f42a49785ef13d4b", "/xd_receiver.htm");
                    </script>
                    -->

                    <iframe src="http://www.facebook.com/widgets/livefeed.php?app_id=304166609331&width=310&height=623" width="310" height="623" marginwidth="0" scrolling="no" frameborder="0" id="facebookiframe"></iframe>
                    
                </td>
            </tr>
        </table>

<? } else if( $pageMode == 1 ) { ?>
        
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td class="left-column">
                    
                    <div id="video-feed">
                        
                        <div id="video-object">
                            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" id="utv280728" width="400" height="325">
                                <param name="id" value="utv280728" />
                                <param name="width" value="400" />
                                <param name="height" value="325" />
                                <param name="flashvars" value="autoplay=false&amp;brand=embed&amp;cid=10297%2Fask-experian--interactive-town&amp;locale=en_US" />
                                <param name="allowfullscreen" value="true" />
                                <param name="allowscriptaccess" value="always" />
                                <param name="src" value="http://www.ustream.tv/flash/live/10297/ask-experian--interactive-town" />
                                <embed type="application/x-shockwave-flash" id="utv280728" width="400" height="325" flashvars="autoplay=false&amp;brand=embed&amp;cid=10297%2Fask-experian--interactive-town&amp;locale=en_US" allowfullscreen="true" allowscriptaccess="always" src="http://www.ustream.tv/flash/live/10297/ask-experian--interactive-town"></embed>
                            </object>
                        </div>
                        
                        <div style="text-align: right; font-size: 10px; padding-top: 4px;"><a href="javascript:;" onclick="javascript:launchViewer();">Launch Small Video Player</a></div>
                        <br clear="all" />
                    </div>
                    
                    <br clear="all" />
                    
                    <div id="during-event-rules" style="margin-top: 45px; *margin-top: 75px;">
                        <span class="title">How it works</span>
                        <ul>
                            <li>Submit your question in the box to the right, or via Twitter (hashtag #askexperian)</li>
                            <li>Watch the live video stream above to see if Experian director of public education Rod Griffin answers your question</li>
                            <li>Your questions and comments, along with those of other readers, will appear in the window on the right</li>
                            <li>Moderator will post as many comments/questions as possible, but makes no guarantees that yours will appear</li>
                            <li>Keep it respectful. All questions are welcome; abusive or foul language is not.</li>
                        </ul>
                        <br clear="all" />
                    </div>
                    
                    <div id="during-event-description" style="*height: 310px;">

                        <h1>Video town hall on credit reports, scores</h1>

                        Get answers from one of the big three credit reporting companies!
                        <br clear="all" />

                        <div style="background-color: #000; float: right; padding: 5px; margin-top: 10px; width: 160px;">
                            <center><img src="/live-media/images/rod-griffin-150.jpg" /></center>

                            <div style="background-color: #000; color: #fff; padding: 5px 5px 0 5px;">
                                <strong>Rod Griffin, Director of Public Education, Experian</strong>
                            </div>
                        </div>

                        <p><strong>On Thursday, May 6, at 2 p.m. Eastern time</strong>, Experian's director of public education, <a href="javascript:;" onclick="javascript:window.open('faq.php#griffin', 'faq', 'width=437,height=422,scrollbars=1');">Rod Griffin</a>, will answer consumer questions about credit reporting and scoring.</p>
                        <p>Experian is one of the nation's three major credit reporting companies. We at CreditCards.com are soliciting your questions about credit scores and reports for him to answer during our live, interactive video town hall.</p>

                        <br clear="all" />

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
                        <iframe src="http://www.coveritlive.com/index2.php/option=com_altcaster/task=viewaltcast/altcast_code=08601ff9e3/height=623/width=310" scrolling="no" height="623px" width="310px" frameBorder="0">http://www.coveritlive.com/mobile.php/option=com_mobile/task=viewaltcast/altcast_code=08601ff9e3</iframe>
                    </div>
                    
                </td>
            </tr>
        </table>
        
<?
} else {
    //post town hall page
?>
        
        <center>
            <object width="500" height="375"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id=11622005&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id=11622005&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="500" height="375"></embed></object>

            <br />
            <br />

            <A HREF="/credit-card-news/experian-credit-scoring-reporting-qa-transcript-part-one-1270.php">Prefer shorter clips? Watch the above video in six parts</A> | <A HREF="/credit-card-news/assets/experian-event.pdf">Read complete transcript (PDF)</A>
        </center>
        
        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
            <tr>
                <td class="left-column">

                    <div id="during-event-description" style="*height: 410px; margin-top: 0;">
                        <h1>Video town hall on credit reports, scores</h1>

                        Get answers from one of the big three credit reporting companies!
                        <br clear="all" />

                        <div style="background-color: #000; float: right; padding: 5px; margin-left: 5px; margin-top: 10px; width: 160px;">
                            <center><img src="/live-media/images/rod-griffin-150.jpg" /></center>

                            <div style="background-color: #000; color: #fff; padding: 5px 5px 0 5px;">
                                <strong>Rod Griffin, Director of Public Education, Experian</strong>
                            </div>
                        </div>
                        
                        <p>On Thursday, May 6, Experian director of public education Rod Griffin answered your questions on credit scoring and credit reporting live via a video stream from the CreditCards.com studio in Austin, Texas.</p>
                        <p>If you missed it or just want to see it again, click on the video above to watch a replay of the video stream in its entirety. (<A HREF="/credit-card-news/experian-credit-scoring-reporting-qa-transcript-part-one-1270.php">Prefer shorter clips?  Click here to watch the above video in six parts</A>.) A <a HREF="/credit-card-news/assets/experian-event.pdf">complete transcript</A> of the event is also available.</p>
                        <p>In addition, you can see all the questions and comments that we posted from users in the window on the right side of this page.</p>
                        <p>Need more information on the topic? Check out the links at the bottom of the page to learn more.</p>

                    </div>

                    <br />
                    <br />
                    
                    <h2 style="text-align:left;">Learn more about credit scores and reports</h2>

                    <p>Learn more about this complex topic from Experian and CreditCards.com.
                        <ul>
                            <LI><A target="_blank" href="/credit-card-news/help/credit-report-credit-score-help-basics-6000.php">All about credit reports and scores</A> from Credit Cards.com</LI>
                            <LI><A target="_blank" href="http://www.experian.com/credit-education/credit-report-faqs.html">Credit reporting FAQ</A> from Experian.com</LI>
                            <LI><A target="_blank" href="http://www.experian.com/credit-education/credit-score-faqs.html">Credit scoring FAQ</A> from Experian.com</LI>
                        </ul>
                    </p>
                    
                </td>
                <td class="right-column">
                    
                    <div id="chat-window">
                        <iframe src="http://www.coveritlive.com/index2.php/option=com_altcaster/task=viewaltcast/altcast_code=08601ff9e3/height=623/width=310" scrolling="no" height="623px" width="310px" frameBorder="0">http://www.coveritlive.com/mobile.php/option=com_mobile/task=viewaltcast/altcast_code=08601ff9e3</iframe>
                    </div>
                    
                </td>
            </tr>
        </table>
        
<? } ?>
        
        <!--<h2 style="text-align:left;">Learn more about credit scores and reports</h2>
        
        <p>Can't wait for the event? Learn more about this complex topic from Experian and CreditCards.com.
            <ul>
                <LI><A target="_blank" href="/credit-card-news/help/credit-report-credit-score-help-basics-6000.php">All about credit reports and scores</A> from Credit Cards.com</LI>
                <LI><A target="_blank" href="http://www.experian.com/credit-education/credit-report-faqs.html">Credit reporting FAQ</A> from Experian.com</LI>
                <LI><A target="_blank" href="http://www.experian.com/credit-education/credit-score-faqs.html">Credit scoring FAQ</A> from Experian.com</LI>
            </ul>
        </p>
-->
        <table width="100%">
            <tr>
                <td valign="bottom" style="font-size: 14px; font-weight: bold;">Share:</td>
                <td>
                    <div class="sexy-bookmarks sexy-bookmarks-expand sexy-bookmarks-bg-wealth">
			            <ul class="socials">
			                    <li class="sexy-twitter">
			                        <a target="_blank" href="http://twitter.com/home?status=Credit+Report+Town+Hall+with+Experian+-+http://www.creditcards.com/askexperian" rel="nofollow" class="external" title="Tweet This!">Tweet This!</a>
			                    </li>
			                    <li class="sexy-facebook">
			                        <a target="_blank" href="http://www.facebook.com/share.php?v=4&amp;src=bm&amp;u=http://www.creditcards.com/askexperian&amp;t=Credit+Report+Town+Hall+with+Experian" rel="nofollow" class="external" title="Share this on Facebook">Share this on Facebook</a>
			                    </li>
			                    <li class="sexy-stumbleupon">
			                        <a target="_blank" href="http://www.stumbleupon.com/submit?url=http://www.creditcards.com/askexperian&amp;title=Credit+Report+Town+Hall+with+Experian" rel="nofollow" class="external" title="Share this on StumbleUpon">Share this on StumbleUpon</a>
			                    </li>
			                    <li class="sexy-delicious">
			                        <a target="_blank" href="http://del.icio.us/post?url=http://www.creditcards.com/askexperian&amp;title=Credit+Report+Town+Hall+with+Experian" rel="nofollow" class="external" title="Share this on del.icio.us">Share this on del.icio.us</a>
			                    </li>
			                    <li class="sexy-friendfeed">
			                        <a target="_blank" href="http://www.friendfeed.com/share?title=Credit+Report+Town+Hall+with+Experian&amp;link=http://www.creditcards.com/askexperian" rel="nofollow" class="external" title="Share this on FriendFeed">Share this on FriendFeed</a>
			                    </li>
			                    <li class="sexy-squidoo">
			                        <a target="_blank" href="http://www.squidoo.com/lensmaster/bookmark?http://www.creditcards.com/askexperian" rel="nofollow" class="external" title="Add to a lense on Squidoo">Add to a lense on Squidoo</a>
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
                        <div id="linkCodeDiv" style="position:relative; top:-110px; *left:-200px; left:-200px; display: none;"><textarea readonly onclick="javascript:this.focus(); this.select();"; style="width:400px; height:75px; background-color:#fff; border: 2px solid #ccc;"><a href="http://www.creditcards.com/askexperian">Experian Online Town Hall</a></textarea></div>
                    </div>
                </td>
            </tr>
        </table>
        
        
        
    </div>
    
    <div id="footer">
	    &copy; Copyright <?= date('Y') ?> Credit Cards.com. All Rights Reserved. <a href="/terms.php" target="_blank"> Terms of Use</a>
	</div>
    
</div>

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
s.pageName="news:ask-experian"
s.server=""
s.channel="news"
s.pageType=""
s.prop1="ask-experian"
s.prop2=""
s.prop3=""
s.prop4=""
s.prop5=""
s.prop6=""
s.prop7=""
s.prop8=""
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

<? if(isset($_POST['validate'])) { ?>
<script type="text/javascript">
document.getElementById('state_select').value = '<?=$_POST['state'] ?>';
</script>
<? } ?>

</body>
</html>