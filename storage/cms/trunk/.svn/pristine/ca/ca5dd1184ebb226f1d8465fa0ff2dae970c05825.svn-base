function goToMod(mod) { 	
	window.location = "index.php?mod=" + mod; 
}

function addView(listViewName)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ListViews&action=add&listViewName="+escape(listViewName),"EditView","scrollbars=1, top=100, left=100, width=550, height=500, status=0")
    wnd.focus(); 
}

function editView(ID, listViewName)
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ListViews&action=edit&vid="+ID+"&listViewName="+escape(listViewName),"EditView","scrollbars=1, top=100, left=100, width=550, height=500, status=0")
    wnd.focus(); 
}

function deleteView(ID, listViewName, confirmText)
{
    if(confirm(confirmText))
    {
        var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ListViews&action=delete&vid="+ID+"&listViewName="+escape(listViewName),"EditView","scrollbars=1, top=100, left=100, width=200, height=100, status=0")
        wnd.focus();
    }
}

function submitView()
{
    FilterForm.submit();
}

function performAction(sel)
{
  if(sel.value!='-')
  {
    eval(sel.value);
  }
  sel.selectedIndex = 0;
}

function checkAllItems()
{
  var checks = document.all("itemschecked");
  if(typeof(checks) == 'undefined') return;

  checkedAllItems = !checkedAllItems;
  
  if(checks.length > 0)
  {
    for (var b = 0; b < checks.length; b++)
    {
      if(checkedAllItems == true)
        checks[b].checked = true;
      else
        checks[b].checked = false;
    }
  }
  else
  {
    if(checkedAllItems == true)
      checks.checked = true;
    else
      checks.checked = false;
  }
  
  var buttons = document.all("checkItemsButton");
  if(typeof(buttons) == 'undefined') return;
  if(buttons.length > 0)
  {
    for (var b = 0; b < buttons.length; b++)
    {
      if(checkedAllItems == true)
        buttons[b].value = '[  ]';
      else
        buttons[b].value = '[X]';
    }
  }
  else
  {
    if(checkedAllItems == true)
      buttons.value = '[  ]';
    else
      buttons.value = '[X]';
  }
}


function addAffiliate()
{
	var wnd = window.open("index_popup.php?md=AffiliateManager&action=add","AddAffiliate","scrollbars=1, top=100, left=100, width=500, height=560, status=0");
    wnd.focus(); 
}

var treeopened = null;
function openMenuItems(myId) 
{
    if (document.getElementById) 
    {
        var elem = document.getElementById (myId);
        if (elem && elem.className) 
        {
            elem.className = (elem.className == 'leftMenuTableOpened') ? 'leftMenuTableClosed' : 'leftMenuTableOpened';
        }
    }
    
    return false;
}


function showListOptions()
{
	if(document.getElementById)
	{
			if(document.getElementById("view_av_options").style.display=="block")
			{
				document.getElementById("view_av_options").style.display="none";
			}
			else
			{
				document.getElementById("view_av_options").style.display="block";
			}
	}
}

function showPopupHelp(helpID)
{
	var wnd = window.open("index_popup.php?md=QUnit_Help_Help&hid="+helpID,"helpwnd","scrollbars=1, top=100, left=100, width=350, height=250, status=0");
    wnd.focus();
}

function showdiropt(chkbxName, fldName)
{
	var field = document.getElementById(fldName);
	var box = document.getElementById(chkbxName);
	if(box.checked)
   	field.style.display="";
	else
		field.style.display="none";
	return;
}
