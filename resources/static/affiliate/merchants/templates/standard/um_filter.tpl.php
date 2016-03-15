<script type="text/javascript" language="javascript">
<!--

function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?=L_G_CONFIRMSUPPRESSAFF?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action;
  }    
  else if(action == "approve")
  {
    if(confirm("<?=L_G_CONFIRMAPPROVEAFF?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action="+action;
  }
}

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETEAFF?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action=delete";
}

function ChangeCommCat(ID)
{
    document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action=changecommcat";
}

function showTree()
{
 	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=showtree";
}

function accountingDetails(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&aid="+ID+"&action=accounting";
}

function viewUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=view&aid="+ID,"AddUser","scrollbars=1, top=100, left=100, width=450, height=500, status=0")
    wnd.focus(); 
}

function editUser(ID)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=edit&aid="+ID,"AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addUser()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_AffiliateManager&action=add","AddUser","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function InviteIntoCampaign(ID)
{
  document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=invite&aid="+ID;
  //var wnd = window.open("index.php?md=Affiliate_Merchants_Views_AffiliateManager&action=invite&aid="+ID,"AddUser","scrollbars=1, top=100, left=100, width=400, height=300, status=0")
  //wnd.focus(); 
}

function filterByAlphabet(ID)
{
	frm = document.getElementById("FilterForm");
	frm.alphabetFilter.value = ID;
	
	frm.submit();
}

-->
</script>

    <form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(10); ?>
    <tr>
      <td>&nbsp;<?=L_G_NAME?>&nbsp;</td>
      <td><input type=text name=um_name size=20 value="<?=$_REQUEST['um_name']?>"></td>
      <td>&nbsp;<?=L_G_SURNAME?>&nbsp;</td>
      <td><input type=text name=um_surname size=20 value="<?=$_REQUEST['um_surname']?>">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;<?=L_G_AFFILIATEID?>&nbsp;</td>
      <td><input type=text name=um_aid size=20 value="<?=$_REQUEST['um_aid']?>"></td>
      <td><?=L_G_STATUS?>&nbsp;</td>
      <td>
        <select name=um_status>
          <option value='_'><?=L_G_ALLSTATES?></option>
          <option value=<?=AFFSTATUS_NOTAPPROVED?> <? print ($_REQUEST['um_status'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?=L_G_WAITINGAPPROVAL?></option>
          <option value=<?=AFFSTATUS_APPROVED?> <? print ($_REQUEST['um_status'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?=L_G_APPROVED?></option>
          <option value=<?=AFFSTATUS_SUPPRESSED?> <? print ($_REQUEST['um_status'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?=L_G_SUPPRESSED?></option>
        </select>
      </td>
    </tr>
    <tr><td align=left nowrap>&nbsp;<?=L_G_ROWSPERPAGE?>&nbsp;</td>
      <td>
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
      <td align="left" nowrap>Alphabet Filter<br />by Name Column</td>
      <td>
      	<input type="text" name="alphabetFilter" size="5" id="alphabetFilter" value="<?=$_REQUEST['alphabetFilter']?>" readonly><br><small>(Select letter below to activate)</small>
      </td>
    </tr>
    <tr>
      <td align=left nowrap>
        <?=L_G_SHOWSTATS?>
      </td>
   	  <td align=left>
       <input type="checkbox" name="showAffiliateStats"  <?=($_REQUEST['showAffiliateStats'] ? 'checked' : '')?>>
      </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>       
    <tr>
      <td colspan=4 align=center>&nbsp;<input type=submit class=formbutton value='Search'></td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_AffiliateManager'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=action name=action value=''>
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">

    <br>
