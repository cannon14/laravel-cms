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

require(dirname(__FILE__).'/config.inc.php');
require(dirname(__FILE__).'/xml/DocumentParser.class.php');
require(dirname(__FILE__).'/xml/Document.class.php');
require(dirname(__FILE__).'/xml/Element.class.php');
require(dirname(__FILE__).'/rates/RateChart.class.php');
require(dirname(__FILE__).'/rates/Rate.class.php');

/* Get XML From EHS */
//Only parse and output if XML content is found
if(false == ($xml=file_get_contents(EHS_LINK))) {
	//Send back a header with 404 error
	header('Content-Type: text/html', true, 404);    
} else {
	//Create Header
	header('Content-Type: text/html');
	/* Parse XML */
	$parser   = new DocumentParser($xml);
	$document = $parser->parse();
	//If there is a document...render it.
	if ($document) {
		/* Parlay parsed XML DOM Document to RateChart */
		$rateChart = new RateChart($document);
		
		/* Render chart */
		print $rateChart->render();
	}	
}
?>