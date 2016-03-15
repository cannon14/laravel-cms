<?php
/*
 * Created on Nov 21, 2008
 * Revised on Nov 08, 2011
 *
 * CreditCards.com
 * Author: Tyler Chamberlain
 */

$this->siteCatalystData['pageName'] = "profiles:" . $this->pageNameLowercase;
$this->siteCatalystData['channel'] = "profiles";

$merger = new CMS_libs_MergeFilter();
//$this->cardData['Balance Transfer APR'] = $merger->translate($this->card->get('balanceTransferIntroApr'), $this->card->get('cardId'));
//$this->cardData['Balance Transfer APR Period'] = $merger->translate($this->card->get('balanceTransferIntroAprPeriod'), $this->card->get('cardId'));

// Get Terms and Conditions Link if available:
//
$tncLinkFields = $this->top_card_data->card->getTermsAndConditionsLinkFields();

// Working CNP
//$cardType = $this->card->get('type');
//$cardDefaultView = $this->card->getDefaultView();
//$cardPrepaidCustomText = $cardDefaultView[LANG_PREPAID_TEXT];
//
//$boolShowPrepaidCustomText =
//	( ($cardPrepaidCustomText != '') && ($cardType == 'prepaid' || $cardType == 'debit' || $cardType == 'giftcard') )
//	? true
//	: false
//	;

?>

<div style="background-color: #fff">

<table width="790" id="content" align="center" border="0" cellpadding="3" cellspacing="0">
	<tr>
		<td rowspan="2" width="38">&nbsp;</td>
		<td id="breadcrumbs">
			<a href="/">Credit Cards</a> > <a href="/credit-card-tools/">Tools</a> &gt; 
			<a href="/credit-card-profiles/">Shop Credit Cards by Profile</a> &gt;
			<?=$this->profile_data->fields['title']?>
		</td>
		<td rowspan="2" width="38">&nbsp;</td>
	</tr>
	<tr>
		<td class="profileHeaderCell" style="background-image: url('/images/profile_big_<?=$this->pageNameLowercase?>.gif');">
		<div style="position: relative; height:220px;" >
			<div class="profileHeaderBox">
			<table border="0" cellpadding="0" cellspacing="0" style="border: 3px solid white; padding: 5px; background-color: <?=$this->profile_data->fields['background_color_code_light']?>;">
			<tr>
				<td valign="middle" style="vertical-align:middle;">
					<h1><span class="profileTitle">
						<?=$this->profile_data->fields['title']?>:
					</span></h1>
					<span class="profileTag">
						<?=$this->profile_data->fields['content_sub_title']?><br/><br/>
	
						<b>Tip:</b> <?=$this->profile_data->fields['profile_tip']?>
					</span>
				</td>
			</tr>
			</table>
			</div>
		</div>
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
</table>

<table width="790" bgcolor="#ffffff" id="content2" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td rowspan="4" width="35">&nbsp;</td>
		<td>
		   	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
   			<tr> 
     				<td><img src="/images/top-pick-tab.gif" width="116" height="24" alt="Top Pick" height="24" width="184"></td>
   			</tr>
   	 		</table>
			<table align="center" cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
			  <tr>
			  	<th colspan='2' class='offer-left'> 
			    <?=$this->siteProp['individualcards']
			    ?"<a href='/".$this->siteProp['individualcarddir'].'/'.$this->top_card_data->fields['cardLink'].".".$this->siteProp['pagetype']."'>".$this->top_card_data->fields['cardTitle']."</a>"
			    :$this->top_card_data->fields['cardTitle'];
			    
			    if (empty($this->top_card_data->fields['cardIOAltText'])) {
			    	$this->top_card_data->fields['cardIOAltText'] = $this->top_card_data->fields['cardTitle'] . " Offer";
			    }
			    
			    if (empty($this->top_card_data->fields['cardButtonAltText'])) {
			    	$this->top_card_data->fields['cardButtonAltText'] = "Click to Apply Online";
			    }
				?>
			    </th>
			  </tr>
			  <tr> 
			    <td width="15%" class="cc-card-art-align">
                    <?='<? echo "<a href=\'/oc/?' . $this->top_card_data->fields['cardId'].'\' target=\'_blank\' name=\''.'&lid='.$this->top_card_data->fields['cardLink'].'\'>"; ?>'?>
                        <img src="<?=IMGSYNERGY_CARD_IMAGE_ROOT?>/<?=$this->top_card_data->fields['imagePath']?>" width="95" border="0" alt="<?=$this->top_card_data->fields['cardIOAltText']?>">
                        <br>
                        <img name="Apply-Now" border="0" src="/images/apply-now.gif" width="95" height="28" alt="<?=$this->top_card_data->fields['cardButtonAltText']?>">
                    </a>
<? if ($tncLinkFields) { ?>
                    <?='<? echo "<a href=\'/oc/?pid=' . $this->top_card_data->fields['cardId'].'&aid='. ALTERNATE_LINK_TERMS_SENTINEL_AID_VALUE . '&sid=' . ALTERNATE_LINK_TERMS_SENTINEL_WEBSITEID_VALUE . '\' target=\'_blank\' name=\''.'&lid='.$this->top_card_data->fields['cardLink'].'\' class=\"tnc-link\" >"; ?>'?>
                        <?=LANG_TERMS_AND_CONDITIONS_LINKTEXT?>
                    </a>
<? } // terms and conditions link ?>
                </td>
			    <td width="85%" class="details"> 
					<?=$this->top_card_data->fields['cardDetailText']?>
			    </td>
			  </tr>
			  <tr> 
			    <td colspan="2"> 
			      <table align="center" class="rate-rc" cellpadding="0" cellspacing="1">
			        <tr>
                                    <td colspan="2" class="rate-top">Purchases</td>
                                        <td nowrap="nowrap" colspan="2" class="rate-top">Balance Transfers</td>
                                        <td rowspan="2" class="rate-top">Regular APR</td>
                                        <td rowspan="2" class="rate-top">
                                            <?php if ($this->cardData['Annual Fee'] == '')
                                                echo "Monthly Fee (up to)";
                                                else {
                                                echo "Annual Fee";
                                                }     
                                            ?>
                                        </td>
                                        <td rowspan="2" class="rate-top">Credit Needed</td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap" class="rate-top">Intro APR</td>
                                        <td nowrap="nowrap" class="rate-top">Intro APR Period</td>
                                        <td nowrap="nowrap" class="rate-top">Intro APR</td>
                                        <td nowrap="nowrap" class="rate-top">Intro APR Period</td>
                                    </tr>
                                    <tr>
                                        <td class="rates-bottom"><?=$this->cardData['Intro APR']?></td>
                                        <td class="rates-bottom"><?=$this->cardData['Intro APR Period']?></td>
                                        <td class="rates-bottom"><?=$this->cardData['Balance Transfer Intro APR'] ?></td>
										<td class="rates-bottom"><?=$this->cardData['Balance Transfer Intro Period'] ?></td>
                                        <?php if (isset($this->cardData['Regular APR'])) { ?>
										<td class="rates-bottom"><?=$this->cardData['Regular APR']?></td>
										<?php } if (isset($this->cardData['Typical APR'])) { ?>
										<td class="rates-bottom"><?=$this->cardData['Typical APR']?></td>
										<?php } ?>
                                        <td class="rates-bottom">
                                            <?php if ($this->cardData['Annual Fee'] == '')
                                                echo $this->cardData['Monthly Fee (up&nbsp;to)'];
                                                else {
                                                echo $this->cardData['Annual Fee'];
                                                }     
                                            ?>
                                        </td>
                                        <td class="rates-bottom"><?=$this->cardData['Credit Needed']?></td>
                                    </tr>
                                </table>
			    </td>
			  </tr>
			</table>
		</td>
		<td align="center" valign="bottom">
			<div>
				<span class="profileInfoBoxText" style="font-size:9pt; font-weight: bold;">
				<br/>Change Profile<br/>
				</span>
			 <?php
				$slidemenuSlideHeight = 90;
				$slidemenuTitleHeight = 22;
			 ?>
				<ul id="slidemenu" class="slidemenu" style="width:<?=
					($slidemenuSlideHeight + ($slidemenuTitleHeight * sizeof($this->profiles_data)))?>px;">
				<?php
				foreach ($this->profiles_data as $profile_data) {
					?>
						<li>
							<div class="slidemenuSlideDiv" style="background-color: <?=$profile_data['background_color_code_light']?>;"
						 		 onclick="location.href='<?=$profile_data['lowerName']?>.php';">
							 	
							 	<a href="<?=$profile_data['lowerName']?>.php">
							 		<img src="/images/profile_menu_<?=$profile_data['lowerName']?>.gif" alt="<?=$profile_data['title']?> Credit Card Profile" class="slidemenuMiniPic"/>
							 	</a>
						 	
						 	</div>
						 </li>
					<?php	
				}	
				?>
				</ul>				
				<span class="profileInfoBoxText" style="font-size:7pt;">
					<a href="/credit-card-profiles/">See all Credit Card Profiles</a>
				</span>
				<script>
				function init() {
					// quit if this function has already been called
					if (arguments.callee.done) return;
					// flag this function so we don't do the same thing twice
					arguments.callee.done = true;
					//build menu
					slideMenu.build('slidemenu',<?=($slidemenuSlideHeight+$slidemenuTitleHeight)?>,10,10,<?=$this->profile_data->fields['rank']?>);
				}
				window.onload=init;
				</script>
				<script type="text/javascript" src="slidemenu/slidemenu.js" onLoad="init();"></script>
		</div>
		<div class="advertising_disclosure_container" id="advertising_disclosure_container_profiles" style="margin-top: 50px">
			<div class="advertising_disclosure_link">
				<a href="#advertising_disclosure_footer">
					<img src="/images/advertising-disclosure/advertiserDisclosure.png">
				</a>
			</div>
			<div class="advertising_disclosure_text">
				<div>
				<a class="close_adtext" href="#">
					<img src="/images/advertising-disclosure/disclosure_top.png">
				</a>
				</div>
				<div>
					<img src="/images/advertising-disclosure/disclosure.png">
				</div>
			</div>
			<div class="clear"></div>
		</div>
		</td>
		<td rowspan="4" width="35">&nbsp;</td>
	</tr>
</table>
<table width="790" bgcolor="#ffffff" id="content3" border="0" align="center" cellpadding="3" cellspacing="0">
	<tr>
		<td rowspan="4" width="35">&nbsp;</td>
		<td colspan="2">
		
			<table border="0" width="100%" cellpadding="5" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
				<tr>
					<th class="offer-left" colspan="6">
						Other Popular Picks
					</th>
				</tr>
				<tr>
					<?php
					$otherCards = $this->popularCards; 
					$i = 0;
					
					//echo var_dump($otherCards);
					                  
					while ($otherCards && !$otherCards->EOF && $i<6) {
						//Print this card only if it is NOT the same as top card
						if ($otherCards->fields['cardId'] != $this->top_card_data->fields['cardId']) {
							if (empty($otherCards->fields['cardButtonAltText'])) {
								$otherCards->fields['cardButtonAltText'] = "Click to Apply Online";
							}
							$content .= '<td class="cc-card-art-align" style="padding: 5px;">';
							$content .= '<a href="/oc/?' . $otherCards->fields['cardId'] . '" target="_blank">' .
										'<img src="' . IMGSYNERGY_CARD_IMAGE_ROOT . '/' . $otherCards->fields['imagePath'] . '" ' .
										'width="95" border="0" alt="' . $otherCards->fields['cardTitle'] . ' Offer">' .
										'<br /><img name="Apply-Now" border="0" src="/images/apply-now.gif" width="95" height="28" ' .
										'alt="' . $otherCards->fields['cardButtonAltText'] . '"></a><br/>' .
										'<a href="/credit-cards/' . $otherCards->fields['cardLink'] . '.php" ' .
										'style="font-size:9pt;">More info</a>';
							$content .= '</td>';
							$i++;
						}						
						$otherCards->MoveNext();
					}
					?>
					<?=$content?>
				</tr>
			</table>
			
		</td>	  
		<td rowspan="4" width="35">&nbsp;</td>
	</tr>
	<tr valign="top">
		<td>
			<table border="0" cellpadding="5" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
				<tr>
					<th class="offer-left" colspan="3">
						Popular credit card categories
					</th>
				</tr>
				<tr valign="top">
					<td align="center" width="33%">
							<a href="/<?=$this->cardCategory1->fields['pageLink']?>.php">
								<img src="/images/<?=(!empty($this->cardCategory1->fields['pageSmallImage']) ? $this->cardCategory1->fields['pageSmallImage'] : $this->cardCategory1->fields['pageHeaderImage']);?>"
								 border="0" width="35" height="35"
								alt="<?=$this->cardCategory1->fields['primaryNavString']?>" /><br/>
							</a>
							<span class="profileLink">
							<a href="/<?=$this->cardCategory1->fields['pageLink']?>.php">
								<?=$this->cardCategory1->fields['primaryNavString']?>
							</a>
							</span>
					</td>
					<td align="center" width="33%">
							<a href="/<?=$this->cardCategory2->fields['pageLink']?>.php">
								<img src="/images/<?=(!empty($this->cardCategory2->fields['pageSmallImage']) ? $this->cardCategory2->fields['pageSmallImage'] : $this->cardCategory2->fields['pageHeaderImage']);?>"
								 border="0" width="35" height="35"
								alt="<?=$this->cardCategory2->fields['primaryNavString']?>"/><br/>
							</a>
							<span class="profileLink">
							<a href="/<?=$this->cardCategory2->fields['pageLink']?>.php">
								<?=$this->cardCategory2->fields['primaryNavString']?>
							</a>
							</span>
					</td>
					<td align="center" width="33%">
							<a href="/<?=$this->cardCategory3->fields['pageLink']?>.php">
								<img src="/images/<?=(!empty($this->cardCategory3->fields['pageSmallImage']) ? $this->cardCategory3->fields['pageSmallImage'] : $this->cardCategory3->fields['pageHeaderImage']);?>"
								 border="0" width="35" height="35"
								alt="<?=$this->cardCategory3->fields['primaryNavString']?>" /><br/>
							</a>
							<span class="profileLink">
							<a href="/<?=$this->cardCategory3->fields['pageLink']?>.php">
								<?=$this->cardCategory3->fields['primaryNavString']?>
							</a>
							</span>
					</td>
				</tr>
			</table>
		</td>
		<td rowspan="2">
				<div align="center">
  
					<script src="/javascript/AC_RunActiveContent.js" language="javascript"></script>
					<script language="JavaScript">
						<!--
							AC_FL_RunContent('codebase', 'http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0', 'width', '400', 'height', '500', 'src', '/calculators/400x500_cashback_lowinterest.swf', 'quality', 'high', 'pluginspage', 'https://www.macromedia.com/go/getflashplayer', 'bgcolor', '#ffffff', 'menu', 'false', 'movie', '<?=$this->profile_data->fields['calculator_url'] ?>');
						//-->
					</script>
					<noscript>
						<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="400" height="500" align="middle">
						<param name="movie" value="<?=$this->profile_data->fields['calculator_url'] ?>" />
						<param name="quality" value="high" />
						<param name="menu" value="false" />
						<param name="bgcolor" value="#ffffff" />
						<embed src="<?=$this->profile_data->fields['calculator_url'] ?>" menu="false" quality="high" bgcolor="#ffffff" width="400" height="500" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
						</object>
					</noscript>
       		</div>
		<span id="breadcrumb" align="left">
			<a href="/calculators/index.php">See more Calculators</a>
		</span>

		</td>
	</tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellpadding="5" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
				<tr>
					<th class="offer-left">
						Related News & Advice
					</th>
				</tr>
				<tr>
					<td class="newsContent">
						<?=$this->profile_data->fields['news_static_content'] ?>
					</td>
				</tr>
			</table>
			<span id="breadcrumb" align="left">
				<a href="/credit-card-news.php">See more Stories</a>
			</span>
                    <br />
                    <div style="text-align: right; margin-top: 30px;">
                        <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.creditcards.com%2Fcredit-card-profiles%2F&amp;layout=standard&amp;show_faces=false&amp;width=300&amp;action=like&amp;font&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;" allowTransparency="true"></iframe>
                    </div>
                    <p>Comments or suggestions about this tool? <br/><a href="/site-feedback.php">Send us feedback</a></p>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>

</div> <!-- <div style="background-color: #fff"> -->