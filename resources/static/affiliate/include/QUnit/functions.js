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
  var buttons = document.getElementById("checkItemsButton");
  if(typeof(buttons) == 'undefined') return;
  if(buttons.length > 0)
  {
    for (var b = 0; b < buttons.length; b++)
    {
      if(checkboxState == true) {
        buttons[b].value = '[  ]';
      } else { 
        buttons[b].value = '[X]';
       }
    }
  } else {
    if(checkboxState == true) {
      buttons.value = '[  ]';
    }else{
      buttons.value = '[X]';
    }
  }
	selectAll();
}

var checkboxState = true;

function selectAll()
{
	var theElement = document.getElementById("itemschecked");
	var theForm = theElement.form;
	for(z=0; z<theForm.length;z++)
	{
		if(theForm[z].type == 'checkbox')
		{
			theForm[z].checked = checkboxState;
		}
	}
	
	checkboxState = checkboxState==false?true:false;
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

function createNewExpense()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_ExpensesUploadManager&action=create&type=all","Expense","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus();
}

function keywordsBatchAdd()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_KeywordsManager&action=batchAdd","Keywords","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
	wnd.focus();
}

function keywordsBatchDelete()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_KeywordsManager&action=batchDelete","Keywords","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus();
}

function keywordsSearch()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Merchants_Views_KeywordsManager&action=search","Keywords","scrollbars=1, top=100, left=100, width=600, height=500, status=0");
    wnd.focus();
}

function initCollapsedMenuItems()
{
	if(window.collapsedMenuItems)
	{	
		for(var i=0; i < collapsedMenuItems.length; i++)
		{
			openMenuItems(collapsedMenuItems[i]);
		}
	}
}