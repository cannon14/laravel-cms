<?PHP
	$message = $_POST['message'];
	$fileinfo = $_POST['fileinfo'];
	$map_array = $_POST['map_array'];
	$processurl = "index.php?md=Affiliate_Merchants_Views_ExpenseCsvParser2";
?>
<html>
<head>
</head>
<body>
<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "Expense Parser"); ?>
<tr>
<td>
<br>
<form name="fileSubmission" onsubmit="return validateOnSubmit()" action="<?=$processurl?>"  method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="upload">
	Upload CSV File: <input class=formbutton type="file" name="csv_file"  size="20">
	<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
	<br><br>
	
    <input class=formbutton type="submit" value="Submit CSV">
</form>
<br><br>
</td>
</tr>
</table>

<br>
<?if($fileinfo == null && $message != null){ ?>
<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "I/O Error"); ?>
<tr>
<td>
<?=$message?>
</td>
</tr>
</table>	
<? } ?>

<?if($fileinfo != null && $message != null){ ?>
<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, $fileinfo); ?>
<tr>
<td>
<?=$message?>
<br>
</td>
</tr>
</table>

<? } ?>
</body>
</html>
