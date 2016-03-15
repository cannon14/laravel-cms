<div class='advertisingDisclosure'>
	<div id='advertisingDisclosurePopup'>
		<div class='close'>
			<a href='javascript:hideAdvertisingDisclosure()' id='closeBtn'>Close X</a>
		</div>
		<img src='/images/disclosureText.png' />
	</div>
	<a href='javascript:showAdvertisingDisclosure()' class='advertisingDisclosureOpen' id='openBtn'><img src='/images/advertisingDisclosure.png' /></a>
</div>


<?php $components = $this->page->getComponents() ?>
<?php if ($this->pageNav != "<div class='pageNav'><font class=nav-link>") { ?>
<table align="center" border="0" cellpadding="1" cellspacing="0" width="90%">
	<tr>
		<td align='center'>
			<br><?=$this->pageNav?><br>
		</td>
	</tr>
</table>
<br>
<?php } ?>
<?php if ($this->pageNumber == 1) {
	if (isset($components[2])) {
		echo $components[2]->get('render');
	}
	echo $this->page->get('pageLearnMore') . '<br>';
}
echo $this->page->get('pageDisclaimer')?>
<img src="images/1-375-spacer.gif" width="375" height="1"></td>
</table>
<table width="100%" height="18" border="0" cellspacing="0" cellpadding="0" background="images/top-bar-bg18.gif">
	<tr>
		<td width="100%" height="17" align="left" valign="top">
			<img src="images/1-1-spacer.gif" height="1" width="1">
		</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#003399">
	<tr>
		<td>
			<table width="95%" border="0" cellpading="3" cellspacing="0" align="center" cellpadding="3">
				<tr>
					<td class="bottomnav">
						<div align="center"><br>

							<div class='disclaimerText'>
								*Advertising Disclosure: Credit-Card-Applications-Center.com is an independent,
								advertising-supported comparison service. The owner of this website may be compensated
								in exchange for featured placement of certain sponsored products and services, or your
								clicking on links posted on this website.
							</div>


							<a href="credit-cards-terms.php">Terms</a> |
							<a href="credit-cards-privacy.php">Privacy</a> |
							<a href="credit-card-about-us.php">About Us</a> |
							<a href="credit-card-contact-us.php">Contact Us</a> |
							<a href="index.php">Home Page</a>
							<br/><br/>

							Copyright <?php echo date('Y'); ?> Credit Card Applications Center</div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6888323-1");
pageTracker._trackPageview();
} catch(err) {}
</script>

<!-- CCCOM Insight -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://piwik.aus.creditcards.com/" : "http://piwik.aus.creditcards.com/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
piwik_action_name = '';
piwik_idsite = 13;
piwik_url = pkBaseURL + "piwik.php";
piwik_log(piwik_action_name, piwik_idsite, piwik_url);
</script>
<object><noscript><img src="http://piwik.aus.creditcards.com/piwik.php?idsite=13" style="border:0" alt=""/></noscript></object>
<!-- End CCCOM Insight Tag -->

</body>
</html>