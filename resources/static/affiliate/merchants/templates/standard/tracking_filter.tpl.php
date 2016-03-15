<script>

function ChangeState(ID, action)
{
  if(action == "suppress")
  {
    if(confirm("<?=L_G_CONFIRMSUPPRESSAFF?>"))
     	document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateGroupsManager&gid="+ID+"&action="+action;
  }    
  else if(action == "approve")
  {
    if(confirm("<?=L_G_CONFIRMAPPROVEAFF?>"))
      document.location.href = "index.php?md=Affiliate_Merchants_Views_AffiliateGroupsManager&gid="+ID+"&action="+action;
  }
}

function Delete(ID, mode)
{
  if(confirm("<?=L_G_CONFIRMDELETEAFF?>"))
   	document.location.href = "index.php?md=Affiliate_Merchants_Views_TrackingManager&entryId="+ID+"&mode="+mode+"&action=delete";
}

function editRT(ID,mode)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TrackingManager&action=edit&entryId="+ID+"&mode="+mode,"AddRT","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addKeyword()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TrackingManager&action=add&mode=keywords","AddRT","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addPage()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TrackingManager&action=add&mode=pages","AddRT","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addTimeslot()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TrackingManager&action=add&mode=timeslots","AddRT","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addTracker()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TrackingManager&action=add&mode=trackers","AddRT","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addEpc()
{
   var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_TrackingManager&action=add&mode=epcedit","AddRT","scrollbars=1, top=100, left=100, width=500, height=500, status=0")
    wnd.focus(); 
}

function addTrackingView(listViewName)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ListViews&mode=<?=$_REQUEST['mode']?>&action=add&listViewName="+escape(listViewName),"EditView","scrollbars=1, top=100, left=100, width=550, height=500, status=0")
    wnd.focus(); 
}

function editTrackingView(ID, listViewName)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ListViews&mode=<?=$_REQUEST['mode']?>&action=edit&vid="+ID+"&listViewName="+escape(listViewName),"EditView","scrollbars=1, top=100, left=100, width=550, height=500, status=0")
    wnd.focus(); 
}

function deleteTrackingView(ID, listViewName, confirmText)
{
    if(confirm(confirmText))
    {
        var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ListViews&mode=<?=$_REQUEST['mode']?>&action=delete&vid="+ID+"&listViewName="+escape(listViewName),"EditView","scrollbars=1, top=100, left=100, width=200, height=100, status=0")
        wnd.focus();
    }
}

function submitTrackingView()
{
    FilterForm.submit();
}
</script>
 <form name="FilterForm" action="index.php" method="GET">
    <table class=listing border=0 width=400 cellspacing=0>
    <? QUnit_Templates::printFilter(2); ?>
    <tr>
      <td width=1% nowrap>&nbsp;Search by name or ID: &nbsp;</td>
      <td nowrap>&nbsp;
      <input type=text name=search size=35 value="<?=$_REQUEST['search']?>"></td>
    </tr>
    <tr>
    <td colspan=3 align=center>
    <br><br>
    <input class=formbutton value="search" type="submit">
    <br><br>
    </td>
    
    </tr>
    </table>
    <br><br>

    <input type="hidden" name="md" value="<?=$_REQUEST['md']?>">
    <input type="hidden" name="mode" value="<?=$_REQUEST['mode']?>">