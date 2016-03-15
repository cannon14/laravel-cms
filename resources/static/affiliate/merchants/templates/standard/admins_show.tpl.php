<script>
function addAdmin()
{
<? if($_POST['show_no_popup'] == '1') { ?>
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=add_new";
<? } else { ?>
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AdminsManager&action=add_new","Admin","scrollbars=1, top=100, left=100, width=500, height=300, status=0")
    wnd.focus();
<? } ?>
}

function editAdmin(ID)
{
<? if($_POST['show_no_popup'] == '1') { ?>
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit&aid="+ID;
<? } else { ?>
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit&aid="+ID,"Admin","scrollbars=1, top=100, left=100, width=500, height=550, status=0")
    wnd.focus();
<? } ?>
}

function deleteAdmin(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEADMIN?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&aid="+ID+"&action=delete";
}

function changeAdminStatus(ID)
{
  if(confirm("<?=L_G_CONFIRM_CHANGE_ADMIN?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AdminsManager&aid="+ID+"&action=change_status";
}
</script>
    <form name=FilterForm action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? if($this->a_action_permission['add_new']) { ?>
    <tr>
        <td class=actionheader align=left colspan=9>
            &nbsp;<b><a class=mainlink href="javascript:addAdmin();"><?=L_G_ADD_ADMIN?></a></b>
        </td>
    </tr>
    <? } ?>
    <tr>
      <td class=listheader colspan=9 align=center><?=L_G_LISTOFADMINS?>&nbsp;<? print " ( ".L_G_ROWS.": ".$this->a_numrows." )"; ?></td>
    </tr>
    <tr class=listheader>
<?
    QUnit_Templates::printHeader(L_G_ID, 'a.userid');
    QUnit_Templates::printHeader(L_G_USER_NAME, 'a.username');
    QUnit_Templates::printHeader(L_G_NAME, 'a.name');
    QUnit_Templates::printHeader(L_G_SURNAME, 'a.surname');
    QUnit_Templates::printHeader(L_G_ACCOUNT, 'account_name');
    QUnit_Templates::printHeader(L_G_USER_PROFILE, 'userprofile_name');
    QUnit_Templates::printHeader(L_G_STATUS, 'a.rstatus');
    QUnit_Templates::printHeader(L_G_JOINED, 'a.dateinserted');
    QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>
    <tr class=listresult class=row onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresultnocenter align=right nowrap><?=$data['userid']?></td>
      <td class=listresult nowrap>&nbsp;<?=$data['username']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['surname']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['account_name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['userprofile_name']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<? if($data['rstatus'] == STATUS_ENABLED) echo L_G_ENABLE;
                                     else echo L_G_DISABLE;?> &nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['dateinserted']?>&nbsp;</td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <? if($this->a_action_permission['edit']) { ?>
            <option value="javascript:editAdmin('<?=$data['userid']?>');"><?=L_G_EDIT?></option>
          <? } ?>
          <? if($this->a_Auth->getUserID() != $data['userid']) { 
               if($this->a_action_permission['delete']) {
          ?>
            <option value="javascript:deleteAdmin('<?=$data['userid']?>');"><?=L_G_DELETE?></option>
          <? } 
               if($this->a_action_permission['change_status']) {
          ?>
            <option value="javascript:changeAdminStatus('<?=$data['userid']?>');">
            <? if($data['rstatus'] == STATUS_ENABLED) echo L_G_DISABLE; else echo L_G_ENABLE; ?></option>
          <?   }
             }
          ?>
        </select>
      </td>
    </tr>    
<?
    }
?>
    </table>
      <input type=hidden name=md value='Affiliate_Merchants_Views_AdminsManager'>
      <input type=hidden id=action name=action value=''>
      <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
      <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
    </form>
