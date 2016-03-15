<script>
function editUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid="+ID,"AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function swapUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=swap&u1="+ID,"AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}
</script>
<table class=listing border=0 cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(1, L_G_TREEOFAFFILIATES); ?>
<? while($data=$this->a_list_data->getNextRecord()) { ?>
   <tr>
     <td align=left nowrap>
        &nbsp;<?=$data['tab'].'<i>'.$data['userid'].':</i> <b>'.
                $data['name'].' '.$data['surname'].' - '.$data['username'].'</b>'?>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <option value="javascript:editUser('<?=$data['userid']?>');"><?=L_G_EDIT?></option>
          <option value="javascript:swapUser('<?=$data['userid']?>');"><?=L_G_SWAP?></option>
        </select>
        &nbsp;
   </tr>
<? } ?>
</table>
