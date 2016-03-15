<?php
/**
*
*   @author Viktor Zeman
*   @copyright Copyright (c) Quality Unit s.r.o.
*   @package OraSR
*   @since Version 0.1
*   $Id: Object.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/
require_once(BASEDIR . '/adodb/adodb.inc.php');

class QUnit_Sql_Object {
    var $db;
    var $tableName = '';
    var $columns = array();
    var $primary = array();
    var $data = array();
    var $rowClassName = '';
    
    var $_db_server = 'localhost';       //if not specified, localhost will be used
    var $_db_type = 'mysql';    //default database type will be mysql
    var $_db_database = '';
    var $_db_username = 'root'; //default username is root
    var $_db_password = '';
    
    function QUnit_Sql_Object($db_type = 'mysql', $db_server = 'localhost', $db_username = 'root', $db_password = '', $db_database = '') {
        //init db object
        $this->_db_type = $db_type;
        $this->_db_server = $db_server;
        $this->_db_username = $db_username;
        $this->_db_password = $db_password;
        $this->_db_database = $db_database;
        
        $this->db = ADONewConnection($this->_db_type); 
    }
    
    function connectDatabase() {
        return $this->db->Connect(
                $this->_db_server, 
                $this->_db_username, 
                $this->_db_password, 
                $this->_db_database);
    }
    
    function query($sql) {
        $this->_error = '';
        if (is_object($this->db)) {
            if ($this->db->IsConnected() || $this->connectDatabase()) {
                $rs = &$this->db->Execute($sql);
                if(!is_object($rs)) {
                    $this->_error = $this->db->ErrorMsg() . ' : ' . $sql;
                    return false;
                } else {
                    return $rs;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    function getRows($sqlWhere) {
        $sqlString = "SELECT * from $this->tableName WHERE $sqlWhere";
        $records = array();
        if (($recorset = $this->query($sqlString)) !== false) {
            while(!$recorset->EOF) {
                $primary = '';
                foreach ($this->primary as $fieldname) {
                    $primary .= (strlen($primary) ? '|' : '') . $recorset->fields[$fieldname];
                }
                if (!strlen($this->rowClassName)) die('No Row class name specified for class ' . get_class($this));
                $record = QUnit_Global::newObj($this->rowClassName);
                foreach ($this->columns as $columnname) {
                    $record->$columnname = $recorset->fields[$columnname];
                }  
                $records[$primary] = $record;
                
                $recorset->MoveNext();
            }
            return $records;
        } else {
            return false;
        }
        
    }
    
    function getErrorMessage() {
        return $this->_error;
    }
    
    function &select() {
        foreach ($this->primary as $primary) {
            if(empty($this->data[$primary])) {
                $str[] = "$primary = ''";
                continue;
            }
            $str[] = "$primary = " . $this->db->qstr($this->data[$primary]);
        }
        $str = implode(' AND ', $str);
        $sql = "SELECT * FROM $this->tableName WHERE $str";          
        
        $rs = $this->query($sql);
        return $rs;
    }
    
    function insert() {
        $rs = $this->select();
        if ($rs) {
            $insertSQL = $this->db->GetInsertSQL($rs, $this->data); 
            if ($insertSQL) {
                return $this->query($insertSQL); 
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    
    function update($columns = null) {
        if (empty($columns)) {
            $columns = $this->columns;     //init columns for update
        }
        
        $data = array();
        foreach ($columns as $column) {
            $data[$column] = $this->data[$column];
        }
        
        $rs = $this->select();
        if ($rs) {
            $updateSQL = $this->db->GetUpdateSQL($rs, $data); 
        }
                
        if ($rs) {
            $updateSQL = $this->db->GetUpdateSQL($rs, $data); 
            if(!empty($updateSQL)) {
                return $this->query($updateSQL); 
            } else {
                return true;
            }
        }
        return false;
    }
    
    function getRowCount(&$rs) {
        $count = $rs->RowCount();
        if($this->db->databaseType != 'mysql') {
            return $count;
        }
        if($count == 0) {
            $rs = $this->select();
            return $rs->RowCount();
        }
    }
    
    function update_insert($columns = null) {
        $rs = $this->update($columns);
        if ($rs === true || (is_object($rs) && $this->getRowCount($rs) > 0)) {
            return true;
        } else {
            return $this->insert();
        }
    } 
    
    function setValue($column, $value) {
        $this->data[$column] = $value;
        return true;
    }
    function _setServer($serverName) {
        $this->_db_server = $serverName;
        return true;
    }

    function _setDatabaseType($dbType) {
            $this->_db_type = $dbType;
            return true;
    }

    function _setDatabase($databaseName) {
        $this->_db_database = $databaseName;
        return true;
    }

    function _setUsername($username) {
        $this->_db_username = $username;
        return true;
    }

    function _setPassword($password) {
        $this->_db_password = $password;
        return true;
    }
    
    function setColumns($columns) {
        $this->columns = $columns;
        return true;
    }
    function setPrimary($primary) {
        $this->primary = $primary;
        return true;
    }
    
    function setTableName($table) {
        $this->tableName = $table;
        return true;
    }
}


?>