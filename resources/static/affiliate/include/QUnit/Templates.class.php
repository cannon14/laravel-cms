<?

class QUnit_Templates
{
    /** includes template */
    function includeTemplate($file)
    {
        include($_SESSION[SESSION_PREFIX.'template'].'/'.$file);
    }  
    
    //-----------------------------------------------------------------------
    
    /** includes template */
    function printFilter($colspan = 1, $name = L_G_FILTER)
    {
        if(!is_numeric($colspan) && $name == L_G_FILTER) // there is name instead of colspan
        $GLOBALS['filtername'] = $colspan;
        else
        {
            $GLOBALS['colspan'] = $colspan;
            $GLOBALS['filtername'] = $name;
        }
        
        print '<tr>'.
        '<td class=tableheader colspan="'.$GLOBALS['colspan'].'">'.
        '<img src="'.$_SESSION[SESSION_PREFIX.'templateImages'].'farrow.png" border="10">&nbsp;'.
        '<b>'.$GLOBALS['filtername'].'</b>'.
        '</td>'.
        '</tr>';
        
        //include('..'.$_SESSION[SESSION_PREFIX.'template'].'/filter.tpl.php');
    }  
    
    //-----------------------------------------------------------------------
    
    /** includes template */
    function printFilter2($colspan = 1, $name = L_G_FILTER)
    {
        if(!is_numeric($colspan) && $name == L_G_FILTER) // there is name instead of colspan
        $GLOBALS['filtername'] = $colspan;
        else
        {
            $GLOBALS['colspan'] = $colspan;
            $GLOBALS['filtername'] = $name;
        }
        
        print '<tr>'.
        '<td class=tableheader2 colspan="'.$GLOBALS['colspan'].'">'.
        '<img src="'.$_SESSION[SESSION_PREFIX.'templateImages'].'farrow.png" border="10">&nbsp;'.
        '<b>'.$GLOBALS['filtername'].'</b>'.
        '</td>'.
        '</tr>';
        
        //include('..'.$_SESSION[SESSION_PREFIX.'template'].'/filter.tpl.php');
    } 
    
    //-----------------------------------------------------------------------
    
    /** prints table header. also enables sorting */
    function printHeader($name, $sortby = '', $css_class = '')
    {
        if($sortby == '' || $_REQUEST['type'] == 'print')
        {
            echo "<td class=".($css_class == '' ? 'listheader' : $css_class)." nowrap>&nbsp;$name&nbsp;</td>";
            return;
        }
        
        $neworder = 'desc';
        if($sortby == $_REQUEST['sortby'] && $_REQUEST['sortorder'] == 'desc')
        $neworder = 'asc';
        
        echo "<td class=".($css_class == '' ? 'listheader' : $css_class)." nowrap>&nbsp;<a href=\"javascript: FilterForm.sortby.value='$sortby'; FilterForm.sortorder.value='$neworder'; FilterForm.submit();\">$name</a>&nbsp;";
        
        if($sortby == $_REQUEST['sortby'] && $_REQUEST['sortorder'] == 'asc') 
        echo "<img src='".$_SESSION[SESSION_PREFIX.'templateImages']."sort_up_sel.gif' border=0>";
        else if ($sortby == $_REQUEST['sortby'] && $_REQUEST['sortorder'] == 'desc')
        echo "<img src='".$_SESSION[SESSION_PREFIX.'templateImages']."sort_down_sel.gif' border=0>";
        else
        echo "<img src='".$_SESSION[SESSION_PREFIX.'templateImages']."sort_down.gif' border=0>";
        
        echo "&nbsp;</td>";
    }
    
    //--------------------------------------------------------------------------
    
    function drawTabs($tabs, $selectedTab, $rows = 1, $strict = true)
    {
        if($rows <0 or $rows>5)
            $rows = 1;
            
        $tabArray = array();
        
        if($rows == 1)
            $tabArray[] = $tabs;
        else
        {
            // divide tabs into rows
            if($strict)
            {
                // divide according to number of tabs
                $tabsPerRow = count($tabs) / $rows;
                
                $count = 0;
                $tabsLine = array();
                foreach($tabs as $tab)
                {
                    if($count>= $tabsPerRow)
                    {
                        // put the tabs into line, and move to next line
                        $tabArray[] = $tabsLine;
                        $tabsLine = array();
                        $count = 0;
                    }

                    $tabsLine[] = $tab;
                    $count++;
                }
                
                if(count($tabsLine) > 0)
                    $tabArray[] = $tabsLine;
            }
            else
            {
                // divide according to string length of tabs
                $totalStrLen = 0;
                foreach($tabs as $tab)
                    $totalStrLen += strlen($tab);
                
                $charsPerRow = $totalStrLen / $rows;
                
                $lineStrLen = 0;
                $tabsLine = array();
                foreach($tabs as $tab)
                {
                    $lineStrLen += strlen($tab);
                    $tabsLine[] = $tab;
                    
                    if($lineStrLen >= $charsPerRow)
                    {
                        // put the tabs into line, and move to next line
                        $tabArray[] = $tabsLine;
                        $tabsLine = array();
                        $lineStrLen = 0;
                    }
                }
                
                if(count($tabsLine) > 0)
                    $tabArray[] = $tabsLine;
            }
        }
        
        print '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
        
        for($i=0; $i<$rows; $i++) 
        {
            if($i>0)
                print '<tr><td height="3" width="1" class="sideborders"><img src="'.$_SESSION[SESSION_PREFIX.'templateImages'].'blank.png" border="0" width="1" height="1"></td></tr>';

?>        
        <tr>
            <td <?=$i>0 ? 'class="sideborders"': ''?> align="left">

            <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="tabSpacer"></td>

<?
            // draw one tab line
            foreach($tabArray[$i] as $tab)
            {
                print '<td class="'.($tab[0] == $selectedTab ? 'tabLeftTab' : 'tabLeftTabDisabled').'"></td>';
                print '<td class="'.($tab[0] == $selectedTab ? 'tabContent' : 'tabContentDisabled').'" nowrap>&nbsp;&nbsp;'.$tab[1].'&nbsp;&nbsp;</td>';
                print '<td class="'.($tab[0] == $selectedTab ? 'tabRightTab' : 'tabRightTabDisabled').'"></td>';
  
                print '<td class="tabSpacer"></td>';
            }
?>
            </tr>
            </table>
            
            </td>
        </tr>
        <tr>
            <td class="tabLine"><img src='".$_SESSION[SESSION_PREFIX.'templateImages']."blank.png' border="0" width="1" height="1"></td>
        </tr>
        
<?      
        } 
        
        print '</table>';
    }
    
    //--------------------------------------------------------------------------

    function printPaging($page, $pages, $allCount, $formName = 'FilterForm')
    {
        echo ($page>0 ? "<a href='javascript:$formName.list_page.value=0; $formName.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."FirstPage.gif>".($page>0 ? "</a>" : "")."&nbsp;&nbsp;";
        echo ($page>0 ? "<a href='javascript:$formName.list_page.value=".($page-1)."; $formName.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."PrevPage.gif>".($page>0 ? "</a>" : "")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo L_G_RECORDCOUNT.": ".$allCount."&nbsp;&nbsp;&nbsp;&nbsp;".L_G_PAGE." ".($page+1)." ".L_G_PAGEFROM." ".$pages."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo ($page<$pages-1 ? "<a href='javascript:$formName.list_page.value=".($page+1)."; $formName.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."NextPage.gif>".($page<$pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
        echo ($page<$pages-1 ? "<a href='javascript:$formName.list_page.value=".($pages-1)."; $formName.submit();'>" : "")."<img border=0 src=".$_SESSION[SESSION_PREFIX.'templateImages']."LastPage.gif>".($page<$pages-1 ? "</a>" : "")."&nbsp;&nbsp;";
    }
    
    //--------------------------------------------------------------------------

    function printTimerange($dayName, $monthName, $yearName)
    {
?>
        <table border=0 cellspacing=0 cellpadding=0>
        <tr>
            <td align=left><?=L_G_FROM?>&nbsp;<?=L_G_DAY?></td>
            <td align=left>
            &nbsp;
            <select name="<?=$dayName?>1">
<?            for($i=1; $i<=31; $i++) { ?>
              <option value='<?=$i?>' <?=($i == $_REQUEST[$dayName.'1'] ? "selected" : "")?>><?=$i?></option>
<?            } ?>
            </select>
            &nbsp;
            </td>
            <td align=left>&nbsp;<?=L_G_MONTH?>&nbsp;</td>
            <td align=left>
            &nbsp;
            <select name="<?=$monthName?>1">
<?            for($i=1; $i<=12; $i++) { ?>
              <option value='<?=$i?>' <?=($i == $_REQUEST[$monthName.'1'] ? "selected" : "")?>><?=$i?></option>
<?            } ?>
            </select>
            &nbsp;
            </td>
            <td align=left>&nbsp;<?=L_G_YEAR?>&nbsp;</td>
            <td align=left>
            &nbsp;
            <select name="<?=$yearName?>1">
<?            for($i=2003; $i<=$this->a_curyear; $i++) { ?>
              <option value='<?=$i?>' <?=($i == $_REQUEST[$yearName.'1'] ? "selected" : "")?>><?=$i?></option>
<?            } ?>
            </select>
            &nbsp;
            </td>
        </tr>
        <tr>
            <td align=left><?=L_G_TO?>&nbsp;<?=L_G_DAY?></td>
            <td align=left>
            &nbsp;
            <select name="<?=$dayName?>2">
<?            for($i=1; $i<=31; $i++) { ?>
              <option value='<?=$i?>' <?=($i == $_REQUEST[$dayName.'2'] ? "selected" : "")?>><?=$i?></option>
<?            } ?>
            </select>
            &nbsp;
            </td>
            <td align=left>&nbsp;<?=L_G_MONTH?>&nbsp;</td>
            <td align=left>
            &nbsp;
            <select name="<?=$monthName?>2">
<?            for($i=1; $i<=12; $i++) { ?>
              <option value='<?=$i?>' <?=($i == $_REQUEST[$monthName.'2'] ? "selected" : "")?>><?=$i?></option>
<?            } ?>
            </select>
            &nbsp;
            </td>
            <td align=left>&nbsp;<?=L_G_YEAR?>&nbsp;</td>
            <td align=left>
            &nbsp;
            <select name="<?=$yearName?>2">
<?            for($i=2003; $i<=$this->a_curyear; $i++) { ?>
              <option value='<?=$i?>' <?=($i == $_REQUEST[$yearName.'2'] ? "selected" : "")?>><?=$i?></option>
<?            } ?>
            </select>
            &nbsp;
            </td>
        </tr>
        </table>
<?
    }
}


?>
