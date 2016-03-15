<script>
function viewMessage(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_Communications&action=view&mid="+ID;
}

function editMessage(ID)
{
  var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_Communications&action=edit&mid="+ID,"Communication","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
  wnd.focus();
}

function deleteMessage(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEMESSAGE?>"))
    document.location.href = "index.php?md=Affiliate_Merchants_Views_Communications&mid="+ID+"&action=delete";
}
</script>

    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <tr>
      <td class=listheader colspan=8 align=center>
<?
  echo ($this->a_list_page>0 ? "<a href='javascript:FilterForm.list_page.value=0; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."FirstPage.gif>".($this->a_list_page>0 ? "</a>" : "")."&nbsp;&nbsp;";
  echo ($this->a_list_page>0 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_page-1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."PrevPage.gif>".($this->a_list_page>0 ? "</a>" : "")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo L_G_RECORDCOUNT.": ".$this->a_allcount."&nbsp;&nbsp;&nbsp;&nbsp;".L_G_PAGE." ".($this->a_list_page+1)." ".L_G_PAGEFROM." ".$this->a_list_pages."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
  echo ($this->a_list_page<$this->a_list_pages-1 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_page+1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."NextPage.gif>".($this->a_list_page<$this->a_list_pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
  echo ($this->a_list_page<$this->a_list_pages-1 ? "<a href='javascript:FilterForm.list_page.value=".($this->a_list_pages-1)."; FilterForm.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."LastPage.gif>".($this->a_list_page<$this->a_list_pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
?>
      </td>
    </tr>
    
    <tr class=listheader>
<?
    QUnit_Templates::printHeader(L_G_ID, 'm.messageid');
    QUnit_Templates::printHeader(L_G_CREATED, 'm.dateinserted');
    QUnit_Templates::printHeader(L_G_TITLE, 'm.title');
    QUnit_Templates::printHeader(L_G_MESSAGE_TEXT, 'm.rtext');
    if($this->a_Auth->getSetting('Aff_display_news') == '1') {
        QUnit_Templates::printHeader(L_G_HISTORYTYPE, 'm.rtype');
    }
    QUnit_Templates::printHeader(L_G_RECIPIENT, 'users_count');
    QUnit_Templates::printHeader(L_G_EMAIL, 'mu.email');
    QUnit_Templates::printHeader(L_G_ACTIONS);
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult>&nbsp;<?=$data['messageid']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['dateinserted']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;<?=$data['title']?>&nbsp;</td>
      <td class=listresult nowrap>&nbsp;
      <? 
      $pos = strrpos($data['rtext'], "\\");
      if($pos !== false)
        $file = substr($data['rtext'], $pos+1);
      else
        $file = $data['rtext'];

      $pos = strrpos($file, '/');
      if($pos !== false)
        $file = substr($file, $pos+1);

      if(strlen($file) > 30) $file = substr($file,0,30).' ...';

      print $file;
      ?>
      &nbsp;
      </td>
      <? if($this->a_Auth->getSetting('Aff_display_news') == '1') { ?>
        <td class=listresult nowrap>&nbsp;
        <? if($data['rtype'] == MESSAGETYPE_EMAIL) print L_G_EMAIL; 
           else if($data['rtype'] == MESSAGETYPE_NEWS) print L_G_NEWS;
           else print L_G_UNKNOWN_TYPE;
        ?>
        &nbsp;
        </td>
      <? } ?>
      <td class=listresult>&nbsp;
        <?
          if($data['users_count'] > 1) print L_G_MULTIPLE;
          else if($data['users_count'] > 0) print $this->a_message_users[$data['messageid']][$data['messagetouserid']]['userid'].': '.$this->a_message_users[$data['messageid']][$data['messagetouserid']]['name'].' '.$this->a_message_users[$data['messageid']][$data['messagetouserid']]['surname'];
        ?>
        &nbsp;
      </td>
      <td class=listresult nowrap>&nbsp;
        <?
          if($data['users_count'] > 1) print L_G_MULTIPLE;
          else if($data['users_count'] > 0) print $this->a_message_users[$data['messageid']][$data['messagetouserid']]['email'];
        ?>
        &nbsp;
      </td>
      <td class=listresult>
        <select name=action_select OnChange="performAction(this);">
          <option value="-">------------------------</option>
          <? if($this->a_action_permission['view']) { ?>
               <option value="javascript:viewMessage('<?=$data['messageid']?>');"><?=L_G_VIEW?></option>
          <? }
             if($data['rtype'] == MESSAGETYPE_NEWS && $this->a_action_permission['edit']) { ?>
               <option value="javascript:editMessage('<?=$data['messageid']?>');"><?=L_G_EDIT?></option>
          <? }
             if($this->a_action_permission['delete']) { ?>
               <option value="javascript:deleteMessage('<?=$data['messageid']?>');"><?=L_G_DELETE?></option>
          <? } ?>
        </select>
      </td>
    </tr>      
<?
    }
?>
  </table>
  </form>
  
  <br>
