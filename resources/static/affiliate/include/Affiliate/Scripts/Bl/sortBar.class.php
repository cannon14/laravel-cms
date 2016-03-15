<?php
define('DYNAMIC_URL', 'http://cctools.inside.cs/sort');

class sortBar {

    function render($currentPage){
    	$pages = array(	'college-students.php'	=> 92,
				'low-interest.php'		=> 86,
				'airline-miles.php'		=> 89,
				'bad-credit.php'		=> 91,
				'balance-transfer.php'	=> 87,
				'cash-back.php'			=> 88,
				'prepaid.php'			=> 93,
				'business.php'			=> 90);
		$result = "<font size = '2'><b>Sort: </b>
			 | <a href='".DYNAMIC_URL."?sortby=introApr&amp;order=asc&amp;pid=".$pages[$currentPage]."'>Intro APR</a>
			 | <a href='".DYNAMIC_URL."?sortby=introAprPeriod&amp;order=asc&amp;pid=".$pages[$currentPage]."'>Intro APR Period</a>
			 | <a href='".DYNAMIC_URL."?sortby=regularApr&amp;order=asc&amp;pid=".$pages[$currentPage]."'>Regular APR</a>
			 | <a href='".DYNAMIC_URL."?sortby=annualFee&amp;order=asc&amp;pid=".$pages[$currentPage]."'>Annual Fee</a>
			 | <a href='".DYNAMIC_URL."?sortby=balanceTransfers&amp;order=asc&amp;pid=".$pages[$currentPage]."'>Balance Transfers</a>
			 | <a href='".DYNAMIC_URL."?sortby=creditNeeded&amp;order=asc&amp;pid=".$pages[$currentPage]."'>Credit Needed</a>
			 | <a class='sortSelected' href='".$currentPage."'>Popularity</a></font></div>";
		return $result;
    }
}
?>