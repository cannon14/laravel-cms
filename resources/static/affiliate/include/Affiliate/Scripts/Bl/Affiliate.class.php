<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

QUnit_Global::includeClass('QUnit_Countries');
QUnit_Global::includeClass('QCore_Bl_Users');

define('WD_PATTERN_DEFAULT', '/[^\'\"]*/');

class Affiliate_Scripts_Bl_Affiliate {

    var $columns = array();

    function Affiliate_Scripts_Bl_Affiliate() {
        $this->addColumn('userid', WD_PATTERN_DEFAULT);
        $this->addColumn('accountid', WD_PATTERN_DEFAULT);
        $this->addColumn('refid', WD_PATTERN_DEFAULT);
        $this->addColumn('username', WD_PATTERN_DEFAULT);
        $this->setCaption('username', L_G_EMAIL);
        $this->addColumn('rpassword', WD_PATTERN_DEFAULT);
        $this->setCaption('rpassword', L_G_PASSWORD);
        $this->addColumn('rtype', WD_PATTERN_DEFAULT);
        $this->addColumn('name', WD_PATTERN_DEFAULT);
        $this->setCaption('name', L_G_NAME);
        $this->addColumn('surname', WD_PATTERN_DEFAULT);
        $this->setCaption('surname', L_G_SURNAME);
        $this->addColumn('rstatus', WD_PATTERN_DEFAULT);
        $this->addColumn('product', WD_PATTERN_DEFAULT);
        $this->addColumn('dateinserted', WD_PATTERN_DEFAULT);
        $this->addColumn('dateapproved', WD_PATTERN_DEFAULT, false);
        $this->addColumn('deleted', WD_PATTERN_DEFAULT);
        $this->addColumn('userprofileid', WD_PATTERN_DEFAULT, false);
        $this->addColumn('parentuserid', WD_PATTERN_DEFAULT, false);
        $this->addColumn('originalparentid', WD_PATTERN_DEFAULT, false);
        $this->addColumn('leftnumber', WD_PATTERN_DEFAULT, false);
        $this->addColumn('rightnumber', WD_PATTERN_DEFAULT, false);
        $this->addColumn('company_name', WD_PATTERN_DEFAULT, false);
        $this->setCaption('company_name', L_G_COMPANYNAME);
        $this->addColumn('weburl', WD_PATTERN_DEFAULT, false);
        $this->setCaption('weburl', L_G_WEBURL);
        $this->addColumn('street', WD_PATTERN_DEFAULT, false);
        $this->setCaption('street', L_G_STREET);
        $this->addColumn('city', WD_PATTERN_DEFAULT, false);
        $this->setCaption('city', L_G_CITY);
        $this->addColumn('state', WD_PATTERN_DEFAULT, false);
        $this->setCaption('state', L_G_STATE);
        $this->addColumn('country', WD_PATTERN_DEFAULT);
        $this->setCaption('country', L_G_COUNTRY);
        $this->addColumn('zipcode', WD_PATTERN_DEFAULT, false);
        $this->setCaption('zipcode', L_G_ZIPCODE);
        $this->addColumn('phone', WD_PATTERN_DEFAULT, false);
        $this->setCaption('phone', L_G_PHONE);
        $this->addColumn('fax', WD_PATTERN_DEFAULT, false);
        $this->setCaption('fax', L_G_FAX);
        $this->addColumn('tax_ssn', WD_PATTERN_DEFAULT, false);
        $this->setCaption('tax_ssn', L_G_TAXSSN);
        $this->addColumn('data1', WD_PATTERN_DEFAULT, false);
        $this->addColumn('data2', WD_PATTERN_DEFAULT, false);
        $this->addColumn('data3', WD_PATTERN_DEFAULT, false);
        $this->addColumn('data4', WD_PATTERN_DEFAULT, false);
        $this->addColumn('data5', WD_PATTERN_DEFAULT, false);
        $this->addColumn('payoptid', WD_PATTERN_DEFAULT, false);                   
        $this->setCaption('payoptid', L_G_PAYOUTMETHOD);
    }
    
    function addColumn($column, $pattern, $needed = true) {
        $this->columns[$column]['pattern'] = $pattern;
        //$this->columns[$column]['value'] = ''; 
        $this->columns[$column]['caption'] = $column;
        $this->columns[$column]['needed'] = $needed;        
        $this->columns[$column]['type'] = 'string';        
    }
    
    function isFilled($column) {
        if(isset($this->columns[$column]['value']) && $this->columns[$column]['value'] !== '') {
            return true;
        }
        return false;
    }
    
    function setNeeded($column, $value) {
        if(isset($this->columns[$column])) {
            $this->columns[$column]['needed'] = $value;  
        }        
    }
    
    function setType($column, $value) {
        if(isset($this->columns[$column])) {
            $this->columns[$column]['type'] = $value;  
        }        
    }
    
    function setCaption($column, $caption) {
        if(isset($this->columns[$column])) {
            $this->columns[$column]['caption'] = $caption;  
        }        
    }
    
    function setColumn($column, $value) {
        if(isset($this->columns[$column])) {
            $this->columns[$column]['value'] = $value;            
        }
    }
    
    function getColumn($column) {
        if(isset($this->columns[$column])) {
            return $this->columns[$column]['value'];
        } 
        return false;       
    }

    function getCaption($column) {
        if(isset($this->columns[$column])) {
            return $this->columns[$column]['caption'];
        } 
        return false;       
    }

    function getPattern($column) {
        if(isset($this->columns[$column])) {
            return $this->columns[$column]['pattern'];
        } 
        return false;       
    }

    function isNeeded($column) {
        if(isset($this->columns[$column])) {
            return $this->columns[$column]['needed'];
        } 
        return true;       
    }
    
    function getColumns() {
        return $this->columns;
    }

    function fillColumnsFromArray($arr) {
        foreach($arr as $key => $val) {
            $this->setColumn($key, $val);
        }
    }
        
    function getErrorMessage() {
        return QUnit_Messager::getErrorMessage();
    }
    
    function addErrorMessage($msg) {
        QUnit_Messager::setErrorMessage($msg);
    }
    
    
    
    //--------------------------------------------------------------------------

    function check() {        
        $correct = true;
        foreach($this->getColumns() as $key => $val) {
            if($this->isFilled($key) === false && $this->isNeeded($key) === true) {
                $this->addErrorMessage($this->getCaption($key).' '.L_G_EMPTY);
                $correct = false;
            } elseif(!preg_match($this->getPattern($key), $this->getColumn($key))) {
                $this->addErrorMessage($this->getCaption($key).' '.L_G_UNALLOWED);
                $correct = false;                
            }
        }
       return $correct;
    }
    
    function insertUser() {        
        $sql = "insert into wd_g_users set ";
        foreach($this->getColumns() as $col => $value) {
            if($this->isFilled($col) != false) {
                $sql .= "$col = '".addslashes($this->getColumn($col))."', ";
            }
        }
        $sql = rtrim($sql, ", ");
        $ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$ret)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
        
        return true;      
    }

    function updateUser() {        
        $sql = "update wd_g_users set ";
        foreach($this->getColumns() as $col => $value) {
            if($this->isFilled($col) != false) {
                $sql .= "$col = '".addslashes($this->getColumn($col))."', ";
            }
        }
        $sql = rtrim($sql, ", ");
        $sql .= " where userid = '".$this->getColumn('userid')."'";
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
