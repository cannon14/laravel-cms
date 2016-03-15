<?php
/*
----------------------------------------------------------------------------------
PhpDig Version 1.8.x - See the config file for the full version number.
This program is provided WITHOUT warranty under the GNU/GPL license.
See the LICENSE file for more information about the GNU/GPL license.
Contributors are listed in the CREDITS and CHANGELOG files in this package.
Developer from inception to and including PhpDig v.1.6.2: Antoine Bajolet
Developer from PhpDig v.1.6.3 to and including current version: Charter
Copyright (C) 2001 - 2003, Antoine Bajolet, http://www.toiletoine.net/
Copyright (C) 2003 - current, Charter, http://www.creditcards.com/
Contributors hold Copyright (C) to their code submissions.
Do NOT edit or remove this copyright or licence information upon redistribution.
If you modify code and redistribute, you may ADD your copyright to this notice.
----------------------------------------------------------------------------------
*/

$relative_script_path = '..';
$no_connect = 0;
include "$relative_script_path/includes/config.php";
include "$relative_script_path/libs/auth.php";
?>
<?php include $relative_script_path.'/libs/htmlheader.php' ?>
<head>
<title>CreditCards.com : Cleaning index</title>
<?php include $relative_script_path.'/libs/htmlmetas.php' ?>
</head>
<body bgcolor="white">
<h2>Clean Keyword Stuffing</h2>
<?php
$sql = "SELECT * FROM ".PHPDIG_DB_PREFIX."adjustedweights";
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result)){
	$crawled[] = array("spider_id" => $row['spider_id'], 
						"key_id" => $row['key_id'], 
						"weight" => $row['weight']);
}
foreach($crawled as $row){
	$sql = "UPDATE ".PHPDIG_DB_PREFIX."engine set weight='".$row['weight']."' WHERE " .
	" spider_id = '".$row['spider_id']."' AND key_id = '" . $row['key_id'] . "'";
	//echo $sql . "<br>";
	$result = mysql_query($sql) or die ("Error updating SQL<br>");
	echo "Updated key_id: " .$row['key_id'] . " spider_id: " . $row['spider_id'] . "...<br>";
}
?>
<br>
Done...
<br>
<br />

<a href="index.php">[<?php phpdigPrnMsg('back'); ?>]</a> <?php phpdigPrnMsg('to_admin'); ?>.
</body>
</html>
