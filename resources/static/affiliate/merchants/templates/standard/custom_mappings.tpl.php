<?
$processurl = "index.php?md=Affiliate_Merchants_Views_CustomMappings";
$col_array = $_POST['line_array'];
?>
<?if($_POST['show'] == ""){ ?>
<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "Custom Template Generator"); ?>
<tr>
<td>
<form name="fileSubmission" action="<?=$processurl?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="upload">
	
	<br>Upload Template File (CSV):  
	<input class=formbutton type="file" name="map_file" size="20">
	<br>
	<br>
    <input class=formbutton type="submit" value="Submit CSV">
</form>
<br><br>
</td>
</tr>
</table>
<br>
<br>
<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "Custom Template Manager"); ?>
<tr>
<td>
<br>
<form name="manageMaps" action="<?=$processurl?>" method="post">
	Select Mapping: <select class=formbutton name='modName'>
		<option></option>
    	<?foreach($_POST['mapping_selector'] as $map){ ?>
    	<option <? print ($_REQUEST['mapping'] == $map ? 'selected' : '');?>><?=$map ?></option>
    	<? } ?>
    	</select>
    <br>
    <br>
    Select Action: <select class=formbutton name='modAction'>
    	<option></option>
    	<option>Modify</option>
    	<option>Delete</option>
    	<option>Export</option>
    	</select>
    <input type='hidden' name='action' value='manage'>
    <br>
    <br>
    <input class=formbutton type="submit" value="Submit">
</form>
<br><br>
</td>
</tr>
</table>
<br><br>

<?}?>

<?if($_POST['show'] == "modifymap"){ ?>

<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "Custom Template Generator"); ?>
<form name='custom' method='post' action="<?=$processurl?>" enctype="multipart/form-data">

<input type="hidden" name="action" value="modifymap">
<input type="hidden" name="oldmapid" value="<?=$_POST['mapname']?>">
<tr>
<td>
<br>
Template Name:
<br>
<input class=formbutton type='text' name='mapid' value='<?=$_POST['mapname']?>' size='30'>
<br>
</td>
</tr>
<?
$count = 0;
foreach($col_array as $col){
	if($col != ""){
		echo "<tr><td align='right'>" . $count . ": </td><td><br><select class=formbutton size='1' name='".$count."'>";
		echo $_POST['select_box'];
		if($col_array[$count] !=  null)
			echo "<option selected>" . $col_array[$count] . "</option>";
		echo "</select><br></td></tr>";
	}
	++ $count;
}
?>
<tr>
<td>
</td>
<td>
<br>
<br>
<input type="hidden" name="size" value="<?=$count?>">
<input class=formbutton type="submit" value="Submit Changes">
<br>
<br>
</td>
</tr>
</table>
</form>

<? } ?>

<?if($_POST['show'] == "buildmap"){ ?>

<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "Custom Template Generator"); ?>
<form name='custom' method='post' action="<?=$processurl?>" enctype="multipart/form-data">

<input type="hidden" name="action" value="createmap">
<tr>
<td>
<br>

Template Name:
<br>
<input class=formbutton type='text' name='mapid' size='30'>
<br>
</td>
</tr>
<?
$count = 0;
foreach($col_array as $col){
	if($col != ""){
		echo "<tr><td align='right'><br>" . $col . "(" . $count . "): </td><td><br><select class=formbutton size='1' name='".$count."'>";
		echo $_POST['select_box'];
		echo "</select><br></td></tr>";
	}
	++ $count;
}
?>
<tr>
<td>
</td>
<td>
<br>
<br>
<input type="hidden" name="size" value="<?=$count?>">
<input class=formbutton type="submit" value="Create Template">
<br>
<br>
</td>
</tr>
</table>
</form>
<?}?>