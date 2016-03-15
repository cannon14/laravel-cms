<?php
$client = new SoapClient('http://66.219.46.79:8080/cardbank/cards?wsdl');

try{
    $cards = $client->loadAllCards( array(
        'user'=>'allcardrates'
    ) )->return;
        
    
    if (!empty($cards) && count($cards) < 2) {
        $cards = array( $cards );
    }
    
	$jsOutput = "";
	
	$totalCards = count($cards);
	
	for( $i=0; $i < $totalCards; $i++ ) {
	
	    $jsOutput .= '{name: "' . $cards[$i]->title . '", '.
	                 'apr:"' . $cards[$i]->maxOngoingAPR . '", '.
	                 'annualFee: "' . $cards[$i]->ongoingAnnualFee . '", '.
	                 'marketable: "' . $cards[$i]->marketable . '", '.
	                 'image: "' . $cards[$i]->image . '"}';
	    
	    if($i < $totalCards - 1)
	        $jsOutput .= ",";
	}
    
	$jsOutput = "var cardLibrary = [" . $jsOutput . "];";
	
	$handle = fopen("/usr/local/apache2/htdocs/ccbuild/cccomus/checkup/auto_complete_data.js", "w+");
	
	if (fwrite($handle, $jsOutput) === FALSE) {
        echo "Cannot write to Checkup JS data file ($filename)";
        exit;
    }

    fclose($handle);
    
} catch(Exception $e) {
    
	echo "Error building Credit Card Checkup Auto Complete data.";
	print_r($e);
    print_r($client);

}
?>