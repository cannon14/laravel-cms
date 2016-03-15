<script>


function createSite(type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CategoryManager&action=create&type=all"+"&type="+type;
}
function editSite(ID, type)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CategoryManager&action=edit&eid="+ID+"&type="+type;
}

function deleteSite(ID, type)
{

  if(confirm("<?=L_G_CONFIRMDELETEEXPENSE?> - ID: "+ID))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CategoryManager&type=all&eid="+ID+"&action=delete"+"&type="+type;

}

function activateSite(ID, type)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CategoryManager&type=all&eid="+ID+"&action=activate&active=1"+"&type="+type;
}

function deactivateSite(ID, type)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CategoryManager&type=all&eid="+ID+"&action=activate&active=0"+"&type="+type;
}

function manageCards(ID, type)
{
	if(type == 0)
   		document.location.href = "index.php?md=Affiliate_Merchants_Views_SiteToPageManager&type=all&siteId="+ID+"&type="+type;
	else
		document.location.href = "index.php?md=Affiliate_Merchants_Views_ArticlePageToCategoryManager&type=all&siteId="+ID+"&type="+type;
}

</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_CategoryManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=type name=type value='<?=$_REQUEST['type']?>'>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>
<br>