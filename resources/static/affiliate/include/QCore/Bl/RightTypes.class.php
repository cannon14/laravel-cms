<?php
class QCore_Bl_RightTypes
{
    /** function checks whether specified user profile already exists
    *   parameters: righttypeid (string)    - right type ID
    *               code (string)           - right type code
    *               rtidexists (bool)       - tells whether search for right type ID (true), or exclude it (false - only if specified)
    *   return value: (bool) true/false (group already exists/group does not exist)
    */
    function checkRightTypeExists($righttypeid = '', $code = '', $rtidexists = true)
    {
        if(($righttypeid == '') && ($name == '')) {
            return(false);
        }

        $sql = 'select righttypeid from wd_g_righttypes where 1=1';
        if($code != '') {
            $sql .= ' and code='._q($code);
        }
        if($righttypeid != '') {
            if($rtidexists) {
                $sql .= ' and righttypeid='._q($righttypeid);
            }
            else {
                $sql .= ' and righttypeid<>'._q($righttypeid);
            }
        }
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        // error handling
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return(false);
        }

        // if no data were selected, specified user profile does not exist
        if($rs->EOF) {
            return(false);
        }
        // if there were some data selected, specified user profile already exists
        return(true);
    }

    //--------------------------------------------------------------------------
  
    function getRightTypesAsArray($category='', $module='')
    {
        $sql = 'select * from wd_g_righttypes where 1=1';
        if($category != '')
            $sql .= ' and category='._q($category);
        if($module != '')
            $sql .= ' and module = '._q($module);
        $sql .= ' order by category, code, rorder';
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return array();
        }        

        $rts = array();

        while(!$rs->EOF)
        {
            $type = array('langid' => $rs->fields['typelangid'],
                          'righttypeid' => $rs->fields['righttypeid'],
                          'parentrighttypeid' => $rs->fields['parentrighttypeid']);

            $rts[$rs->fields['category']]['category'] = $rs->fields['categorylangid'];
            $rts[$rs->fields['category']]['rights'][$rs->fields['code']]['right'] = $rs->fields['rightlangid'];
            $rts[$rs->fields['category']]['rights'][$rs->fields['code']]['types'][] = $type;

            $rs->MoveNext();
        }

        return $rts;
    }
    
    //--------------------------------------------------------------------------
    
    function insertUserRight($UserProfileID)
    {
        if($UserProfileID == '') return false;

        QUnit_Global::includeClass('QCore_Bl_Userprofiles');

        if(!QCore_Bl_RightTypes::deleteUserRights($UserProfileID)) return false;

        if(is_array($_POST['userrighttype'])) {
            foreach($_POST['userrighttype'] as $righttype)
            {
                QCore_Bl_RightTypes::checkParentRights($righttype);
            }

            foreach($_POST['userrighttype'] as $righttype)
            {
                $UserRightID = QCore_Sql_DBUnit::createUniqueID('wd_g_userrights', 'userrightid');
                $sql = 'insert into wd_g_userrights (userrightid, userprofileid, righttypeid) '.
                       'values ('._q($UserRightID).','._q($UserProfileID).','._q($righttype).')';
                $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
                if(!$ret) {
                    QUnit_Messager::setErrorMessage(L_G_DBERROR);
                    QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
                    return false;
                }
                
                QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);
            }
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function deleteUserRights($userprofileid='', $userrightid = '')
    {
        $sql = 'delete from wd_g_userrights '.
               'where 1=1 ';
        if($userprofileid != '')
            $sql .= ' and userprofileid='._q($userprofileid);
        if($userrightid != '')
            $sql .= ' and userrightid='._q($userrightid);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }

        QCore_History::DebugMsg(WLOG_ACTIONS, $sql, __FILE__, __LINE__);

        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function checkParentRights($righttype)
    {
        if($righttype == '') return false;
        
        $sql = 'select righttypeid from wd_g_righttypes where parentrighttypeid='._q($righttype);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
            return false;
        }
        
        if($rs->EOF) return false;

        if(!in_array($rs->fields['righttypeid'], $_POST['userrighttype']))
            $_POST['userrighttype'] = array_merge($_POST['userrighttype'], array($rs->fields['righttypeid']));

        //-------------------------
        // check next child
        QCore_Bl_RightTypes::checkParentRights($rs->fields['righttypeid']);
    }
}
?>
