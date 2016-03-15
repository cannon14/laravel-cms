<script>
function changeSheet(action, sheet)
{
    var form = document.getElementById('myForm');
    var curSheet = document.getElementById('sheet');
    var md = document.getElementById('md');
    
    md.value = "Affiliate_Merchants_Views_ProductManager";
    curSheet.value = sheet;
     
    form.submit();
    
    //document.myForm.sheet.value = sheet;
    //document.myForm.md = "Affiliate_Merchants_Views_ProductManager";
    //document.myForm.submit();
}
</script>

  <form action=index.php name=myForm id='myForm' method=post>
  <table class=listing border=0 cellspacing=0 cellpadding=0>
  <? QUnit_Templates::printFilter(2, L_G_CAMPAIGNEDIT); ?>
  <tr>
    <td align=left>

      <table border=0 cellspacing=0 cellpadding=5>

        <tr>
          <td class=formBText colspan=1 valign=top align=left>ID:&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left>
           <b><?=$_POST['banner_id']?></b>
          </td>
        </tr>      
      
      <tr>
        <td align=left nowrap>
          <b><?=L_G_PCNAME;?></b>
        </td>
        <td align=left width="100%">
          <input type=text name=cname size=44 value="<?=$_POST['cname']?>">*
        </td>
      </tr>
      
        <tr>
          <td class=formBText colspan=1 valign=top align=left>Merchant:&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left>
            <SELECT name=merchant_id>
            <OPTION</OPTION>
            <?foreach($this->merchants as $id => $merchant){ ?>
            	<OPTION value='<?=$id?>' <?=($_POST['merchant_id'] == $id ? 'SELECTED' :  '')?> ><?=$merchant['short_name']?></OPTION>	
            <? }?>
            </SELECT>*
          </td>
        </tr>    
        
	    <tr>
	      <td class=formBText colspan=1 valign=top align=left><?=L_G_DESTURL;?></td>
	      <td class=formBText colspan=2 valign=top align=left>
	        <input type=text name=desturl size=44 value="<?=$_POST['desturl']?>">&nbsp;*
	      </td>
	    </tr>               
      <!--
      <tr>
        <td align=left nowrap>
          <?=L_G_COMPLETE_URL_BANNERS_IMAGE;?>
        </td>
        <td align=left>
          <input type=text name=banner_url size=44 value="<?=$_POST['banner_url']?>">
        </td>
      </tr>
      -->
      <tr>
        <td align=left valign=top nowrap>
          <b><?=L_G_CAMPAIGNTYPE;?></b>
        </td>
        <td align=left valign=top>
            <table border=0 cellspacing=1 cellpadding=0>
            <? if($this->a_Auth->getSetting('Aff_support_cpm_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="<?=TRANSTYPE_CPM?>" <?=(is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CPM, $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?=L_G_TYPECPM?></td>
            </tr>
            <? } ?>
            <? if($this->a_Auth->getSetting('Aff_support_click_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="<?=TRANSTYPE_CLICK?>" <?=(is_array($_POST['commtype']) ? (in_array(TRANSTYPE_CLICK, $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?=L_G_PERCLICK?></td>
            </tr>
            <? } ?>
            <? if($this->a_Auth->getSetting('Aff_support_sale_commissions') == '1' && $this->a_Auth->getSetting('Aff_support_lead_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="_" <?=(is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td><select name="commtype2">
                    <option value="<?=TRANSTYPE_SALE?>" <?=($_POST['commtype2'] == TRANSTYPE_SALE ? 'selected' : '')?>><?=L_G_PERSALE?></option>
                    <option value="<?=TRANSTYPE_LEAD?>" <?=($_POST['commtype2'] == TRANSTYPE_LEAD ? 'selected' : '')?>><?=L_G_PERLEAD?></option>
                    </select>
                </td>
            </tr>
            <? } else if($this->a_Auth->getSetting('Aff_support_sale_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="_" <?=(is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?=L_G_PERSALE?><input type=hidden name="commtype2" value="<?=TRANSTYPE_SALE?>"></td>
            </tr>
            <? } else if($this->a_Auth->getSetting('Aff_support_lead_commissions') == '1') { ?>
            <tr>
                <td><input type=checkbox name="commtype[]" value="_" <?=(is_array($_POST['commtype']) ? (in_array('_', $_POST['commtype']) ? 'checked' : '') : '')?>></td>
                <td>&nbsp;<?=L_G_PERLEAD?><input type=hidden name="commtype2" value="<?=TRANSTYPE_LEAD?>"></td>
            </tr>
            <? } ?>
            </table>
        </td>
      </tr>      
      <tr>
        <td align=left valign=top><?=L_G_CAMPAIGNSHORTDESCRIPTION?>&nbsp;&nbsp;</td>
        <td><input type=text name=shortdescription size=44 value='<?=$_POST['shortdescription']?>'></td>
      </tr>
      <tr>
        <td align=left valign=top><?=L_G_CAMPAIGNDESCRIPTION?>&nbsp;&nbsp;</td>
        <td><textarea name=description cols=70 rows=4><?=$_POST['description']?></textarea></td>
      </tr>

<? if($this->a_Auth->getSetting('Aff_forcecommfromproductid') == 'yes') { ?>
      <tr>
          <td align=left valign=top><?=L_G_ALLOWEDPRODUCTS?>&nbsp;&nbsp;<? //showPopupHelp(L_G_HLPALLOWEDPRODUCTS); ?>&nbsp;</td>
          <td><textarea name=products cols=86 rows=2><?=$_POST['products']?></textarea></td>
      </tr>
<? } ?>
      
      </table>
      <br>
  </td>
  </tr>
  <tr>
    <td align="left">
 
<? 
    // include tabs
    QUnit_Templates::drawTabs($this->a_tabs, $this->a_selectedTab, 1);
?>
<br>
    </td>
  </tr>
  <tr>
    <td align=left>     
<?
    if($_POST['action'] != 'add')
    {   
        echo $this->a_tabcontent;
    }
?>

    <table border=0 cellspacing=0 cellpadding=5>
    <tr>
      <td>
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md id='md' value='<?=$_REQUEST['md']?>'>
             <input type=hidden name=action id=action value=<?=$_POST['action']?>>
             <input type=hidden name=subact value=<?=$_POST['subact']?>>
             <input type=hidden name=cid value=<?=$_POST['cid']?>>
             <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
             <input type=hidden name=sheet id='sheet' value='<?=$_REQUEST['sheet']?>'>
             <input type=hidden name=subact value='<?=$_REQUEST['sheet']?>'>
             <? if($_REQUEST['sheet'] != 'performance_rules') { ?>
               <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
             <? } ?>
      </td>
    </tr>
    </table>
    </td>
  </tr>
  </table>
  </form>
