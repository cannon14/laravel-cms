<script>


function createCard()
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CardDetailManager&action=create";
    
}
function editCard(ID)
{
	document.location.href = "index.php?md=Affiliate_Merchants_Views_CardDetailManager&action=edit&eid="+ID;
}

function deleteCard(ID)
{

  if(confirm("<?=L_G_CRM_CONFIRMDELETECARD?> - ID: "+ID))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CardManager&type=all&eid="+ID+"&action=delete";

}

function activateCard(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CardManager&type=all&eid="+ID+"&action=activate&active=1";
}

function deactivateCard(ID)
{
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_CardManager&type=all&eid="+ID+"&action=activate&active=0";
}
</script>
<form name=FilterForm id=FilterForm action=index.php method=get>
    <input type=hidden name=filtered value=1>
    <input type=hidden name=md value='Affiliate_Merchants_Views_CardManager'>
    <input type=hidden name=type value='all'>
    <input type=hidden id=list_page name=list_page value='<?=$_REQUEST['list_page']?>'>
    <input type=hidden id=action name=action value=''>    
    <input type=hidden id=sortby name=sortby value="<?=$_REQUEST['sortby']?>">
    <input type=hidden id=sortorder name=sortorder value="<?=$_REQUEST['sortorder']?>">
</form>
<br>