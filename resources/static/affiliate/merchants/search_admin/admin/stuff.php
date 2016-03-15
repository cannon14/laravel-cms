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
<h2>STUFF</h2>
<?php
$sql = "SELECT * FROM ".PHPDIG_DB_PREFIX."spider";
$result = mysql_query($sql);
?>
<form action='stuff.php'>
<table>
<tr>
<td>	&nbsp;
Page:
</td>
<td>
<select name="spider_id">
    
<?PHP
while($row = mysql_fetch_assoc($result)){
?>
	<option <?if($_REQUEST['spider_id'] == $row['spider_id']){ echo "selected"; }?> value="<?=$row['spider_id']?>"><?=$row['path'].$row['file_path']?></option>  
<?PHP
}
?>
</select>
</td>
</tr>
<tr>
<td>
Keyword(s): 
</td>
<td>
 
<input type='text' name='keyword' value="<?=$_REQUEST['keyword']?>" maxlength="64" size='50'> <input type='submit' value='search'>
</td>
</tr>
</table>
<input type='hidden' name='formsent' value='1'>
</form>
<br><br>
<?PHP
if($_REQUEST['adjustweight']){
	
	foreach($_REQUEST as $k=>$v){
		if(substr($k, 0, 3) == "kw_"){
			
			$keyId = str_replace("_", ".", substr($k, 3, 64));
			
			$newWeight = $v;
			$spiderId = $_REQUEST['spider_id'];
			$crawledWeight = $_REQUEST['ow_'.$keyId];
			
			//first let's make sure the value changed.
			if($newWeight != $crawledWeight){
				
				if($crawledWeight == ""){
					$sql = "SELECT key_id FROM ". PHPDIG_DB_PREFIX. "keywords ORDER BY key_id DESC LIMIT 1";
					//echo $sql . "<br>";
					$result = mysql_query($sql) or die("Error");
					$row = mysql_fetch_assoc($result);
					$newKeyId = $row['key_id'];	
					
					$sql = "SELECT key_id FROM " . PHPDIG_DB_PREFIX."keywords WHERE key_id = '$keyId'";
					//echo $sql . "<br>";
					$result = mysql_query($sql);
					$row = mysql_fetch_assoc($result);
					if($row['key_id'] == ""){						
						$sql = "SELECT key_id FROM " . PHPDIG_DB_PREFIX."keywords WHERE keyword = '$keyId'";
						//echo $sql . "<br>";
						$result = mysql_query($sql);
						$row = mysql_fetch_assoc($result);
					}
					if($row['key_id'] == ""){
						
						
						$twoletters = substr($keyId, 0, 2); 
						//echo "Keyword: ".  $keyId . "<Br>";
						$newKeyId ++;
						$sql = "INSERT INTO ". PHPDIG_DB_PREFIX. "keywords (key_id, twoletters, keyword) VALUES ('$newKeyId', '$twoletters', '$keyId')";
						//echo $sql . "<br>";
						$result = mysql_query($sql) or die(mysql_error());
					
						$keyId = $newKeyId;
					}

				}
				
				//preserve crawledWeight
				$sql = "SELECT crawledweight FROM ". PHPDIG_DB_PREFIX."adjustedweights WHERE key_id = '$keyId' AND spider_id = '".$_REQUEST['spider_id']."'";
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if($row['crawledweight'] != null)
					$crawledWeight = $row['crawledweight'];
				
				//next we add this value to the adjusted weight table.
				$sql = "DELETE FROM ". PHPDIG_DB_PREFIX."adjustedweights WHERE key_id = '$keyId' AND spider_id = '".$_REQUEST['spider_id']."'";
				//echo $sql . "<br>";
				mysql_query($sql) or die("error");
				
				$sql = "INSERT INTO ". PHPDIG_DB_PREFIX."adjustedweights (key_id, spider_id, weight, crawledweight) VALUES ('$keyId', '$spiderId', '$newWeight', '$crawledWeight')";
				//echo $sql ."<br>";
				mysql_query($sql) or die("error");;
				
				//Then we increase the words weight in engine.
				$sql = "DELETE FROM ". PHPDIG_DB_PREFIX."engine WHERE key_id = '$keyId' AND spider_id = '".$_REQUEST['spider_id']."'";
				//echo $sql . "<br>";
				mysql_query($sql) or die("error");;
				
				$sql = "INSERT INTO ". PHPDIG_DB_PREFIX."engine (key_id, spider_id, weight) VALUES ('$keyId', '$spiderId', '$newWeight')";
				//echo $sql . "<br>";
				mysql_query($sql) or die("error");;
				
			}
		}
	}
	
}
if($_REQUEST['formsent']){
	$keywords = explode(" ", strtolower($_REQUEST['keyword']));
	$keywordSQL =  "('" . implode("','", $keywords) . "')";
	
	// Get page name
	$sql = "SELECT path, file_path FROM " . PHPDIG_DB_PREFIX."spider WHERE spider_id = " . $_REQUEST['spider_id'];
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$fileName = $row['path'].$row['file_path'];
	}
	// Getting keywords from table...
	$sql = "SELECT * FROM " . PHPDIG_DB_PREFIX."keywords WHERE keyword in " . $keywordSQL;
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$inTable[$row['keyword']] = $row['key_id'];
	}
	
	// Now we need to get the weights on this page... 
	$keys = array_values($inTable);
	$keysSQL = "('" . implode("','",$keys) . "')";
	$sql = 	"SELECT * FROM " . PHPDIG_DB_PREFIX."engine WHERE key_id in " . $keysSQL . " AND " .
			" spider_id = '" . $_REQUEST['spider_id'] . "'"; 
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$weight[$row['key_id']] = $row['weight'];
	}
	
	// Get top 5 weights for each word
	foreach($inTable as $word=>$currKey){
		$sql = 	"SELECT * FROM " . PHPDIG_DB_PREFIX . "engine as e, " . PHPDIG_DB_PREFIX .
				"spider as s WHERE (e.spider_id = s.spider_id) AND key_id = '$currKey' ORDER BY e.weight DESC LIMIT 5";
		//echo $sql. "<br>";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
			$topPages[$currKey][] = $row; 		
	}
	
	// Finally grab adjusted weights...
	$sql = 	"SELECT * FROM " . PHPDIG_DB_PREFIX."adjustedweights WHERE key_id in " . $keysSQL . " AND " .
			" spider_id = '" . $_REQUEST['spider_id'] . "'"; 
	//echo $sql;
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$crawled[$row['key_id']] = $row['crawledWeight'];
	}
?>
<form action='stuff.php'>
<table>
<tr>
<td valign='top'>
<table class="borderCollapse">
<tr>
<td colspan='3' class='greyFormDark' align='center'>
  <?=$fileName?>
  </td>
</tr>
<tr>
<td class='blueForm'>WORD</td><td class='blueForm'>CRAWLED WEIGHT</td><td class='blueForm'>ADJUSTED WEIGHT</td>
</tr>
<?PHP	
	
	foreach($keywords as $word){
		$originalWeight =$crawled[$inTable[$word]];
		if($originalWeight == ""){
			$originalWeight = $weight[$inTable[$word]];
		}
		if($inTable[$word] == null){
			$inTable[$word] = $word;
		}
?>
<tr>
		
		
		<td align='center' class='greyFormLight'><?=$word?></td>
		<td  align='center' class='greyFormLight'><?=$originalWeight?></td>
		<td  align='center' class='greyFormLight'><input type="text" name="kw_<?=$inTable[$word]?>" size='3' value="<?=$weight[$inTable[$word]]?>"/></td>
		<input type='hidden' name="ow_<?=$inTable[$word]?>" value="<?=$weight[$inTable[$word]]?>">
</tr>
<?PHP
	}
?>
	<tr>
	<td colspan='3' class='greyFormDark' align='center'>
	  <input type="submit" name="set" value="Set Values"/>
	  </td>
	</tr>
	<input type='hidden' value='<?=$_REQUEST['formsent']?>' name='formsent'>
	<input type='hidden' value='<?=$_REQUEST['spider_id']?>' name='spider_id'>
	<input type='hidden' value='<?=$_REQUEST['keyword']?>' name='keyword'>
	<input type='hidden' value='1' name='adjustweight'>
	</form>
	</table>
</td>
<td valign='top'>
	<table class="borderCollapse">
	<tr>
	<td align='center' colspan='2' class='greyFormDark'><b>
	Current Top Results
	</td>
	</tr>
<?PHP
	foreach($topPages as $key => $rowArray){
		
		$curWord = array_Search($key, $inTable);
		?>
		
		<tr>
		<td colspan=2 class='blueForm'><b>
		<?=$curWord ?>
		</td>
		</tr>
		<?PHP
		foreach($rowArray as $row){
		?>
		<tr>
		<td align='center' class='greyFormLight'><?=$row['path'].$row['file_path']?></td>
		<td align='center' class='greyFormLight'><?=$row['weight']?></td>
		</tr>
		<?PHP
		}
	}
	?> </table><br> <?PHP
}
?>
</tr>
</table>
<br>
<br />

<a href="index.php">[<?php phpdigPrnMsg('back'); ?>]</a> <?php phpdigPrnMsg('to_admin'); ?>.
</body>
</html>
