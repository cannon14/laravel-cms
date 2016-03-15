
<?php
/**
 * H1 1,2,3 content and partner banner.
 * Only show h1 in header if cardmatch enabled within actions/pageInit.php
 * When CardMatch enabled, H1 moves to this header area and when disabled, H1 moves down to banner location in content area.
 */
/*
if ($_SESSION['fid'] == "10") {

	//check for partner logos
	if (isset($_SESSION['aid'])) {

		switch($_SESSION['aid']) {
			case '1f9d6fba': $partnerContent = 'Thank you for visiting from:<br /><img vspace="2" src="/images/pageonce-logo.jpg" alt="PageOnce" border="0" />';
			break;

			case '128301': $partnerContent = '<img vspace="2" src="/images/learnvest.jpg" alt="In partnership with LearnVest" border="0" />';
			break;
		}
	}
	
	if (isset($partnerContent)) {
		echo $partnerContent;
	}
}
*/
?>
<a id="Page-Top"></a>
<div id="header-block">
<div class="container" id="top-logo-search">
    <div class="row">
        <div class="col-sm-8 col-md-8"><a href="/" class="logo-brand"><img src="/images/logo.png" width="243" height="43" alt="CreditCards.com"></a></div>
    </div>
</div>

<div class="navbar yamm navbar-main">
<div class="container">
<div class="navbar-header">
    <button type="button" data-toggle="collapse" data-target="#navbar-collapse-1" class="navbar-toggle"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
    <!--<a href="#" class="navbar-brand">Creditcards.com</a>-->
    <div class="cc-res-logohldr"><a href="/" class="cc-res-logo"> </a></div>
</div>
<div id="navbar-collapse-1" class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<!-- RATES & FEES -->
<li class="dropdown yamm-fw">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">LOW RATES &amp; FEES</a>
    <ul class="dropdown-menu">
        <li>
            <!-- Content container to add padding -->
            <div class="yamm-content">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Low Rates</h4>
                            <li><a href="/matrix/balance-transfer.php">Balance Transfers </a></li>
                            <li><a href="/matrix/0-apr-credit-cards.php">0% APR</a></li>
                            <li><a href="/matrix/low-interest.php">Low interest</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>No Fees</h4>
                            <li><a href="/matrix/no-annual-fee.php">No Annual Fee</a></li>
                            <li><a href="/matrix/no-foreign-transaction-fee.php">No Foreign Transaction Fee</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Tools</h4>
                            <li><a href="http://my.creditcards.com" target="_blank"><span class="new">New!</span> Get your free Credit Score</a></li>
                            <li><a href="/calculators/airlines-or-low-interest.php">Airlines or Low Interest Calculator</a></li>
                            <li><a href="/calculators/cash-back-or-low-interest.php">Cash Back or Low Interest Calculator</a></li>
                            <li><a href="/calculators/payoff.php">Payoff Calculator</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
						<div class="nav-adunit-hldr">
							<a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank"><img src="/images/cardmatch_thumb_12829.png" /></a>
						</div>
					</div>
                </div>
            </div>
        </li>
    </ul>
</li>
<!-- TRAVEL & REWARDS -->
<li class="dropdown yamm-fw sidebar">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">TRAVEL &amp; REWARDS</a>
    <ul class="dropdown-menu">
        <li>
            <div class="yamm-content">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Cards for Travel</h4>
                            <li><a href="/matrix/airline-miles.php">Travel & Airlines</a></li>
	                        <li><a href="/hotel-cards.php">Hotels</a></li>
                            <li><a href="/matrix/no-foreign-transaction-fee.php">No Foreign Transaction Fee</a></li>
                            <li><a href="/matrix/smart-emv-chip.php">EMV and SmartChip</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Earn Rewards</h4>
                            <li><a href="/matrix/reward.php">Rewards</a></li>
                            <li><a href="/matrix/cash-back.php">Cash Back</a></li>
                            <li><a href="/matrix/points-rewards.php">Points</a></li>
                            <li><a href="/matrix/gas-cards.php">Gas Cards</a></li>
                            <li><a href="/matrix/sports-rewards.php">Sports Rewards</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Tools</h4>
                            <li><a target="_blank" href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=home_body&utm_campaign=walletup">Max Rewards with WalletUp&reg;</a></li>
                            <li><a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank">Better offers with CardMatch&#8482;</a></li>

                        </ul>
                    </div>
                    <div class="col-sm-6">
						<div class="nav-adunit-hldr">
							<a href="https://walletup.creditcards.com/app?utm_source=ccrd&amp;utm_medium=referral&amp;utm_content=topnav-travel&amp;utm_campaign=walletup" target="_blank"><img src="/images/wallet-up-thumb_12830.png" /></a>

						<script type='text/javascript'>
                        <!--// <![CDATA[
                        // OA_show('home_masthead_13');
                        // ]]> --></script>

						</div>
					</div>
                </div>
            </div>
        </li>
    </ul>
</li>
<!-- TOP OFFERS -->
<li class="dropdown sidebar">
<a href="#" data-toggle="dropdown" class="dropdown-toggle">TOP OFFERS</a>
	<ul class="dropdown-menu">
		<li>
			<div class="yamm-content">
				<div class="row">
					<div class="col-sm-6">
						<ul class="list-unstyled">
							<li><a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank">Better Offers with CardMatch&#8482;</a></li>
							<li><a href="/top-credit-cards.php">Top Offers for <?= date('F Y') ?> </a></li>
							<li><a href="/limited-time-offers.php">Limited Time Offers</a></li>
						</ul>
					</div>
				</div>
			</div>
		</li>
	</ul>
</li>
<!-- CREDIT QUALITY -->
<li class="dropdown yamm-fw sidebar">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">CREDIT QUALITY</a>
    <ul class="dropdown-menu">
        <li>
            <div class="yamm-content">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Credit Type</h4>
                            <li><a href="/matrix/excellent-credit.php">Excellent Credit</a></li>
                            <li><a href="/matrix/good-credit.php">Good Credit</a></li>
                            <li><a href="/matrix/fair-credit.php">Fair Credit</a></li>
                            <li><a href="/matrix/bad-credit.php">Bad Credit</a></li>
                            <li><a href="/no-credit-history.php">Limited or No Credit History</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Other Options</h4>
                            <li><a href="/matrix/prepaid.php">Prepaid & Debit Cards</a></li>
                            <li><a href="/matrix/secured-credit-cards.php">Secured Credit Cards</a></li>
                            <li><a href="/personal-loans.php">Personal Loans</a></li>
	                        <li><a href="/small-business-loans.php">Small Business Loans</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Tools</h4>
                            <li><a href="http://my.creditcards.com" target="_blank"><span class="new">New!</span> Get your free Credit Score</a></li>
                            <li><a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank">Offers Matched for You</a></li>

                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="nav-adunit-hldr">
	                        <a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank"><img src="/images/cardmatch_thumb_12829.png" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<!-- CARD TYPE -->
<li class="dropdown yamm-fw sidebar"><a href="#" data-toggle="dropdown" class="dropdown-toggle">CARD TYPE</a>
    <ul class="dropdown-menu">
        <li>
            <div class="yamm-content">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Search by Type of Card</h4>
                            <li><a href="/matrix/business.php">Cards for Business</a></li>
                            <li><a href="/matrix/college-students.php">Cards for Students</a></li>
                            <li><a href="/matrix/prepaid.php">Prepaid & Debit Cards</a></li>
                            <li><a href="/matrix/secured-credit-cards.php">Secured Credit Cards</a></li>
                            <li><a href="/matrix/charity-credit-cards.php">Charity Credit Cards</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
						<ul class="list-unstyled">
							<h4>Search by Network</h4>
							<li><a href="/matrix/Mastercard.php">MasterCard</a></li>
							<li><a href="/matrix/Visa.php">Visa</a></li>
							<li><a href="/matrix/American-Express.php">American Express</a></li>
							<li><a href="/matrix/Discover.php">Discover</a></li>
						</ul>
					</div>
                    <div class="col-sm-6">
						<ul class="list-unstyled">
							<h4>Search by Bank or Issuer</h4>
							<li><a href="/matrix/Bank-of-America.php">Bank of America</a></li>
							<li><a href="/matrix/Capital-One.php">Capital One</a></li>
							<li><a href="/matrix/Citi.php">Citi</a></li>
							<li><a href="/matrix/Chase.php">Chase</a></li>
							<li><a href="/matrix/barclaycard.php">Barclaycard</a></li>
						</ul>
					</div>
                    <div class="col-sm-6">
                        <div class="nav-adunit-hldr">
	                        <a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank"><img src="/images/cardmatch_thumb_12829.png" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<!-- NEWS & ADVICE -->
<li class="dropdown yamm-fw sidebar"><a href="#" data-toggle="dropdown" class="dropdown-toggle">NEWS & ADVICE</a>
    <ul class="dropdown-menu">
        <li>
            <div class="yamm-content">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>News Articles</h4>
                            <li><a href="/credit-card-news.php">Latest News</a></li>
                            <li><a href="/credit-card-news">News Archive</a></li>
                            <li><a href="/credit-card-news/help">Basics & Help</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Additional Resources</h4>
                            <li><a target="_blank" href="http://blogs.creditcards.com">Taking Charge&#8482; Blog</a></li>
                            <li><a target="_blank" href="http://video.creditcards.com/">Latest Videos</a></li>
                            <li><a href="/glossary">Glossary of Credit Card Terms</a></li>
                            <li><a href="/privacy-security-suite">PrivacyWise&#8482;</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Connect with us</h4>
                            <li><a href="/rss-feed-credit-card-news-headlines.php">Subscribe: RSS News Feeds</a></li>
                            <li><a href="/newsletter.php">Subscribe: email Newsletter</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="nav-adunit-hldr">

                            <script type="text/javascript">if (!window.AdButler){(function(){var s = document.createElement("script"); s.async = true; s.type = "text/javascript";s.src = 'http://ab166629.adbutler-chargino.com/app.js';var n = document.getElementsByTagName("script")[0]; n.parentNode.insertBefore(s, n);}());}</script>
                            <script type="text/javascript">
                                var AdButler = AdButler || {}; AdButler.ads = AdButler.ads || [];
                                var abkw = window.abkw || '';
                                var plc187077 = window.plc187077 || 0;
                                document.write('<'+'div id="placement_187077_'+plc187077+'"></'+'div>');
                                AdButler.ads.push({handler: function(opt){ AdButler.register(166629, 187077, [220,149], 'placement_187077_'+opt.place, opt); }, opt: { place: plc187077++, keywords: abkw, domain: 'ab166629.adbutler-chargino.com' }});
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>
<!-- FREE INTERACTIVE TOOLS -->
<li class="dropdown yamm-fw sidebar" id="link-remove">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">FREE INTERACTIVE TOOLS</a>
    <ul class="dropdown-menu">
        <li>
            <div class="yamm-content">
                <div class="row">
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Tools</h4>
                            <li><a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank">Offers Matched for You</a></li>
                            <li><a target="_blank" href="https://walletup.creditcards.com/app?utm_source=ccrd&utm_medium=referral&utm_content=left_nav&utm_campaign=walletup">WalletUp&reg; Card Finder</a></li>
                            <li><a target="_blank" href="https://my.creditcards.com/"><span style="color: #fff;">New!</span> Get your free Credit Score</a></li>
                            <li><a href="/calculators">Calculators</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Card Offers</h4>
                            <li><a href="/top-credit-cards.php">Top Offers</a></li>
                            <li><a href="/best-credit-cards.php">Best Credit Cards</a></li>
                            <li><a href="/credit-card-comparison-tools.php">Credit Card Comparison Tools</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <ul class="list-unstyled">
                            <h4>Guides</h4>
                            <li><a href="/privacy-security-suite">PrivacyWise&#8482;</a></li>
                            <li><a href="/glossary">Credit Card Terms Glossary</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="nav-adunit-hldr">
	                        <a href="https://www.creditcards.com/cardmatch/?action=show_form" target="_blank"><img src="/images/cardmatch_thumb_12829.png" /></a>

                            <!-- ad space -->
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>

</ul>
</div>
</div>
</div>
</div>


