<?
QUnit_Global::includeClass('QUnit_UI_TemplatePage');
QUnit_Global::includeClass('QCore_Settings');

class QUnit_UI_ListPage extends QUnit_UI_TemplatePage
{
    var $availableViews = array();
    
    //--------------------------------------------------------------------------
    
    function applyView()
    {
        if($_REQUEST['list_view'] != '')
        {
            if($this->setView($_REQUEST['list_view']))
                return true;
        }

        return $this->applyDefaultView();
    }
    
    //------------------------------------------------------------------------

    function applyDefaultView()
    {
        $listViewName = $this->getListViewName();
        if($listViewName == '')
            return false;
            
        // check if some view was saved before as default view
        $defaultView = QCore_Settings::getUserSetting(SETTINGTYPEPREFIX_LISTVIEW.$listViewName, SETTINGTYPE_USER, '', $GLOBALS['Auth']->getUserID());
        if($this->setView($defaultView))
            return true;
            
        // else apply default view
        return $this->setView('_');
    }
    
    //------------------------------------------------------------------------
    
    function setView($viewID, $save = true) 
    {
        foreach($this->availableViews as $objView)
        {
            if($objView->dbid == $viewID)
            {
                $this->view = $objView;

                if($save)
                    $this->saveViewSelection($viewID);

                if($_REQUEST['list_view'] == '' && $viewID != '_'){
                    $_REQUEST['list_view'] = $viewID;
                }
                    
                return true;
            }
        }
            
        return false;
    }
    
    //------------------------------------------------------------------------
    
    function saveViewSelection($viewID)
    {
        $listViewName = $this->getListViewName();
        if($listViewName == '')
            return false;

        QCore_Settings::_update(SETTINGTYPEPREFIX_LISTVIEW.$listViewName, $viewID, SETTINGTYPE_USER, '', $GLOBALS['Auth']->getUserID());
    }
    
    //------------------------------------------------------------------------
    
    function setViewAsObj($view) 
    {
        $this->view = $view;
    }
    
    //------------------------------------------------------------------------
    
    function getView() 
    {
        return $this->view;
    }
    
    //--------------------------------------------------------------------------

    function createDefaultView($columns)
    {
        $view = QUnit_Global::newobj('QUnit_UI_ListView');
        $view->setName(L_G_DEFAULT);
        $view->dbid = '_';
        $view->setColumns($columns);

        $this->availableViews[] = $view;
        
        $this->setView('_', false);
    }
    
    //--------------------------------------------------------------------------

    function loadAvailableViews()
    {
        $listViewName = $this->getListViewName();
        if($listViewName == '')
            return false;
        
        $availableColumns = $this->getAvailableColumns();
        $availableColumns2 = array_keys($availableColumns);
        
        if(count($availableColumns) < 1 || $listViewName == '')
            return false;

        $sql = 'select * from wd_g_listviews where listname='._q($listViewName).' and userid='._q($GLOBALS['Auth']->getUserID());
        $rs = QCore_Sql_DBUnit::execute($sql.$where.$orderby, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        while(!$rs->EOF)
        {
            $view = QUnit_Global::newobj('QUnit_UI_ListView');
            $view->setName($rs->fields['name']);
            $view->dbid = $rs->fields['viewid'];
            
            $columns = explode(";", $rs->fields['rcolumns']);

            $columns = array_intersect($columns, $availableColumns2);
            
            $view->setColumns($columns);
            
            $this->availableViews[] = $view;
            
            $rs->MoveNext();
        }
        
        return true;
    }

    //--------------------------------------------------------------------------
    
    function getTotalNumberOfRecords($sql)
    {
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return $rs->fields['count'];
    }
    
    //--------------------------------------------------------------------------

    function printListHeader($massAction=true)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }
        
        if($massAction)
        	print '<td class=listheader width="1%" nowrap><input type=button id=checkItemsButton value="[X]" OnClick="checkAllItems();"></td>';
        
        $availableColumns = $this->getAvailableColumns();

        foreach($view->columns as $column)
        {
            if(isset($availableColumns[$column]))
            {
                QUnit_Templates::printHeader($availableColumns[$column][0], $availableColumns[$column][1]);
            }
            else
            {
                QUnit_Templates::printHeader(L_G_UNKNOWN);
            }
        }
    }
    
    //--------------------------------------------------------------------------
    
    function printAvailableViews($className)
    {
        $listViewName = $this->getListViewName();
        if($listViewName == '') {
            return false;
        }
            
        print '&nbsp;'.L_G_LISTVIEW.'&nbsp;<select name="list_view">';
        
        foreach($this->availableViews as $objView) {
            print '<option value="'.$objView->dbid.'" '.($_REQUEST['list_view'] == $objView->dbid ? 'selected' : '').'>'.$objView->getName().'</option>';
        }
        
        print '</select>&nbsp;<input type="button" onClick="submitView()" value="'.L_G_CHANGEVIEW.'">';
        
        print '&nbsp;&nbsp;&nbsp;';
        if($_REQUEST['list_view'] != '_' && $_REQUEST['list_view'] != '')
        {
            print '<a class="simplelink" href="javascript:editView(\''.$_REQUEST['list_view'].'\', \''.$className.'\');">'.L_G_EDITVIEW.'</a>';
            print '&nbsp;&nbsp;|&nbsp;&nbsp;';
            print '<a class="simplelink" href=\'javascript:deleteView("'.$_REQUEST['list_view'].'", "'.$className.'", "'.L_G_CONFIRMDELETEVIEW.'");\'>'.L_G_DELETEVIEW.'</a>';
            print '&nbsp;&nbsp;|&nbsp;&nbsp;';
        }
        print '<a class="simplelink" href="javascript:addView(\''.$className.'\');">'.L_G_NEWVIEW.'</a>';
    }
}
?>
