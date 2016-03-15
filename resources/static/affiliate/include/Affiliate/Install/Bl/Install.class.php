<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================


class Affiliate_Install_Bl_Install
{
    
    function checkDbConnection($dbtype, $dbhostname, $dbusername, $dbpwd, $dbname) {
        $db = ADONewConnection($dbtype);
        $ret = @$db->Connect($dbhostname, $dbusername, $dbpwd, $dbname);
        if(!$ret || !$db) {
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$this->getDBErrorMsg());            
            return false;
        }
        return true;
    }
    
    //------------------------------------------------------------------------

    function connectDB()
    {
        $db = ADONewConnection($_SESSION[SESSION_PREFIX.'dbtype']);
        $ret = @$db->Connect($_SESSION[SESSION_PREFIX.'dbhostname'], $_SESSION[SESSION_PREFIX.'dbusername'], $_SESSION[SESSION_PREFIX.'dbpwd'], $_SESSION[SESSION_PREFIX.'dbname']);
        if(!$ret || !$db) {
            QUnit_Messager::setErrorMessage(L_G_CANNOTCONNECTTODATABASE.$this->getDBErrorMsg());            
            return false;
        }

        $GLOBALS['db'] = $db;
        return true;
    }    
    
    //------------------------------------------------------------------------

    function getDBErrorMsg() {
        if($GLOBALS['db'] == false)
            return L_G_DBCONNECTIONDOESNTEXIST;
            
        return $GLOBALS['db']->errorMsg();
    }    
    
    function DBcolumns($table) {
        $columnsObj = $GLOBALS['db']->MetaColumns($table);
        
        $columns = array();
        foreach($columnsObj as $col) {
            $columns[] = strtolower($col->name);
        }
        
        return $columns;
    }

    //------------------------------------------------------------------------

    function checkFileIsWritable($file)
    {
        $handle = @fopen($file, "ab");
        if($handle == false)
            return false;

        fclose($handle);
        return true;
    }
    
    //------------------------------------------------------------------------

    function checkDirIsWritable($dir)
    {
        // temp file name
        $uniq = 'dir_writable_check.txt';

        $handle = @fopen($dir.'/'.$uniq, "wb");
        if($handle == false)
            return false;

        // delete the temporary file
        //unlink($dir.'/'.$uniq);
        fclose($handle);
        return true;
    }  
    
    //------------------------------------------------------------------------
    
    function executeDB($sql) {
        $rs = @$GLOBALS['db']->execute($sql);
        if (!$rs || !$GLOBALS['db']->_queryID)
        { 
            $errorMsg = $GLOBALS['db']->errorMsg();
            QUnit_Messager::setErrorMessage(L_G_DBERROR.$errorMsg." SQL: $sql");            
            return false;
        }

        return $rs;
    }
    
    //------------------------------------------------------------------------

    function getFileContents($filename) {
        if(($fd = @fopen ($filename, "r")) == false) {
            QUnit_Messager::setErrorMessage(L_G_FILEOPENFAILED);
            return false;
        }            
        $contents = @fread($fd, filesize($filename));
        fclose($fd);
    
        return $contents;
    }
    
    //------------------------------------------------------------------------

    function lineExplode($text)
    {
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        
        $lines = explode("\n", $text);
        
        $commands = array();
        $command = '';
        foreach($lines as $line)
        {
            $command .= " ".$line;
            
            $pos = strrpos($line, ";");
            if($pos === false)
                continue;
                
            // check if there is any text after the semicolon
            if((strlen($line) - $pos)<=2)
            {
                $commands[] = $command;
                $command = '';
            }
        }
        
        return $commands;
    }      
    
    function writeSettingsFile() {    
        if($this->checkFileIsWritable('../settings/settings.php') === false) {
            QUnit_Messager::setErrorMessage(L_G_SETTINGSFILENOTWRITABLE);
            return false;
        }
        
        $handle = @fopen('../settings/settings.php', "wb");
        if($handle === false) {
            QUnit_Messager::setErrorMessage(L_G_SETTINGSFILENOTWRITABLE);
            return false;
        }

        fwrite($handle, "<?php\r\n");
        
        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// Database type\r\n");
        fwrite($handle, "define('DB_TYPE','".$_SESSION[SESSION_PREFIX.'dbtype']."');\r\n");

        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// database server name, default 'localhost'\r\n"); 
        fwrite($handle, "define('DB_HOSTNAME','".$_SESSION[SESSION_PREFIX.'dbhostname']."');\r\n");

        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// database name \r\n");
        fwrite($handle, "define('DB_DATABASE','".$_SESSION[SESSION_PREFIX.'dbname']."');\r\n");

        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// database username \r\n");
        fwrite($handle, "define('DB_USERNAME','".$_SESSION[SESSION_PREFIX.'dbusername']."');\r\n");

        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// database password \r\n");
        fwrite($handle, "define('DB_PASSWORD','".$_SESSION[SESSION_PREFIX.'dbpwd']."');\r\n");

        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// application license \r\n");
        fwrite($handle, "define('APPLICATION_LICENSE','".$_SESSION[SESSION_PREFIX.'auth_license']."');\r\n");

        fwrite($handle, "//----------------------------------------------------------------------------\r\n");
        fwrite($handle, "// customer product ID \r\n");
        fwrite($handle, "define('CUSTPRODUCT_ID','".$_SESSION[SESSION_PREFIX.'auth_id']."');\r\n");

        fwrite($handle, "?>\r\n");
        
        fclose($handle);
        return true;
    }    

    function executeSqlFile($sqlFile) {
        if($this->connectDB() === false) {
            return false;
        } 
        if(($contents = $this->getFileContents($sqlFile)) === false) {
            return false;
        }
        $lines = $this->lineExplode($contents);        
        foreach($lines as $sql) {
            if(strlen($sql) > 20) {
                if($this->executeDB($sql) === false) {
                    return false;
                }
            }
        }  
        return true;  
    }

    function createDatabase($createSql) {
        $sqlcommands = explode(';', $createSql);
        foreach($sqlcommands as $sql)
        {
            if(strlen($sql) > 20) {
                $rs = $this->executeDB($sql);
                if($rs == false)
                {
                    return false;
                }
            }
        }  
        return true;  
    }
    
    function fillDatabase($insertSql) {    
        $sqlcommands = $this->lineExplode($insertSql);
        foreach($sqlcommands as $sql)
        {
            if(strlen($sql) > 20)
            {
                $rs = $this->executeDB($sql);
                if($rs == false)
                {                    
                    return false;
                }
            }
        }  
        return true; 
    } 
    
    function getCreateSql() {
        if($_SESSION[SESSION_PREFIX.'dbtype'] == 'mysql') {
            $createSql = $this->getFileContents('./sql/create_pap_200_mysql.sql');
        } else {
            $createSql = $this->getFileContents('./sql/create_pap_200_mssql.sql');
        }            
        return $createSql;        
    }

    function getInsertSql() {
        if($_SESSION[SESSION_PREFIX.'dbtype'] == 'mysql') {
            $insertSql = $this->getFileContents('./sql/insert_pap_200_mysql.sql');
        } else {
            $insertSql = $this->getFileContents('./sql/insert_pap_200_mssql.sql');
        }
        return $insertSql;
    }
    
    function processDbCreation() {
        if($this->connectDB() === false) {
            return false;
        }        
        
        //------------------------------------------------
        // check if some tables doesn't exist in the database already, 
        // they shouldn't
        //...
        
        $createSql = $this->getCreateSql();
        $insertSql = $this->getInsertSql();
        
        if($createSql === false || $insertSql === false || $createSql === '' || $insertSql === '')
        {
            QUnit_Messager::setErrorMessage(L_G_CANNOTOPENSQLSCRIPT);
            return false;
        }
        
        $this->createDatabase($createSql);        
        if(QUnit_Messager::getErrorMessage() != '') {
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            return false;
        }
        
        $this->fillDatabase($insertSql);                
        if(QUnit_Messager::getErrorMessage() != '') {
            QUnit_Messager::setErrorMessage(L_G_DBININCONSISTENTSTATE);
            return false;
        }
                
        return true;        
    }
    
    function createMerchantAccount($username, $pwd) {
        if($this->connectDB() === false) {            
            return false;            
        }        
        
        $sql =  "INSERT INTO wd_g_users SET ".
                "userid = 1, ".
                "accountid = 'default1', ".
                "username = "._q($username).", ".
                "rpassword = "._q(md5($pwd)).", ".
                "name = 'adminname', ".
                "surname = 'adminsurname', ".
                "rstatus = ".STATUS_ENABLED.", ".
                "dateinserted = ".sqlNow().", ".
                "userprofileid = 'userpro1', ".
                "rtype = ".USERTYPE_ADMIN;
                
                
        $rs = $this->executeDB($sql);
        if($rs == false) {            
            return false;
        }        
        return true;
    }
    
    //------------------------------------------------------------------------
    
    function updateSettings($settings) {
        if($this->connectDB() === false) {
            return false;
        }                
        
        foreach($settings as $code => $value) {            
            if(!$this->updateSetting($code, $value)) {                
                return false;
            }
        }
        return true;
    }
    
    function updateSetting($code, $value) {
        if(!QCore_Settings::_update('Aff_'.$code, $value, USERTYPE_ADMIN, 'default1', 1)) {
              return false;
        }
        return true;
    }
    
    function DBcreateInsert($columns) {
        $values = '';
        
        foreach($columns as $column) {
            if($values != '')
            $values .= ', ';
            
            $values .= $column;   
        }
        
        return $values;
    }    
    
}
?>