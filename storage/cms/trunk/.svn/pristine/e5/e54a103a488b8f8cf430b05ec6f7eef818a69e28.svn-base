<script>
function cancelAction(){
  	document.location.href = "index.php?mod=<?=$_REQUEST['mod']?>";
		
}
</script>

<form action=index.php>
<table class='component' align='center'>
<tr>
<td class='componentHead' colspan=2>
Update Merchant
</td>
</tr>
<tr>
	<td>Merchant name: </td>
	<td><input type="text" name="name" readonly value="<?=$this->data['merchantname']?>" size="60"/></td>
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
    $siteCodes = CMS_libs_Cards::getSiteCodes();                
    $numSiteCodes = $siteCodes->numRows();            
    ?>
      <input type="hidden" name="site_code" value="<?=$this->data['site_code']?>" />
      <select disabled="disabled" name="site_code_disabled">
         <option value="">-Select a site code-</option>
         <?                     
         while(!$siteCodes->EOF)
         {                    
            ?>
            <option value="<?= $siteCodes->fields['site_code']; ?>" <?= $this->data['site_code'] == $siteCodes->fields['site_code'] ? 'selected' : ''; ?>><?= $siteCodes->fields['site_description']; ?></option>
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
<input type=hidden name=action value="processUpdateMerchant">
<input type=hidden name=merchantid value="<?=$this->merchantid?>">
<input type="submit" value="Update Merchant">
<input type="button" onClick="javascript:cancelAction();" value="Cancel">
</td>
</tr>
</table>
</form>
