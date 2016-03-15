<script language="javascript" type="text/javascript">
<!--

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETECAT?>"))
   	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&cid="+ID+"&action=delete&alphabetFilter=<?=$_REQUEST['alphabetFilter']?>";
}

function addCampaign()
{
	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=add&alphabetFilter=<?=$_REQUEST['alphabetFilter']?>";
}

function viewCampaign(ID)
{
	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=view&alphabetFilter=<?=$_REQUEST['alphabetFilter']?>";
}

function editCampaign(ID)
{
	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=edit&alphabetFilter=<?=$_REQUEST['alphabetFilter']?>&cid="+ID;
}

function viewBanners(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&campaign="+ID;
}

function filterByAlphabet(ID)
{
	frm = document.getElementById("FilterForm");
	frm.alphabetFilter.value = ID;
	
	frm.submit();
}

//-->
</script>

    <form id="FilterForm" name="FilterForm" action="index.php" method="get">
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(10); ?>    
    <tr>
      <td valign=top>
      		<?=L_G_PCNAME?>&nbsp;
      </td>
      <td valign=top>
      		<input type=text name=f_cname size=10 value="<?=$_REQUEST['f_cname']?>">
      </td>
      <td valign=top>
      		&nbsp;&nbsp;<?=L_G_CAMPAIGNTYPE?>&nbsp;
      </td>
      <td>
          	<? $this->a_Auth->getCommissionTypeSelect('f_ctype[]', $_REQUEST['f_ctype']) ?>
      </td>
      <td valign="top" align="right">
      		&nbsp;&nbsp;Alphabet Filter: <input type="text" name="alphabetFilter" size="5" id="alphabetFilter" value="<?=$_REQUEST['alphabetFilter']?>" readonly><br><small>(Select letter below to activate)</small>
      </td>
    </tr>
    <tr>
      <td colspan="5" align=center>&nbsp;<input type=submit class=formbutton value='<?=L_G_SEARCH?>'></td>
    </tr>
    <tr>
      <td colspan="5" height="10">&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='<?=$_REQUEST['md']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">    
    </form>

<br>

