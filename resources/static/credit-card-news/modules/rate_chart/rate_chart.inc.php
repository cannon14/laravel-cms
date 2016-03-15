<?php
/**
 * Rate Chart Include file.
 * 
 * Include this file where you'd like the Rate Table to appear.
 * 
 * @copyright 2008 Creditcards.com 
 * @author Patrick J. Mizer <patrick.mizer@creditcards.com>
 * 
 */

require('credit-card-news/modules/rate_chart/config.inc.php');
require('credit-card-news/modules/rate_chart/xml/DocumentParser.class.php');
require('credit-card-news/modules/rate_chart/xml/Document.class.php');
require('credit-card-news/modules/rate_chart/xml/Element.class.php');
require('credit-card-news/modules/rate_chart/rates/RateChart.class.php');
require('credit-card-news/modules/rate_chart/rates/Rate.class.php');

/* Get XML From EHS */
//$xml = file_get_contents(EHS_LINK);

//Only parse and output if XML content is found
if( false == ($xml=file_get_contents(EHS_LINK)) ) {
    //Could not read file.
    
} else {
	
	/* Parse XML */
	$parser   = new DocumentParser($xml);
	$document = $parser->parse();
	
	if ($document) {
		/* Parlay parsed XML DOM Document to RateChart */
		$rateChart = new RateChart($document);
		
		/* Render chart */
		print $rateChart->render();
	}
}
?>