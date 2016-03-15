<script>
function customDynamicLink()
{
	var wnd = window.open("index_popup.php?md=Affiliate_Affiliates_Views_AffBannerManager&action=custdynamiclink","EditBanner","scrollbars=1, top=100, left=100, width=600, height=320, status=0")
    wnd.focus(); 
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="leftMenuContent" valign="top">
  
<?
if($this->a_Auth->isLogged()) 
{ 
    if(!isset($this->leftMenu) || !is_array($this->leftMenu))
        print 'NO MENU ARRAY FOUND';
    else
    {
        // draw menu
        foreach($this->leftMenu as $menuTable)
        {
            $uniq = md5(uniqid(""));

            // draw table
            print '<table class="leftMenuTableOpened" id='.$uniq.' cellspacing="0" cellpadding="0">';
            
            $headerDrawn = false;
            $itemDrawn = false;
            
            // draw table content
            foreach($menuTable as $menuItem)
            {
                if($menuItem[0] == 'header')
                {
                    // draw header
                    print '<tr><td onclick="openMenuItems(\''.$uniq.'\');"><table border=0 cellpadding="0" cellspacing="0" width="100%"><tr><td class="leftMenuHeaderLeft"></td><td class="leftMenuHeader"><img src="templates/standard/images/darrow.png" style="float: right;" alt="" />'.$menuItem[1].'</td><td class="leftMenuHeaderRight"></td></tr></table></td></tr><tr><td class="leftMenuTop"></td></tr>';
                    $headerDrawn = true;
                }
                else // it is item
                {
                    //print '<tr><td valign="top" align="left"><table border="0" cellspacing="0" cellpadding="0">';

                    if(!$itemDrawn)
                    {
                        print '<tr><td><DIV class=menuTree><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                        $itemDrawn = true;
                    }
                    
                    if(!$headerDrawn) {
                        print '<tr><td class="leftMenuTop"></td></tr>';
                    	$headerDrawn = true;
                    }
                        
                    // draw item
                    print '<tr><td class="leftMenuItem">'.$menuItem[1].'</td></tr>';
                }
            }
            
            if($itemDrawn)
            {
                print '<tr><td class="leftMenuBottom"></td></tr></table>';
                print '</div></td></tr></table>';
                
            }
            
            // spacer between menu tables
            print '<table width="100%" height="3" border="0" cellspacing="0" cellpadding="0"><tr><td></td></tr></table>';  
        }
    }
}
?>    

  </td>

</tr>
</table>
