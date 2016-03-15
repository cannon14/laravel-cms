<style type="text/css">
.suggest_link {
	background-color: #FFFFFF;
	padding: 2px 6px 2px 6px;
}

.suggest_link_over {
	background-color: #3366CC;
	padding: 2px 6px 2px 6px;
	color: #FFF;
}

#search_suggest {
	position: absolute; 
	background-color: #FFFFFF; 
	text-align: left; 
	border: 1px solid #000000;            
}
</style>
<script language="JavaScript" type="text/javascript" src="/affiliate/include/javascript/keyword_search_ajax.js"></script>

<script>
function addTransaction()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=create&type=all","Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function editTransaction(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TransactionManager&action=edit&tid="+ID,"Transaction","scrollbars=1, top=100, left=100, width=500, height=500, status=0");
    wnd.focus(); 
}

function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?=L_G_CONFIRMSUPPRESSTRANS?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action="+action;
  }
  else if(action == "approve")
  {
    if(confirm("<?=L_G_CONFIRMAPPROVETRANS?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action="+action;
  }
}

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETETRANS?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_TransactionManager&type=all&tid="+ID+"&action=delete";
}
</script>

    <form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 width=600 cellspacing=0>
    <? QUnit_Templates::printFilter(10); ?>
    
    
    

    
    
    <tr>
      <td width=1% nowrap>&nbsp;<?=L_G_AFFILIATE?>&nbsp;</td>
      <td>
      <select name=tm_userid>
        <option value="_"><?=L_G_ALL?></option>
<?    while($data=$this->a_list_users->getNextRecord()) { ?>
        <option value="<?=$data['userid']?>" <?=($_REQUEST['tm_userid'] == $data['userid'] ? 'selected' : '')?>><?=(($data['name']!='' || $data['surname']!='') ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?    } ?>      
      </select>
      </td>
      <td width=1% nowrap>&nbsp;<?=L_G_ORDERID?>&nbsp;</td>
      <td><input type=text name=tm_orderid size=10 value="<?=$_REQUEST['tm_orderid']?>"></td>
    </tr>
    <tr>
      <td valign=top>&nbsp;<?=L_G_TYPE?>&nbsp;</td>
      <td>
        <? $this->a_Auth->getCommissionTypeSelect('tm_transtype[]', $_REQUEST['tm_transtype'], false); ?>      
      </td>
      <td valign=top><?=L_G_STATUS?>&nbsp;</td>
      <td valign=top>
        <select name=tm_status>
          <option value='_'><?=L_G_ALLSTATES?></option>
          <option value=<?=AFFSTATUS_NOTAPPROVED?> <? print ($_REQUEST['tm_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?=L_G_WAITINGAPPROVAL?></option>
          <option value=<?=AFFSTATUS_APPROVED?> <? print ($_REQUEST['tm_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?=L_G_APPROVED?></option>
          <option value=<?=AFFSTATUS_SUPPRESSED?> <? print ($_REQUEST['tm_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?=L_G_SUPPRESSED?></option>
        </select>
      </td>      
    </tr>
    <tr>
      <td colspan=4 nowrap>&nbsp;<?=L_G_FROM?>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=tm_day1>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_day1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=tm_month1>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_month1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=tm_year1>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_year1'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>
      &nbsp;&nbsp;&nbsp;<?=L_G_TO?>&nbsp;
      <?
        print L_G_DAY;
        echo "&nbsp;<select name=tm_day2>";
        for($i=1; $i<=31; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_day2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_MONTH;
        echo "&nbsp;<select name=tm_month2>";
        for($i=1; $i<=12; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_month2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
        
        print L_G_YEAR;
        echo "&nbsp;<select name=tm_year2>";
        for($i=2003; $i<=$this->a_curyear; $i++)
          echo "<option value='$i' ".($i == $_REQUEST['tm_year2'] ? "selected" : "").">$i</option>\n";
        echo "</select>&nbsp;&nbsp;";
      ?>      
      </td>
    </tr>
    
            <tr>
        <td align=left>
        &nbsp;<?=L_G_CHANNEL?>
      </td>
      <td align=left>
        <select name=tm_channel>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->cid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['trackerId']?>' <?=($_REQUEST['tm_channel'] == $data['trackerId'] ? 'selected' : '')?>><?=$data['name']?> (<?=$data['trackerId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
      <td align=left>
        &nbsp;<?=L_G_EPISODE?>
      </td>
      <td align=left>
        
        <div style="float: right;" id="result_count"></div>
		<br />
		<input type="text" id="suggestTerm" name="search" size="25" value="<?=$_REQUEST['search']?>" title="Search Criteria" onkeyup="searchSuggest();" onclick="clearSearchPopup();" onblur="validateKeywordFields();" autocomplete="off"> &nbsp;&nbsp; Keyword ID: <input type="text" size="5" name="tm_episode" id="rt_keywordId" value="<?=$_REQUEST['tm_episode']?>" readonly>
		<br />
		<div id="search_suggest"></div>
        <br />
      </td>
    </tr>
    <tr>
       <td align=left>
        &nbsp;<?=L_G_TIMESLOT?>
      </td>
      <td align=left>
        <select name=tm_timeslot>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->eid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['timeslotId']?>' <?=($_REQUEST['tm_timeslot'] == $data['timeslotId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['timeslotId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td><td align=left>
        &nbsp;<?=L_G_EXIT?>
      </td>
      <td align=left>
        <select name='tm_exit'>
          <option value='_'><?=L_G_ALL?></option>
<?      while($data=$this->fid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['pageId']?>' <?=($_REQUEST['tm_exit'] == $data['pageId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['pageId']?>)</option>
<?      } ?>          
      

     </select>&nbsp;&nbsp;
      </td>
      
    </tr> 
       
    <tr>
      <td align=left nowrap>&nbsp;<?=L_G_ROWSPERPAGE?></td>
      <td>&nbsp;
      <select name=numrows onchange="javascript:FilterForm.list_page.value=0;">
        <option value=10 <? print ($_REQUEST['numrows']==10 ? "selected" : ""); ?>>10</option>
        <option value=20 <? print ($_REQUEST['numrows']==20 ? "selected" : ""); ?>>20</option>
        <option value=30 <? print ($_REQUEST['numrows']==30 ? "selected" : ""); ?>>30</option>
        <option value=50 <? print ($_REQUEST['numrows']==50 ? "selected" : ""); ?>>50</option>
        <option value=100 <? print ($_REQUEST['numrows']==100 ? "selected" : ""); ?>>100</option>
        <option value=200 <? print ($_REQUEST['numrows']==200 ? "selected" : ""); ?>>200</option>
        <option value=500 <? print ($_REQUEST['numrows']==500 ? "selected" : ""); ?>>500</option>
        <option value=1000 <? print ($_REQUEST['numrows']==1000 ? "selected" : ""); ?>>1000</option>
        <option value=100000000 <? print ($_REQUEST['numrows']==100000000 ? "selected" : ""); ?>><?=L_G_ALL?></option>
      </select>
      </td>
    </tr>       
    <tr>
      <td colspan=4 width=50% align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    <tr>
      <td colspan=4>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

<br>
