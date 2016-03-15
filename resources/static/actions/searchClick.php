<?php
/**
 * PHP Digg holdover.  This script registers search clicks
 */
require('global.php');

$relative_script_path = '.';
$no_connect = 0;

if (isset($_GET['num'])) {
	$num = $_GET['num'];
}
else {
	$num = 0;
}
if (isset($_GET['url'])) {
	$url = $_GET['url'];
}
else {
	$url = "";
}
if (isset($_GET['val'])) {
	$val = $_GET['val'];
}
else {
	$val = "";
}

settype($num, "integer");
settype($url, "string");
settype($val, "string");

phpdigClickLog($id_connect,$num,$url,$val);

function phpdigClickLog($id_connect,$num=0,$url='',$val='') {

  if ($num > 0 && $url != '' && $val != '') {
    $num = (int) $num;
    $url = addslashes(str_replace("\\","",stripslashes(urldecode($url))));
    $val = addslashes(str_replace("\\","",stripslashes(urldecode($val))));

    $query = "INSERT INTO cccom_search.cccom_clicks (c_num,c_url,c_val,c_time) VALUES ($num,'".$url."','".$val."',NOW())";
    QCore_Sql_DBUnit::execute($query, __FILE__, __LINE__);
  }

}

?>