<script>

function buildSite(ID,layout){
 if(confirm("Are you sure you want to build this site? (ID: "+ID +")"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteManager&type=all&eid="+ID+"&action=build&layout="+layout;
}

function createSite()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteManager&action=create&type=all";
}
function editSite(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteManager&action=edit&eid="+ID,"Expense";
   
}

function deleteSite(ID)
{

  if(confirm("<?=L_G_CONFIRMDELETEEXPENSE?> - ID: "+ID))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteManager&type=all&eid="+ID+"&action=delete";

}

function activateSite(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteManager&type=all&eid="+ID+"&action=activate&active=1";
}

function deactivateSite(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteManager&type=all&eid="+ID+"&action=activate&active=0";
}

function managePages(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteToPageManager&type=all&siteId="+ID;
}


</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_SiteManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>
<br>