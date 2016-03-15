  <form action=index.php method=post>
  <table border=0 width=700>
  <tr>
    <td align=center>     

      <table class=listing width=100% border=0 cellspacing=0 cellpadding=3>
      <? QUnit_Templates::printFilter(2, L_G_CAMPAIGN) ?>
      <tr>
        <td align=center>
        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td class=formBText colspan=1 valign=top align=left>ID:&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left> 
            <input type=text name=banner_id MAXLENGTH=8 size=10 value="<?=$_POST['banner_id']?>">* (8 character max)
          </td>
        </tr>        
        <tr>
          <td class=formBText colspan=1 valign=top align=left>Product Name:&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left>
            <input type=text name=cname size=44 value="<?=$_POST['cname']?>">*
          </td>
        </tr>
        <tr>
          <td class=formBText colspan=1 valign=top align=left>Merchant:&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left>
            <SELECT name=merchant_id>
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
          <td colspan=4>&nbsp;</td>
        </tr>
        <tr>
          <td class=formText colspan=1 valign=top align=left><?=L_G_BANNERSURL;?>&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left>
            <input type=text name=banner_url size=44 value="<?=$_POST['banner_url']?>">
          </td>
        </tr>
        -->
        <tr>
          <td colspan=4>&nbsp;</td>
        </tr>
        <tr>
          <td colspan=1 align=left valign=top><?=L_G_SHORTDESCRIPTION?>&nbsp;&nbsp;</td><td class=formBText colspan=2 valign=top align=left>
            <input type=text name=shortdescription size=44 value='<?=$_POST['shortdescription']?>'>
          </td>
        </tr>
        <tr>
          <td class=formText valign=top align=left><?=L_G_DESCRIPTION;?>&nbsp;&nbsp;</td>
          <td class=formText colspan=3 valign=top align=left>
            <textarea name=description cols=70 rows=4><?=$_POST['description']?></textarea>
          </td>
        </tr>
        <tr>
          <td colspan=4>&nbsp;</td>
        </tr>
        <tr>
          <td class=formText valign=top>
          <?=L_G_COOKIELIFETIME;?>
          </td>
          <td valign=top><input type=text name=cookielifetime size=2 value="<?=$_POST['cookielifetime']?>">*&nbsp;<?=L_G_DAYS?>&nbsp;&nbsp;<br>
          <? showMsgNoBR(L_G_COOKIEMSG,'ok'); ?>
          </td>
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
                <td><input type=checkbox name="commtype[]" value="_" checked ></td>
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
          <td class=formText valign=top>
          <?=L_G_TRANSCLICKAPPROVAL;?>
          </td>
          <td valign=top>      
          <select name=clickapproval>
            <option value="<?=APPROVE_AUTOMATIC?>" <? print ($_POST['clickapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?=L_G_AUTOMATIC?></option>
            <option value="<?=APPROVE_MANUAL?>" <? print ($_POST['clickapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?=L_G_MANUAL?></option>
          </select>
          </td>
          <td class=formText valign=top>
          <?=L_G_TRANSSALEAPPROVAL;?>
          </td>
          <td valign=top>
          <select name=saleapproval>
            <option value="<?=APPROVE_AUTOMATIC?>" ><?=L_G_AUTOMATIC?></option>
            <option value="<?=APPROVE_MANUAL?>" selected ><?=L_G_MANUAL?></option>
          </select>
          &nbsp;&nbsp;
          </td>
        </tr>
        <tr>
          <td class=formText valign=top>
          <?=L_G_AFFILIATE_APPROVAL;?>
          </td>
          <td valign=top>      
          <select name=affapproval>
            <option value="<?=APPROVE_AUTOMATIC?>" <? print ($_POST['affapproval'] == APPROVE_AUTOMATIC ? 'selected' : '');?>><?=L_G_AUTOMATIC?></option>
            <option value="<?=APPROVE_MANUAL?>" <? print ($_POST['affapproval'] == APPROVE_MANUAL ? 'selected' : '');?>><?=L_G_MANUAL?></option>
          </select>
          </td>
          <? if($this->a_Auth->getSetting('Aff_join_campaign') == '1') { ?>
          <td class=formText valign=top><?=L_G_STATUS;?></td>
          <td valign=top>
            <select name=status>
              <option value="<?=AFF_CAMP_PUBLIC?>" <? print ($_POST['status'] == AFF_CAMP_PUBLIC ? 'selected' : '');?>><?=L_G_PUBLIC?></option>
              <option value="<?=AFF_CAMP_PRIVATE?>" <? print ($_POST['status'] == AFF_CAMP_PRIVATE ? 'selected' : '');?>><?=L_G_PRIVATE?></option>
            </select>
            &nbsp;&nbsp;
          </td>
          <? } else { ?>
          <td colspan=2>&nbsp;</td>
          <? } ?>
        </tr>
        <? if($this->a_Auth->getSetting('Aff_join_campaign') == '1') { ?>
        <tr>
          <td class=formText valign=top><?=L_G_SIGNUP_BONUS;?></td>
          <td valign=top>
            <input type=text name=signup_bonus value="<?=$_POST['signup_bonus']?>">
          </td>          
        </tr>
        <? } ?>
<? if($this->a_Auth->getSetting('Aff_forcecommfromproductid') == 'yes') { ?>         
        <tr>
          <td class=formText valign=top colspan=4>
          <?=L_G_ALLOWEDPRODUCTS?>&nbsp;<? showPopupHelp(G_HLPALLOWEDPRODUCTS); ?>
          </td>
        </tr>
        <tr>
          <td class=formText valign=top colspan=4>
          <textarea name=products cols=86 rows=2><?=$_POST['products']?></textarea>
          </td>
        </tr>
<? } ?>
       <tr>
         <td colspan="2">&nbsp;</td>
         <td valign=top>
            EPC Rate Override
          </td>
          <td valign=top>
            <?
            if(!isset($_POST['epc_rate_override']))
            {
               $epc_rate_override = 0;
            }
            else
            {
               $epc_rate_override = $_POST['epc_rate_override'];
            }            
            ?>
            <input type="text" name="epc_rate_override" size="8" maxlength="8" value="<?=$epc_rate_override; ?>">
          </td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>          
          <td valign=top>
            Use EPC Override
          </td>
          <td valign=top>
            <?
            if(!isset($_POST['use_override']) || (isset($_POST['use_override']) && $_POST['use_override']== 1))
            {
               $checked = 'checked';               
            }
            else
            {
               $checked = '';
            }            
            ?>
            <input type="checkbox" name="use_override" <?=$checked; ?> value="1">
          </td>
         </tr>
        </table>
        </td>
      </tr>

<? 
if($_POST['action'] != 'add')
{
    echo $this->a_commissions;
}
?>

      </table>
      

      
<? if($_POST['postaction'] != 'addcampaign') { ?>
      <br>
      <table class=tableresult width=100% border=0 cellspacing=0 cellpadding=3>
      <tr>
        <td class=header align=center colspan=2><?=L_G_COMMISIONS?></td>
      </tr>
      <tr>
        <td align=center>
<?
echo $this->a_campcategories;
?>
        </td>
      </tr>
      </table>
      <br><br>
      
<? } ?>

    </td>
  </tr>
  
        <tr>
          <td colspan=4 align=center >
             <input type=hidden name=commited value=yes>
             <input type=hidden name=md value='<?=$_REQUEST['md']?>'>
             <input type=hidden name=type value='text'>
             <input type=hidden name=action value=<?=$_POST['action']?>>
             <input type=hidden name=cid value=<?=$_POST['cid']?>>
             <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
             <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
          </td>
        </tr>    
    </table>
    </form>
