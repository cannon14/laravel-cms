<?PHP
	$message = $_POST['message'];
	$fileinfo = $_POST['fileinfo'];
	$map_array = $_POST['map_array'];
	$processurl = "index.php?md=Affiliate_Merchants_Views_CsvParser2";
?>
<html>
<head>
<script>
  function showDiv( id ) { 
    document.all.custom.style.visibility = 'hidden'; 
    document.all.standard.style.visibility = 'hidden'; 
    document.all.other.style.visibility = 'hidden'; 
    document.all.custom.value = ''; 
    document.all.standard.value = ''; 
    document.all.other.value = ''; 
    document.all[ id ].style.visibility = 'visible'; 
    document.all[ id ].focus(); 
  }

</script>
</head>
<body>
<table class=listing border=0 width=600 cellspacing=0>
<? QUnit_Templates::printFilter(10, "Statement Parser"); ?>
<tr>
<td>
<br>
<form name="fileSubmission" onsubmit="return validateOnSubmit()" action="<?=$processurl?>"  method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="upload">
	Upload CSV File: <input class=formbutton type="file" name="csv_file"  size="20">
	<input type="hidden" name="MAX_FILE_SIZE" value="3145728">
	<br><br>
	<input type="radio" name="input_op" value="standard" onClick="showDiv( 'standard' );"> Select Provider (Use Standard CSV Template):
	<select class=formbutton size="1" name="standard" style="visibility:hidden">
		<option selected>linkshare</option>
		<option>commission junction</option>
		<option>premier bank card</option>
		<option>leapfrog online</option>
		<option>edebitpay</option>
		<option>eufora</option>
    </select>
    
    <br><br>
    <input type="radio" name="input_op" value="custom" onClick="showDiv( 'custom' );"> Select Custom Mapped Template:
	<select class=formbutton size="1" name="custom" style="visibility:hidden">
    <?
    	foreach($map_array as $name){
    		echo "<option>" . $name ."</option>";		
    	}
    ?>
    </select>
    <br><br>
    <input type="radio" name="input_op" value="other" onClick="showDiv( 'other' );"> Select Other:
    <select class=formbutton size="1" name="other" style="visibility:hidden">
    <option>Upload Clicks</option>
    </select>
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
