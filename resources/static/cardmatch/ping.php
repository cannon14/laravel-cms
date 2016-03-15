<?
include('config/config.php');

if (TRANSUNION_PING_ENABLED) {
    echo 'Pinging TU...<br/>';
    pingTransUnion();
} else {
    echo 'Ping Disabled<br/>';
}

function pingTransUnion() {
    $handle = curl_init();
    $options = array(
                      CURLOPT_RETURNTRANSFER => false,
                      CURLOPT_HEADER         => true,
                      CURLOPT_FOLLOWLOCATION => false,
                      CURLOPT_SSL_VERIFYHOST => '0',
                      CURLOPT_SSL_VERIFYPEER => '1',
                      CURLOPT_SSLCERT        => TRANSUNION_CLIENT_CERT,
                      CURLOPT_SSLCERTPASSWD  => TRANSUNION_CLIENT_CERT_PASSWORD,
                      CURLOPT_CAINFO         => TRANSUNION_CA_CERT,
                      CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)',
                      CURLOPT_VERBOSE        => true,
                      CURLOPT_URL            => TRANSUNION_URL.TRANSUNION_PING_PATH
               );

    curl_setopt_array($handle, $options);
    $rawdata = curl_exec($handle);
    if (curl_errno($handle)) {
      echo 'Error: ' . curl_error($handle);
    }
    curl_close($handle);

    if ($rawdata) {
        echo '<br/>PING SUCCESSFUL<br/><br/>';
        var_dump($rawdata);
    } else {
        echo '<br/>No Response<br/>';
    }
}