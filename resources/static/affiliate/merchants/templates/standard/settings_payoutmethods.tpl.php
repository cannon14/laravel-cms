<script>
function addPayoutmethod()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Settings&action=add_new_payout_method","Payoutmethod","scrollbars=1, top=100, left=100, width=600, height=450, status=0")
    wnd.focus(); 
}

function editPayoutmethod(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Settings&action=edit_payout_method&pid="+ID,"Payoutmethod","scrollbars=1, top=100, left=100, width=600, height=450, status=0")
    wnd.focus(); 
}

function deletePayoutmethod(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEPAYOUTMETHOD?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_Settings&pid="+ID+"&action=delete_payout_methods";
}

function addPayoutmethodField(pID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Settings&action=add_new_payout_field&pid="+pID,"Payoutmethod","scrollbars=1, top=100, left=100, width=450, height=350, status=0")
    wnd.focus(); 
}

function editPayoutmethodField(pID,fID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Settings&action=edit_payout_field&pid="+pID+"&fid="+fID,"Payoutmethod","scrollbars=1, top=100, left=100, width=450, height=350, status=0")
    wnd.focus(); 
}

function deletePayoutmethodField(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEPAYOUTMETHODFIELD?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_Settings&fid="+ID+"&action=delete_payout_fields";
}
</script>

    <table width="100%" border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter2(4, L_G_PAYOUTMETHODSGENERAL); ?>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_MINPAYOUTOPTIONS;?></b></td>
      <td colspan=2><input type=text size=70 name=min_payout_options value="<?=$_POST['min_payout_options']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><? showHelp('L_G_HLPMINPAYOUTOPTIONS'); ?></td>
    </tr>
    <tr><td colspan=3>&nbsp;</td></tr>
    <tr>
      <td class=dir_form valign=top nowrap><b><?=L_G_INITIALMINPAYOUT?></b></td>
      <td colspan=2><input type=text size=20 name=initial_min_payout value="<?=$_POST['initial_min_payout']?>"></td>
    </tr>
    <tr>
      <td class=dir_form valign=top nowrap>&nbsp;</td>
      <td colspan=2><? showHelp('L_G_HLPINITIALMINPAYOUT'); ?></td>
    </tr>
    
    <? QUnit_Templates::printFilter2(4, L_G_PAYOUTMETHODS); ?>    
    <tr>
      <td colspan=3><? showHelp('L_G_HLPPAYOUTMETHODS'); ?></td>
    </tr>
    <tr>
        <td colspan=3>
          <table class='' border=0 cellspacing=0 cellpadding=1>
            <tr>
              <td class='' align=left colspan=4>
                &nbsp;<b><a class='mainlink' href="javascript:addPayoutmethod();"><?=L_G_ADD_PAYOUT_METHOD?></a></b>
              </td>
            </tr>    
        <? while($data=$this->a_list_data1->getNextRecord()) { ?>
            <tr class='' class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
              <td class='' align=left nowrap>&nbsp;<b><?=$data['name']?></b>&nbsp;&nbsp;&nbsp;</td>
              <td class='' align=left nowrap>&nbsp;&nbsp;<?=$data['langid']?>&nbsp;&nbsp;&nbsp;</td>
              <td nowrap>&nbsp;</td>
              <td nowrap>&nbsp;</td>
              <td class='' align=center nowrap>&nbsp;&nbsp;&nbsp;<? if($data['disabled'] == STATUS_ENABLED) echo L_G_ENABLED;
                                             else echo L_G_DISABLED;?> &nbsp;</td>
              <td class=''>
                <b><a class='mainlink' href="javascript:editPayoutmethod('<?=$data['payoptid']?>');"><?=L_G_EDIT?></a></b>&nbsp;&nbsp;
                <b><a class='mainlink' href="javascript:deletePayoutmethod('<?=$data['payoptid']?>');"><?=L_G_DELETE?></a></b>
              </td>
            </tr>
            <tr>
              <td class='' align=left colspan=3>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='mainlink' href="javascript:addPayoutmethodField('<?=$data['payoptid']?>');"><?=L_G_ADD_PAYOUT_FIELD?></a>
              </td>
            </tr>
            <? if(is_array($this->a_list_data2[$data['payoptid']])) { ?>
                <? foreach($this->a_list_data2[$data['payoptid']] as $field) { ?>
                    <tr class='' class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
                      <td class='' align=left nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$field['name']?>&nbsp;&nbsp;</td>
                      <td class='' align=left nowrap>&nbsp;&nbsp;<?=$field['langid']?>&nbsp;&nbsp;</td>
                      <td class='' align=left nowrap>&nbsp;&nbsp;<?=$field['code']?>&nbsp;&nbsp;</td>
                      <td class='' align=center nowrap>&nbsp;&nbsp;<? if($field['rtype'] == PAYOUTFIELD_TYPE_TEXT) echo L_G_TYPE_TEXT;
                                                     else echo L_G_SELECT;?> &nbsp;&nbsp;</td>
                      <td class='' align=center nowrap>&nbsp;&nbsp;<? if($field['mandatory'] == STATUS_ENABLED) echo L_G_MANDATORY;
                                                     else echo L_G_NO_MANDATORY;?> &nbsp;&nbsp;</td>

                      <td class='' align=right>
                        <a class='mainlink' href="javascript:editPayoutmethodField('<?=$data['payoptid']?>','<?=$field['payfieldid']?>');"><?=L_G_EDIT?></a>&nbsp;&nbsp;
                        <a class='mainlink' href="javascript:deletePayoutmethodField('<?=$field['payfieldid']?>');"><?=L_G_DELETE?></a>
                      </td>
                    </tr>
                <? } ?>
            <? } ?>
            
            <tr>
              <td class='' align=left colspan=3>
                &nbsp;
              </td>
            </tr>
            
        <? } ?>
          </table>
        </td>
    </tr>
    </table>
