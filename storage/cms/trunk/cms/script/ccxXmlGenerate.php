<?php
$client = new SoapClient('http://ccx-ws.qa.creditcards.com:8080/cardbank/ccxSubmit?wsdl');
//$client = new SoapClient('http://localhost:8084/cardbank/ccxSubmit?wsdl');

try{
    $response = $client->generateXML();
    print_r($response);
    
}catch(Exception $e){
    print_r($e);
    print_r($client);
}
?>