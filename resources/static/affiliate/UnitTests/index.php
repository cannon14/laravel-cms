<?php
/**
 * 
 * ClickSuccess, L.P.
 * May 16, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 */ 
include('global.php');
require('phpunit/phpunit.php');
include('libs/Tester.class.php');

$class = 'tests/'. $_REQUEST['md'] .'.class.php';

?>
<link rel="stylesheet" href="phpunit/stylesheet.css" type="text/css"/>
<table>
<tr>
<td>
<img src='boom.jpeg'>
<h1>CCCOM Unit Testing Engine</h1>
<br>
Unit tests can be added to the affiliate/UnitTests/tests directory.  If you need help email me, patrick.mizer@creditcards.com.
</td>
</tr>
</table>
<br><br>
<form>
<select name='md'>
<?PHP
$dir = opendir("tests/");

while($filename = readdir($dir)){
	if(is_file('tests/'.$filename) && ($filename != '..' && $filename != '.')){
		$name = explode(".",$filename);
		$name = $name[0];
		$files[] = $name;
	}
}
	sort($files);
	foreach($files as $name){
	?>
		<option <?=(($_REQUEST['md'] == $name) ? "Selected" : "")?>><?=$name?></option>
	<?PHP
	}
?>
</select>

  <input type="submit" name="test" value="TEST"/>
  
  
</form>

<?PHP
if(is_file($class)){
	
	require($class);
	
	$tester =& new Tester($class);
	$tester->run();
	echo "<br><br><h2>Test Code</h2><font size=3>";
	$tester->printCode();
	echo "</font>";
}
?>

