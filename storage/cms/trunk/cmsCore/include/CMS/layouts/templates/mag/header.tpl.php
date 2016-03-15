<?php /*='<?PHP
include_once(\''.$this->rootPath.'actions/pageInit.php\');
$_SESSION[\'fid\'] = "'.($this->page->get('fid')?$this->page->get('fid'):'35').'";
include_once(\''.$this->rootPath.'actions/trackers.php\');
';
if($this->page->get(CHAMELEON_SQL)){
    print 'include_once(\''.$this->rootPath.'actions/chameleon.php\');';
}
if ($this->useGeoIp && false) { /* This is turned off */
/*    echo ('include_once(\''.$this->rootPath.'actions/geoip.php\');');
}
print '?>';*/?>
<? echo '<?php'.chr(10); ?>
<? echo 'session_start();'.chr(10); ?>
<? echo '$_SESSION["page_id"] = '.($this->page->get('fid')?$this->page->get('fid'):'35').';'.chr(10); ?>
<? echo 'require_once($_SERVER["DOCUMENT_ROOT"] . "/ccCore.inc.php");'.chr(10); ?> 
<? echo '?>'?>
<? echo "<?
session_start();
if ( !empty(\$_REQUEST['aid']) ) {
	\$_SESSION['aid'] = \$_REQUEST['aid'];
}

if (empty(\$_SESSION['aid']))
	\$_SESSION['aid'] = '1';	
?>
";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title><?=$this->page->getTitle()?> - MerchantAccountGuide.com</title>
<?=$this->page->getPageMeta()?>
<link rel="stylesheet" href="/css/merchant-account-guide.css" type="text/css">
<link rel="stylesheet" href="/css/merchant-account-guide-print.css" type="text/css" media="print">
<link rel="alternate" type="application/rss+xml" title="MerchantAccountGuide.com Top News" href="/merchant-account-news/rss/news-top-story.rss" />
<link rel="alternate" type="application/rss+xml" title="MerchantAccountGuide.com News: All credit card processing news" href="/merchant-account-news/rss/rss-view.php?id=24" />

	<script type="text/javascript" src="/javascript/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="/javascript/global.js"></script>

</head>

<body link="#003399" alink="#CC0000" vlink="#003399">
    <div id="header">
        	<a href="/" class="homelink">
        		<span id="logo-text">Merchant Account Guide</span>
            	<span id="logo-sub-text">The Merchant Account Experts</span>
            </a>
            
    		
            <table id="bank-logos" width="100" border="0">
      			<tr>
        			<td><img src="/images/visa.gif" alt="Accept Visa" /></td>
    			<td><img src="/images/master-card.gif" alt="Accept MasterCard" /></td>
    			<td><img src="/images/amex.gif" alt="Accept American Express" /></td>
    			<td><img src="/images/discover.gif" alt="Accept Discover" /></td>
      			</tr>
    		</table>
            
            <h1 id="bank-logos-text">Merchant Account &amp; Credit Card Processing</h1>
    
          <div id="header-border-bottom">
          
          	<span id="nav"><a href="/" >Home</a> &nbsp; | &nbsp; <a href="/merchant-account-news/" >News &amp; Advice</a> &nbsp; | &nbsp; <a href="/merchant-accounts.php">Compare Merchants Accounts</a> &nbsp; <!-- | &nbsp; Calculators -->
          	</span>
            
          </div>  
          
          
     
            <div id="search-swoosh">
            	<span id="glossary"><a href="/merchant-account-news/merchant-account-glossary-terms.php" >Glossary</a></span>
                <div id="divider"></div>
            
    		<div id="search_box">
    		<form action='/search.php' id='search_form' method='post' >
        		<input name="query" type="text" value="" size="17" maxlength="50" class="top-searchbox" onFocus="this.value=''" />
        		<input type='hidden' name='search' value='1' />
        		<input type='submit' name='submit' value='Search'  id='go' alt='Search' title='Search'  />
        	</form>
    </div><!-- end search_box -->
    </div><!-- end search-swoosh -->
    </div><!-- end header -->
	<div class="header_content_spacer">
	</div>
	<div class="content_div">
		<table class="layout_table" width="100%"> <!-- content table -->
			<tr> <!-- first row -->
				<td class="left_nav" valign="top" nowrap> <!-- first column -->
					<?='<?php include $_SERVER["DOCUMENT_ROOT"] . "/inc/left-nav.inc.php"; ?>' ?>
				</td><!-- end first column -->
				<td valign="top" id="content-box"> <!-- second column -->
                                    