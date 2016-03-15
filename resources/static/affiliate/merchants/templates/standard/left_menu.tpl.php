<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="leftMenuContent" valign="top">
  
<?
$permissions = $this->a_Auth->getPermissions();
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
            print '<table class="leftMenuTableOpened" id='. (($menuTable[0][0] == 'header') && (isset($menuTable[0][2])) ? $menuTable[0][2] : $uniq ) .' cellspacing="0" cellpadding="0">';
            
            $headerDrawn = false;
            $itemDrawn = false;
            $menuPart = '';
            
            // draw table content
            foreach($menuTable as $menuItem)
            {
                if($menuItem[0] == 'header')
                {
                    // draw header
                    $menuPart .= '<tr><td onclick="openMenuItems(\''. (isset($menuItem[2]) ? $menuItem[2] : $uniq ) .'\');"><table border=0 cellpadding="0" cellspacing="0" width="100%"><tr><td class="leftMenuHeaderLeft"></td><td class="leftMenuHeader"><img src="/affiliate/merchants/templates/standard/images/darrow.png" style="float: right;" alt="" />'.$menuItem[1].'</td><td class="leftMenuHeaderRight"></td></tr></table></td></tr><tr><td class="leftMenuTop"></td></tr>';
                    $headerDrawn = true;
                }
                else if ($menuItem[0] == 'child') 
                {
                    if(count($menuItem) == 2)
                    {
                        // no permission part
                        $link = $menuItem[1];
                    }
                    else
                    {
                        $permission = $menuItem[1];
                        $link = $menuItem[2];
                    }
                    
                    if($permission != '' && !in_array($permission, $permissions))
                        continue;
                        
                    if(!$itemDrawn)
                    {
                    	$menuPart .= '<tr><td><DIV class=menuTree><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                        $itemDrawn = true;
                    }
                    
                    if(!$headerDrawn)
                        $menuPart .= '<tr><td class="leftMenuTop"></td></tr>';
                        
                    // draw item
                    $menuPart .= '<tr><td class="leftMenuItem">'.$menuItem[1].'</td></tr>';
                }
                else // it is item
                {
                    if(count($menuItem) == 2)
                    {
                        // no permission part
                        $link = $menuItem[1];
                    }
                    else
                    {
                        $permission = $menuItem[1];
                        $link = $menuItem[2];
                    }
                    
                    if($permission != '' && !in_array($permission, $permissions))
                        continue;
                        
                    if(!$itemDrawn)
                    {
                    	$menuPart .= '<tr><td><DIV class=menuTree><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                        $itemDrawn = true;
                    }
                    
                    if(!$headerDrawn)
                        $menuPart .= '<tr><td class="leftMenuTop"></td></tr>';
                        
                    // draw item
                    $menuPart .= '<tr><td class="leftMenuItem">'.$link.'</td></tr>';
                }
            }
            
            if($itemDrawn)
            {
                print $menuPart;
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
