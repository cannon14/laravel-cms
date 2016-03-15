<?php
class QCore_Bl_ListViews
{
    function loadViewInfo($viewID)
    {
        $sql = 'select * from wd_g_listviews '.
               'where userid='._q($GLOBALS['Auth']->getUserID()).
               '  and viewid='._q($viewID);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return array();
        }

        $data = array();
        $data['name'] = $rs->fields['name'];
        $data['columns'] = explode(";", $rs->fields['rcolumns']);

        return $data;
    }
    
    //--------------------------------------------------------------------------

    function checkData($params)
    {
        $params['name'] = preg_replace('/[\'\"]/', '', $_POST['name']);
        $params['columns_count'] = preg_replace('/[\'\"]/', '', $_POST['columns_count']);
        $params['listViewName'] = preg_replace('/[\'\"]/', '', $_POST['listViewName']);
        $params['vid'] = preg_replace('/[\'\"]/', '', $_POST['vid']);
        $params['listview_name'] = preg_replace('/[\'\"]/', '', $_POST['listview_name']);
        
        for($i=1; $i<=$params['columns_count']; $i++)
        {
            $params['column'.$i] = preg_replace('/[\'\"]/', '', $_POST['column'.$i]);
        }
        
        // check correctness of the fields
        checkCorrectness($_POST['name'], $params['name'], L_G_VIEWNAME, CHECK_EMPTYALLOWED);
        
        // check how many unique columns were set
        $columnsSet = array();
        for($i=1; $i<=$params['columns_count']; $i++)
        {
            if($params['column'.$i] != '_')
                $columnsSet[] = $params['column'.$i];
        }
        
        $columnsSet = array_unique($columnsSet);

        $params['columns'] = implode(';', $columnsSet);
        
        if(count($columnsSet) < 2)
        {
            QUnit_Messager::setErrorMessage(L_G_CHOOSEATLEAST2COLUMNS);
        }

        return $params;
    }
    
    //------------------------------------------------------------------------
    
    function insert($params)
    {
        // save user to db
        $ViewID = QCore_Sql_DBUnit::createUniqueID('wd_g_listviews', 'viewid');
        $sql = 'insert into wd_g_listviews(viewid, userid, name, rcolumns, listname)'.

               ' values('._q($ViewID).','._q($GLOBALS['Auth']->getUserID()).
               ','._q($params['name']).','._q($params['columns']).','._q($params['listview_name']).')';
        
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function update($params)
    {
        // save user to db
        $sql = 'update wd_g_listviews '.
               'set name='._q($params['name']).
               ', rcolumns='._q($params['columns']).

               ' where userid='._q($GLOBALS['Auth']->getUserID()).
               '   and viewid='._q($params['vid']);

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function delete($params)
    {
        // save user to db
        $sql = 'delete from wd_g_listviews'.
               ' where userid='._q($GLOBALS['Auth']->getUserID()).
               '   and viewid='._q($params['vid']);

        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }    
        
        return true;
    }        
}
?>
