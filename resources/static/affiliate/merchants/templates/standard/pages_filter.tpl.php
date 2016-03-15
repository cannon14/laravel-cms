<script>


function createSite(type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_PageManager&action=create&type="+type+"&type="+type;
 
}
function editSite(ID, type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_PageManager&action=edit&eid="+ID+"&type="+type;
}

function deleteSite(ID, type)
{

  if(confirm("<?=L_G_CONFIRMDELETEEXPENSE?> - ID: "+ID))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_PageManager&type=all&eid="+ID+"&action=delete"+"&type="+type;

}

function activateSite(ID, type)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_PageManager&type=all&eid="+ID+"&action=activate&active=1"+"&type="+type;
}

function deactivateSite(ID, type)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_PageManager&type=all&eid="+ID+"&action=activate&active=0"+"&type="+type;
}

function manageCards(ID, type)
{
	if(type == 0)
   		document.location.href = "index.php?md=Affiliate_Merchants_Views_CardToPageManager&type=all&siteId="+ID+"&type="+type;
	if(type == 1)
		document.location.href = "index.php?md=Affiliate_Merchants_Views_ArticleToPageManager&type=all&siteId="+ID+"&type="+type;
}

</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_PageManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>
<br>