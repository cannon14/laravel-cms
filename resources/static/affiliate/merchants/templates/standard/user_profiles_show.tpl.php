
<script>
function addUserProfile()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_UserProfiles&action=add_new","UserProfile","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
  wnd.focus(); 
}

function editUserProfile(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_UserProfiles&action=edit&upid="+ID,"UserProfile","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
  wnd.focus(); 
}

function deleteUserProfile(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEUSERPROFILE?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_UserProfiles&upid="+ID+"&action=delete";
}
</script>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
<? QUnit_Templates::printFilter(5, L_G_USER_PROFILES_MANAGER); ?>        
<? if($this->a_action_permission['add_new']) { ?>
    <tr>
      <td class=actionheader align=left colspan=5>
      <b><a class=mainlink href="javascript:addUserProfile();">&nbsp;<?=L_G_ADD_USER_PROFILE?></a></b>
      </td>
    </tr>
<? } ?>
    <tr class=tablelistheader>
      <td class=tablelistheader colspan=5 align=center>
<?    
  echo ($this->a_list_page>0 ? "<a href='javascript:FilterForm.list_page.value=0; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."FirstPage.gif>".($this->a_list_page>0 ? "</a>" : "")."&nbsp;&nbsp;";
  echo ($this->a_list_page>0 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_page-1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."PrevPage.gif>".($this->a_list_page>0 ? "</a>" : "")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo L_G_RECORDCOUNT.": ".$this->a_allcount."&nbsp;&nbsp;&nbsp;&nbsp;".L_G_PAGE." ".($this->a_list_page+1)." ".L_G_PAGEFROM." ".$this->a_list_pages."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo ($this->a_list_page<$this->a_list_pages-1 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_page+1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."NextPage.gif>".($this->a_list_page<$this->a_list_pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
  echo ($this->a_list_page<$this->a_list_pages-1 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_pages-1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."LastPage.gif>".($this->a_list_page<$this->a_list_pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
?> 
      </td>
    </tr>
    <tr class=tablelistheader>
<?
    QUnit_Templates::printHeader(L_G_ID, 'up.userprofileid');
    QUnit_Templates::printHeader(L_G_NAME, 'up.name');
    QUnit_Templates::printHeader(L_G_ACTIONS, '');
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>      
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['userprofileid']?>&nbsp;</td>
      <td class=listresultnocenter align=left nowrap>&nbsp;<?=$data['name']?>&nbsp;</td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <? if($this->a_action_permission['edit']) { ?>
               <option value="javascript:editUserProfile('<?=$data['userprofileid']?>');"><?=L_G_EDIT?></option>
          <? }
             if($this->a_action_permission['delete']) { ?>
               <option value="javascript:deleteUserProfile('<?=$data['userprofileid']?>');"><?=L_G_DELETE?></option>
          <? } ?>
        </select>
      </td>
    </tr>    
<?
    }
?>
    </table>
      <input type=hidden name=md value='Affiliate_Merchants_Views_UserProfiles'>
      <input type=hidden id=action name=action value=''>
      <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
      <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
    </form>
