<script>

function filterByAlphabet(ID)
{
	frm = document.getElementById("FilterForm");
	frm.alphabetFilter.value = ID;
	
	frm.submit();
}

function Delete(ID)
{
  if(confirm("<?=L_G_CONFIRMDELETECAT?>"))
   	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&cid="+ID+"&action=delete";
}

function addCampaign()
{
	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=add";
}

function viewCampaign(ID)
{
	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=view";
}

function editCampaign(ID)
{
	document.location.href = "index.php?md=<?=$_REQUEST['md']?>&action=edit&cid="+ID;
}

function viewBanners(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_BannerManager&campaign="+ID;
}
</script>
    <table border=0 cellspacing=0>
    </table>
    <form name=FilterForm id=FilterForm action=index.php method=get>
    <table class=listing border=0 cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(10); ?>    
    <tr>
      <td valign=top><?=L_G_ADNAME?>&nbsp;</td>
      <td valign=top><input type=text name=f_cname size=10 value="<?=$_REQUEST['f_cname']?>"></td>
      <td valign=top><?=L_G_CAMPAIGNTYPE?>&nbsp;</td>
      <td>
          <? $this->a_Auth->getCommissionTypeSelect('f_ctype[]', $_REQUEST['f_ctype']) ?>
      </td>
    </tr>
    <tr>
      <td colspan=4 align=center>&nbsp;<input type=submit class=formbutton value='<?=L_G_SEARCH?>'></td>
    </tr>
    <tr>
      <td height=10>&nbsp;</td>
    </tr>
    </table>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='<?=$_REQUEST['md']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">    
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">   
    <input type="hidden" name="alphabetFilter" value="<?=$_REQUEST['alphabetFilter']?> ?>"/> 
    </form>

<br>

