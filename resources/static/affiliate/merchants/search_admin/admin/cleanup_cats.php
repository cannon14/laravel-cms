<?php
/*
programmer: christian lavender 03/06/2006
*/

$relative_script_path = '..';
$no_connect = 0;

include "$relative_script_path/includes/config.php";
include "$relative_script_path/libs/auth.php";
include "$relative_script_path/admin/robot_functions.php";


// [<ClickSuccess Edit>]
//*******************************************************************
// Here we populate the CCCOM category
// arrays and put them into an associative 
// array whose key is the category rank
// and value is the array of files which
// make up that category.
function fetchSpiderIDs($path, $array = null)
{
	$retArray = array();
	$sql = "SELECT spider_id FROM ".PHPDIG_DB_PREFIX."spider WHERE path = '" . $path . "'"; 
	
	if($array != null && (count($array) > 0)){
		$sql .= " AND file_path in " . "('".implode("','", $array)."')";
	}
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$retArray[] = $row['spider_id'];
	}
	return $retArray;
}

// For now we're using arrays here keep in mind that
// we can pull these from an external file or db later.

// You can add a weghted category in several ways.
// You can create a category by path (see indOffers)
// this will assign all pages in a particular path
// to a category.  You can further refine the pages
// by defining an array of pages to include (see mainCats).

$mainCats	 = array(	'low-interest.php', 
						'balance-transfer.php', 
						'instant-approval.php', 
						'reward.php', 
						'cash-back.php', 
						'airline-miles.php', 
						'business.php', 
						'college-students.php', 
						'prepaid.php', 
						'bad-credit.php', 
						'specials.php', 
						'Advanta.php', 
						'American-Express.php', 
						'Bank-of-America.php', 
						'Chase.php', 
						'Citi.php', 
						'Discover.php', 
						'first-premier.php', 
						'HSBC-Bank.php', 
						'Mastercard.php', 
						'Visa.php',
						'Capital-One.php'
					);

$mainCats = fetchSpiderIDs("", $mainCats);
$indOffers = fetchSpiderIDs("credit-cards/");

// Order them here.
$rankedCats = array( 
						1 => $mainCats,
						2 => $indOffers,
					);
					
//*******************************************************************

?>
<?php include $relative_script_path.'/libs/htmlheader.php' ?>
<head>
<title>CreditCards.com : Cleanup Site Categories</title>
<?php include $relative_script_path.'/libs/htmlmetas.php' ?>
</head>
<body bgcolor="white">
<h2><?php phpdigPrnMsg('Cleanup Site Categories'); ?></h2>
<?php
$locks = phpdigMySelect($id_connect,'SELECT locked FROM '.PHPDIG_DB_PREFIX.'sites WHERE locked = 1');
if (is_array($locks)) {
    phpdigPrnMsg('onelock');
}
else {
mysql_query('UPDATE '.PHPDIG_DB_PREFIX.'sites SET locked=1',$id_connect);

// [<ClickSuccess Edit>]
//*******************************************************************
$unionArray = array();
foreach($rankedCats as $rank => $array){
	
	if(count($array) < 1){
		$file_to_cat = "('')";
	}else
		$files_to_cat = "('".implode("','", $array)."')";
	
	$sql = "UPDATE ".PHPDIG_DB_PREFIX."spider SET site_cat=".$rank." WHERE spider_id IN ".$files_to_cat;
	echo "Updating category " . $rank . "...<br><br>";
	mysql_query($sql);
	
	$unionArray = array_merge($unionArray, $array);
}

$unionSql = "('".implode("','", $unionArray)."')";
$sql = "UPDATE ".PHPDIG_DB_PREFIX."spider SET site_cat=".++$rank." WHERE spider_id NOT IN ".$unionSql;	
echo "Updating everything else...<br><br>";
//echo $sql ."<br><br>";
mysql_query($sql);
//*******************************************************************


echo phpdigMsg('done');
mysql_query('UPDATE '.PHPDIG_DB_PREFIX.'sites SET locked=0',$id_connect);
}
?>
<br /><br />
<a href="index.php">[<?php phpdigPrnMsg('back'); ?>]</a> <?php phpdigPrnMsg('to_admin'); ?>.
<br /><br />

</body>
</html>