<?php
/*
Christian Lavender
*/

$relative_script_path = '.';
$no_connect = 0;

if (is_file("$relative_script_path/includes/config.php")) {
    include "$relative_script_path/includes/config.php";
}
else {
    die("Cannot find config.php file.\n");
}

if (LOG_CLICKS != true) { exit(); }

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

    $query = "INSERT INTO ".PHPDIG_DB_PREFIX."clicks (c_num,c_url,c_val,c_time) VALUES ($num,'".$url."','".$val."',NOW())";
    @mysql_query($query,$id_connect);
  }

}

?>