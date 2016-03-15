<?$components = $this->page->getComponents()?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
	<title><?=$this->page->get('pageTitle')?></title>
	<?=$this->page->get('pageMeta')?>

	<link rel="stylesheet" href="css/credit-card.css" type="text/css">
	<script type="text/javascript" src="javascript/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="javascript/application.js"></script>
</head>

<body leftmargin="0" topmargin="0" alink="#cc0000" bgcolor="#ffffff" link="#0033cc" marginheight="0" marginwidth="0" vlink="#0033cc">
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#003399" width="100%">
  <tr> 
    <td valign="top" width="153"> 
      <div align="left"><a href="index.php"><img src="images/credit-card-applications-logo.gif" width="450" height="72" alt="<?=$this->page->get('pageTitle')?>" border="0"></a></div>
    </td>
    <td width="878" valign="middle"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td valign="top"> 
            <? if(isset($components[0])) echo $components[0]->get('render'); ?>
          </td>
        </tr>
      </table>
    </td>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" background="images/top-bar-bg20.gif">
		<tr> 
    		<td width="250"> 
      			<script language="JavaScript" type="text/javascript">
					<!--
					getit1="";
					getit2="";
					today = new Date();
					weekday = today.getDay();
					if (weekday == 0) getit1='Sunday';
					if (weekday == 1) getit1='Monday';
					if (weekday == 2) getit1='Tuesday';
					if (weekday == 3) getit1='Wednesday';
					if (weekday == 4) getit1='Thursday';
					if (weekday == 5) getit1='Friday';
					if (weekday == 6) getit1='Saturday';
					month = today.getMonth();
					if (month == 0) getit2='January';
					if (month == 1) getit2='Febuary';
					if (month == 2) getit2='March';
					if (month == 3) getit2='April';
					if (month == 4) getit2='May';
					if (month == 5) getit2='June';
					if (month == 6) getit2='July';
					if (month == 7) getit2='August';
					if (month == 8) getit2='September';
					if (month == 9) getit2='October';
					if (month == 10) getit2='November';
					if (month == 11) getit2='December';
					date = today.getDate();
					year=today.getFullYear();
					document.write ("<font class='Time-Date' >" + getit1,' ',getit2,' ',date,', ',year + "</font>");
					// -->
				</script>
    		</td>
    		<td>
      			<div align="right"><a href="index.php"><img src="images/credit-card-home.gif" alt="Credit Card Application Home Page" border="0" height="18" width="55"></a></div>
    		</td>
    		<td width="138"> 
      			<div align="right"> 
        			<script class="Time-Date">
						// message to show in non-IE browsers
						var txt = "<img src='images/credit-card-application-online.gif' width='128' height='15' border='0'>"
						
						// url you wish to have bkmrked
						var url = "http://www.credit-card-applications-center.com";
						
						// caption to appear with bkmrked
						var who = "Credit Card Applications Center - online credit cards directory"
						
						// do not edit below this line
						
						var ver = navigator.appName
						var num = parseInt(navigator.appVersion)
						if ((ver == "Microsoft Internet Explorer")&&(num >= 4)) {
						   document.write('<A class="Time-Date" HREF="javascript:window.external.AddFavorite(url,who);" ');
						   document.write('onMouseOver=" window.status=')
						   document.write("'Add this page to your Favorites List!'; return true ")
						   document.write('"onMouseOut=" window.status=')
						   document.write("' '; return true ")
						   document.write('">'+ txt + '</a>')
						}else{
						   txt +=  " "
						   document.write(txt)
						}
		</script>
      </div>
    </td>
  </tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr> 
    		<td background="images/left-nav-bg.gif" valign="top">
				<table width="191" border="0"  cellspacing="0" cellpadding="0">
				  <tr> 
				    <td> 
				      <div align="left"><img src="images/credit-card-menu.gif" width="186" height="36" alt="Credit Card Offers"></div>
				    </td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="low-interest-credit-card.php">Low 
				      Interest Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="balance-transfer-credit-cards.php">Balance 
				      Transfer Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="instant-credit-card-approval.php">Instant 
				      Approval Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="cash-back-credit-cards.php">Cash 
				      Back &amp; Rewards Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="frequent-flyer-credit-cards.php">Frequent 
				      Flyer Credit Cards</a></td>
				  </tr>
				 <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="business-credit-cards.php">Business 
				      Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="student-credit-card.php">Student 
				      Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="prepaid-credit-cards.php">Prepaid 
				      Credit Cards</a></td>
				  </tr>
				<!--  <tr> 
				    <td class="leftnav"><img src="images/bb.gif" width="22" height="8"><a href="guaranteed-approval-credit-cards.php">Guaranteed 
				      Approval Cards</a></td>
				  </tr> -->
				  <tr> 
				    <td class="leftnav"><img src="images/10-10-spacer.gif" width="10" height="10"></td>
				  </tr>
				  <tr> 
				    <td><img src="images/credit-card-rating.gif" width="186" height="36" alt="Credit Cards by Credit Ratings"></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/bg.gif" width="22" height="8"><a href="good-credit.php">Good 
				      Credit Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav" height="7"><img src="images/bg.gif" width="22" height="8"><a href="bad-credit-credit-cards.php">Bad 
				      Credit Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/10-10-spacer.gif" width="10" height="10"></td>
				  </tr>
				  <tr> 
				    <td><img src="images/bank-card.gif" width="186" height="36" alt="Bank Credit Cards"></td>
				  </tr>
				 <!-- <tr> 
				    <td class="leftnav"><img src="images/by.gif" width="22" height="8"><a href="advanta-credit-card.php">Advanta</a></td>
				  </tr> -->
				  <tr> 
				    <td class="leftnav"><img src="images/by.gif" width="22" height="8"><a href="american-express-credit-card.php">American 
				      Express&reg; </a></td>
				  </tr>
				 <!-- <tr> 
				    <td class="leftnav" height="7"><img src="images/by.gif" width="22" height="8"><a href="Bank-of-America.php">Bank 
				      of America</a></td>
				  </tr> -->
				  <!--<tr> 
				    <td class="leftnav" height="7"><img src="images/by.gif" width="22" height="8"><a href="Capital-One.php">Capital One&reg;</a></td>
				  </tr>-->
				  <!--<tr> 
				    <td class="leftnav"><img src="images/by.gif" width="22" height="8"><a href="chase-credit-card.php">Chase 
				      Manhattan Bank</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/by.gif" width="22" height="8"><a href="citi-bank-credit-card.php">Citi&reg; Credit Cards</a></td>
				  </tr>-->
				  <tr> 
				    <td class="leftnav" height="7"><img src="images/by.gif" width="22" height="8"><a href="discover-credit-card.php">Discover&reg; 
				      Card </a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/by.gif" width="22" height="8"><a href="mastercard-credit-card.php">MasterCard&reg;</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav" height="7"><img src="images/by.gif" width="22" height="8"><a href="visa-credit-card.php">Visa 
				      Credit Cards</a></td>
				  </tr>
				  <tr> 
				    <td class="leftnav"><img src="images/10-10-spacer.gif" width="10" height="10"></td>
				  </tr>
				</table>
				<?if(isset($components[1])){?>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td><img src="images/specials.gif" alt="Credit Card Offers &amp; Special Promotions" height="36" width="186"></td>
						</tr>
						<tr>
							<td><?=$components[1]->get('render')?></td>
						</tr>
				</table>
				<?}?>
      		</td>
      		
    		<td valign="top"> 
      			<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
        				<tr>
          					<td> 
            					<div align="center">
							      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
							        <tr> 
							          <td> 
							            <div align="center"> 
							              <?if($this->pageNumber == 1){?>
							              <table border="0" cellspacing="0" cellpadding="3" align="center" width="100%">
							                <tr> 
							                  <td> 
							                    <div align="center"><b><img src="images/1-1-spacer.gif" width="1" height="1"></b></div>
							                  </td>
							                </tr>
							                <?clearstatcache();
							                if($this->page->get('pageHeaderImage')){?>
							              	<tr>
							                  <td> 
							                    <div align="center"><img src="images/<?=$this->page->get('pageHeaderImage')?>" alt="<?=$this->page->get('pageHeaderImageAltText')?>"></div>
							                  </td>
							                </tr><?}?>
							                <tr> 
							                  <td> 
							                    <div align="center"> 
							                      <h2><?=$this->page->get('primaryNavString')?> in 3 easy steps...</h2>
							                    </div>
							                  </td>
							                </tr>
							              </table>
							        	</div>
	              						  <table cellspacing="0" cellpadding="2" align="center">
	                						<tr> 
	                  							<td> 
								                    <p><b>1. Search</b> through the <?=$this->page->get('secondaryNavString')?> below<br>
								                      <b>2. Compare</b> rates &amp; fees of offers side by side <br>
								                      <b>3. Apply</b> by filling out an online credit card application</p>
	                  							</td>
	                						</tr>
	                						<tr> 
							                  <td><img src="images/10-10-spacer.gif" width="10" height="10"></td>
							                </tr>
							      		</table><?}else{?><img src="images/10-10-spacer.gif" width="10" height="20"><br><?}?>
                        			</td>
                        		</tr>
                        	</table>
                        </div>
                       </td>
					</tr>
				</table>	