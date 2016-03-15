<?php

$host  = $_SERVER['HTTP_HOST'];
$hostip =  $_SERVER['SERVER_ADDR'];
$time  =  $_SERVER['REQUEST_TIME'];
$from  = $_SERVER['REMOTE_ADDR'];
$hostname = exec('hostname');

echo "<H1>$hostname</H1><HR>";
echo "<PRE>\n";
echo "Verifying request from - $from\n";
echo "HOST: $host     ($hostip)\n";
echo "at - $time\n";
echo "</PRE>\n";
echo "Cardsdev"
?>
