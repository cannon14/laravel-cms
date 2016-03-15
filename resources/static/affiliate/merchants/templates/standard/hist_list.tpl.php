<script>
function purgeHistory()
{
  if(confirm("<?=L_G_CONFIRMPURGEHISTORY?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_History&action=purge";
}

function purgeSystemNotify(){
  if(confirm("<?=L_G_SYSTEM_NOTIFY_PURGE?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_History&action=purgeSystemNotify";	
}
</script>
    
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? if($this->a_action_permission['purge']) { ?>
      <tr>
        <td class=actionheader align=left colspan=10>
          &nbsp;<b><a class=mainlink href="javascript:purgeHistory();"><?=L_G_PURGEHISTORY?></a></b>&nbsp;|&nbsp;<b><a class=mainlink href="javascript:purgeSystemNotify();"><?=L_G_PURGESYSTEMNOTIFY?></a></b>
        </td>
      </tr>
    <? } ?>
    <tr>
      <td class=listheader colspan=11 align=center>
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
    QUnit_Templates::printHeader(L_G_HISTORYID, 'historyid');
    QUnit_Templates::printHeader(L_G_CREATED, 'dateinserted');
    QUnit_Templates::printHeader(L_G_HISTORYTYPE, 'rtype');
    QUnit_Templates::printHeader(L_G_LOGMSG, 'value');
    QUnit_Templates::printHeader(L_G_IP, 'ip');
    QUnit_Templates::printHeader(L_G_FILE, 'hfile');
    QUnit_Templates::printHeader(L_G_LINE, 'line');
?>    
    </tr>    
<?
    while($data=$this->a_list_data->getNextRecord())
    {
?>    
    <tr class=listresult onMouseover="this.className='listresultMouseOver'" onMouseOut="this.className='listresult';">
      <td class=listresult valign=top>&nbsp;<?=$data['historyid']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;<?=$data['dateinserted']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;
      <?
      switch($data['rtype'])
      {
        case WLOG_DBERROR :
            echo '<span class=style_log_dberror>'.L_G_LOG_DBERROR.'</span>';
        break;

        case WLOG_ERROR :
            echo '<span class=style_log_error>'.L_G_LOG_ERROR.'</span>';
        break;

        case WLOG_ACTIONS :
            echo '<span class=style_log_actions>'.L_G_LOG_ACTIONS.'</span>';
        break;

        case WLOG_DEBUG :
            echo '<span class=style_log_debug>'.L_G_LOG_DEBUG.'</span>';
        break;
        
        case 100 :
        	echo '<span class=style_log_debug>'.L_G_SYS_NOTIFY.'</span>';
        break;

        default :
            echo '<span class=style_log_default>'.L_G_LOG_DEBUG.'</span>';
        break;
      }
      ?>
      &nbsp;
      </td>
      <td class=listresultnocenter align=left valign=top>&nbsp;
      <?
      switch($data['rtype'])
      {
        case WLOG_DBERROR :
            echo '<span class=style_log_dberror>'.nl2br($data['value']).'</span>';
        break;

        case WLOG_ERROR :
            echo '<span class=style_log_error>'.nl2br($data['value']).'</span>';
        break;

        case WLOG_ACTIONS :
            echo '<span class=style_log_actions>'.nl2br($data['value']).'</span>';
        break;

        case WLOG_DEBUG :
            echo '<span class=style_log_debug>'.nl2br($data['value']).'</span>';
        break;
        
        default :
            echo '<span class=style_log_default>'.nl2br($data['value']).'</span>';
        break;
      }
      ?>
      &nbsp;
      </td>
      <td class=listresult valign=top nowrap>&nbsp;<?=$data['ip']?>&nbsp;</td>
      <td class=listresult valign=top nowrap>&nbsp;
      <? 
      $pos = strrpos($data['hfile'], "\\");
      if($pos !== false)
        $file = substr($data['hfile'], $pos+1);
      else
        $file = $data['hfile'];

      $pos = strrpos($file, '/');
      if($pos !== false)
        $file = substr($file, $pos+1);
      
      print $file;
      ?>
      &nbsp;
      </td>
      <td class=listresult valign=top nowrap>&nbsp;<?=$data['line']?>&nbsp;</td>
    </tr>      
<?
    }
?>
  </table>
  </form>
  
  <br>
