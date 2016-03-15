<?
/**
*
*   @author Maros Fric, Ladislav Tamas
*   @copyright Copyright (c) webradev.com
*   All rights reserved
*
*   @package PostAffiliate Pro
*   @since Version 2.0
*
*   For support contact info@webradev.com
*/

class Affiliate_Merchants_Bl_ForcedMatrix
{
    function useForcedMatrix($UserID, $parentuserid, $settings)
    {
        if(($temp_parent=Affiliate_Merchants_Bl_ForcedMatrix::specifyParentAffFromMatrix(
                array($parentuserid), $UserID, $height = 1, $settings['Aff_matrix_width'], $settings['Aff_matrix_height'])) != false)
        {
            return $temp_parent;
        }
        else
        {
            if($settings['Aff_matrix_forced_user'] == MATRIX_ACTUAL_SPONSOR)
            {
                return $parentuserid;
            }
            else if($settings['Aff_matrix_forced_user'] == MATRIX_NO_SPONSOR)
            {
                return null;
            }
            else if($settings['Aff_matrix_forced_user'] != '')
            {
                    return $settings['Aff_matrix_forced_user'];
            }
        }
        
        return null;
    }
    
    //--------------------------------------------------------------------------
    
    function specifyParentAffFromMatrix($parentsID, $UserID, $height, $maxwidth, $maxheight)
    {
        if($height > $maxheight || $height > 50)
            return false;

        $users = array();
    
        foreach($parentsID as $parentID)
        {
            $sql = 'select userid from wd_g_users '.
                   'where parentuserid='._q($parentID).
                   '  and deleted=\'0\'';
            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
            if(!$rs) {
                QUnit_Messager::setErrorMessage(L_G_DBERROR);
                return false;
            }
            
            $temp_users = array();
            
            $width = 0;
            while(!$rs->EOF && $width < $maxwidth)
            {
                $temp_users[] = $rs->fields['userid'];
                $rs->MoveNext();
                $width++;
            }

            if(count($temp_users) < $maxwidth)
            {
                return $parentID;
            }
            
            $users = array_merge($users, $temp_users);
        }

        if(($temp_parent=Affiliate_Merchants_Bl_ForcedMatrix::specifyParentAffFromMatrix($users, $UserID, $height+1, $maxwidth, $maxheight)) != false)
            return $temp_parent;
        
        return false;
    }
    
    //--------------------------------------------------------------------------

    function swapUsersParent($UserID1, $UserID2)
    {
        // get parents
        $sql = 'select parentuserid from wd_g_users where deleted=\'0\' and userid='._q($UserID1);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $temp_parentid1 = $rs->fields['parentuserid'];

        $sql = 'select parentuserid from wd_g_users where deleted=\'0\' and userid='._q($UserID2);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$rs || $rs->EOF) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $temp_parentid2 = $rs->fields['parentuserid'];

        // swap parents
        $sql = 'update wd_g_users set parentuserid='._q($temp_parentid2).
               ' where userid='._q($UserID1);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        $sql = 'update wd_g_users set parentuserid='._q($temp_parentid1).
               ' where userid='._q($UserID2);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        // temp user1's child
        $tempid = QCore_Sql_DBUnit::createUniqueID('wd_g_users', 'userid');;

        $sql = 'update wd_g_users set parentuserid='._q($tempid).' where parentuserid='._q($UserID1);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        // swap child
        $sql = 'update wd_g_users set parentuserid='._q($UserID1).' where parentuserid='._q($UserID2);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        $sql = 'update wd_g_users set parentuserid='._q($UserID2).
               ' where parentuserid='._q($tempid);
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if(!$ret) {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return true;
    }
}
?>
