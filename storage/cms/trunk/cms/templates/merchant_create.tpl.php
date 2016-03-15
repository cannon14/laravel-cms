<script>
function cancelAction(){
  	document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>";
		
}

var ccxMerchants = new Array();

<?

$cmsMerchants = array();
foreach ($this->merchants as $merchant) {
	$cmsMerchants[$merchant["merchantid"]] = $merchant;
}

foreach ($this->ccxmerchants as $merchant) {
	$cmsMerchant = $cmsMerchants[ $merchant["issuer_id"] ];
	if ( empty($cmsMerchant) ) {
		echo 'ccxMerchants[' . $merchant["issuer_id"] . '] = new Array("' . $merchant["name"] . '","' . $merchant["logo"] . '","' . $merchant["site_code"] . '");';
	}
}

?>

function fillMerchantData() {
	form = document.getElementById("cms_add_merchant");
	importMerchantId = form.ccx_issuer_id.value
	form.name.value = ccxMerchants[importMerchantId][0];
	form.logo.value = ccxMerchants[importMerchantId][1];
	form.site_code.value = ccxMerchants[importMerchantId][2];
	form.site_code_disabled.value = ccxMerchants[importMerchantId][2];
}
</script>
<form id="cms_add_merchant" action=index.php>
<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=2>
Add Merchant
</td>
</tr>
<tr>
<td>Import Merchant: </td>
<td>
<select name="ccx_issuer_id" style="width:270px;" onchange="fillMerchantData();">
<option value="0">- Select -</option>
<?

foreach ($this->ccxmerchants as $merchant) {
	$cmsMerchant = $cmsMerchants[ $merchant["issuer_id"] ];
	if ( empty($cmsMerchant) ) {
		echo '<option value="' . $merchant["issuer_id"] . '">' . $merchant["name"] . '</option>';
	}
}

?>
</select>
</td>
</tr>
<tr>
<td>Merchant Name: </td>
<td><input type="text" name="name" readonly value="<?=$_REQUEST['name']?>" size="60"/></td>
</tr>
<tr>
    <td>Merchant Card Page: </td>
    <td>
    	<select name="cardpage">
    	<?while($this->pages && !$this->pages->EOF){?>
    		<?$selected = $this->pages->fields['cardpageId']==$this->data['merchantcardpage']?'selected':''?>
    		<option value="<?=$this->pages->fields['cardpageId']?>" <?=$selected?>><?=$this->pages->fields['pageName']?></option>
    	<?$this->pages->MoveNext();}?>
    </td>
</tr>
<tr>
    <td>Merchant Category: </td>
    <td>
    	<select name="category_id">
    	<? foreach ($this->categories as $category) { ?>
    		<?$selected = $category['card_category_id']==$this->data['category_id']?'selected':''?>
    		<option value="<?=$category['card_category_id']?>" <?=$selected?>><?=$category['card_category_name']?></option>
    	<? } ?>
    </td>
</tr>
<tr>
	<td>Merchant logo: </td>
	<td><input type="text" name="logo" readonly value="<?=$this->data['logo']?>" size="60"/></td>
</tr>
<tr>
	<td>Site Code: </td>
    <td align="left">  
    <?
    if(isset($_POST['site_code']))
    {
      $siteCode = $_POST['site_code'];                  
    }
    else
    {
      $siteCode = '';
    }
                         
    $siteCodes = CMS_libs_Cards::getSiteCodes();                
    $numSiteCodes = $siteCodes->numRows();            
    ?>
      <input type="hidden" name="site_code" value="<?=$siteCode?>" />
      <select readonly name="site_code_disabled">
         <option value="">-Select a site code-</option>
         <?                     
         while(!$siteCodes->EOF)
         {                    
            ?>
            <option value="<?= $siteCodes->fields['site_code']; ?>" <?= $siteCode == $siteCodes->fields['site_code'] ? 'selected' : ''; ?>><?= $siteCodes->fields['site_description']; ?></option>
            <?
            $siteCodes->moveNext();
         }                                         
         ?>
      </select>                          
    </td>
</tr>
<tr>
<td colspan=2 align='center'>
<input type=hidden name=mod value="<?=$_REQUEST['mod']?>">
<input type=hidden name=action value="processCreateMerchant">
<input type="submit" value="Add Merchant">
<input type="button" onClick="javascript:cancelAction();" value="Cancel">
</td>
</tr>
</table>
</form>