<?
//============================================================================
// Copyright (c) Maros Fric, webradev.com  2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class QCore_Sql_DBUnit
{
    var $className = 'QCore_Sql_DBUnit';
    
    //--------------------------------------------------------------------------
    
    public static function execute($sql, $f, $l, $assoc = false)
    {
        if($assoc) 
        	$GLOBALS['db']->SetFetchMode(ADODB_FETCH_ASSOC);
        else
        	$GLOBALS['db']->SetFetchMode(ADODB_FETCH_BOTH);
        	
        if(defined('DB_DEBUG') && DB_DEBUG ==  1) $start_time = microtime();
        
        $rs = $GLOBALS['db']->execute($sql);
        
        checkDBError($GLOBALS['db'], $sql, $f, $l);
        $GLOBALS['dbrequests']++;
        
        if(defined('DB_DEBUG') && DB_DEBUG ==  1)
        {
            $end_time = microtime(); 
            $diff = microtime_diff($start_time, $end_time);      
            echo "<br><b>$sql</b> - <font color=#ff0000>$diff s.</font> - $f - $l<br>";
        }
        return $rs;
    }
    
    //--------------------------------------------------------------------------
    
    function selectLimit($sql, $offset, $limit, $f, $l)
    {
        if(defined(DB_DEBUG) && DB_DEBUG ==  1) $start_time = microtime();

        $rs = $GLOBALS['db']->SelectLimit($sql, $limit, $offset);
        checkDBError($GLOBALS['db'], $sql, $f, $l);
        $GLOBALS['dbrequests']++;
        
        if(defined(DB_DEBUG) && DB_DEBUG ==  1)
        {
            $end_time = microtime(); 
            $diff = microtime_diff($start_time, $end_time);      
            echo "<br><b>$sql</b> LIMIT: $limit OFFSET: $offset - <font color=#ff0000>$diff s.</font><br>";
        }

        return $rs;
    }
    
    //--------------------------------------------------------------------------
    
    function executeNoLog($sql, $f, $l)
    {
        $rs = $GLOBALS['db']->execute($sql);
        $GLOBALS['dbrequests']++;
        
        return $rs;    
    }
    
    //--------------------------------------------------------------------------
    
    function generateID($seqName, $seqStart)
    {
        return $GLOBALS['db']->GenID($seqName, $seqStart); 
    }
    
    //--------------------------------------------------------------------------
    
    function Insert_ID()
    {
        return $GLOBALS['db']->Insert_ID();
    }
    
    //--------------------------------------------------------------------------
    
    function createUniqueID($table, $column)
    {
		if ($table == 'wd_pa_impressions' || $table == "wd_pa_transactions" || $table == "wd_pa_transactions"){
			// RAPIDO CHANGE
			// In order to allow for rotation of these tables,
			// we need to use unique keys created according to the following:
			
			// NEW KEY
			// XXX XXXXX XXXX XX XX XX XXXX XX XX XX XXXXX
			//            1             2             3
			// 123 45678 9012 34 56 78 9012 34 56 78 90 
	        // COM RM	 YEAR RM MO RM DYHR	RM MI RM SC	
	        $randommd5= md5(uniqid(rand(), true));
	        $rm1=substr($randommd5, 0, 5);
	        $rm2=substr($randommd5, 6, 2);
	        $rm3=substr($randommd5, 9, 2);
	        $rm4=substr($randommd5, 12, 2);
	        $rm5=substr($randommd5, 15, 2);
	        
	        list($year, $month, $day, $hour, $min, $sec) = preg_split(':',date("Y:m:d:H:i:s"));
	        //$month = date("m");
	        //$day = date("d");
	        //$hour = date("H");
	        //$min = date("i");
	        //$sec = date("s");
	        $com = ENTITY_ID;
	        	     	
	     	$randString = $com.$rm1.$year.$rm2.$month.$rm3.$day.$hour.$rm4.$min.$rm5.$sec;//uniqid(rand(), true);
	        $uniqueID = $randString;
	            
	        return $uniqueID;
		}
		else {
	        $maxTries = 10;
	        
	        while(1)
	        {
	            if($maxTries <= 0)
	            return false;
	            
	            $uniqueID = substr(md5(uniqid(rand(), true)), 0, 8);
	            
	            // check if this token does not exist in the table already
	            $sql = "select $column from $table where $column="._q($uniqueID);
	            $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	            if(!$rs)
	            {
	                showMsg(L_G_DBERROR, 'error');
	                return false;
	            }
	            
	            if($rs->EOF)
	                return $uniqueID;
	            
	            $maxTries--;
	        }
		}
        return false;
    }

    //--------------------------------------------------------------------------
    
    function getTableCreateStatement($table)
    {
        $createStat = "DROP TABLE IF EXISTS $table;\n";
        $createStat .= "CREATE TABLE $table(\n";
        
        // get fields definition
        $sql = "SHOW FIELDS FROM $table";
        $rs = QCore_Sql_DBUnit::executeNoLog($sql, __FILE__, __LINE__);
        if (!$GLOBALS['db']->_queryID)
        {
            if($GLOBALS['db']->ErrorNo() == 1146)
                return false;
        }
        if (!$rs)
            return false;
        
        while (!$rs->EOF)
        {
            $createStat .= '	'.$rs->fields['Field'].' '.$rs->fields['Type'];
            if($rs->fields['Default'] != '')

                $createStat .= ' DEFAULT \'' . $rs->fields['Default'] . '\'';
            
            if($rs->fields['Null'] != "YES")
                $createStat .= ' NOT NULL';
            
            if($rs->fields['Extra'] != "")
                $createStat .= ' '.$rs->fields['Extra'];

            $rs->MoveNext();
            
            if(!$rs->EOF)
                $createStat .= ",\n";
        }
        
        // get keys definition
        $sql = "SHOW KEYS FROM $table";
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        if (!$rs)
            return false;
        
        while (!$rs->EOF)
        {
            $keyName = $rs->fields['Key_name'];
            
            $indexes[$keyName]['name'] = $rs->fields['Column_name'];
            
            if(($keyName != 'PRIMARY') && ($rs->fields['Non_unique'] == 0))
                $indexes[$keyName]['unique'] = true;
            
            if($rs->fields['Comment'] == 'FULLTEXT')
                $indexes[$keyName]['fulltext'] = true;
            
            //if(!is_array($index[$keyName]['columns']))
            //    $indexes[$keyName]['columns'] = array();
          
            $indexes[$keyName]['columns'][] = $rs->fields['Column_name'];
            
            $rs->MoveNext();
        }

        if(is_array($indexes) && count($indexes) > 0)
        {
            foreach($indexes as $key => $index)
//            while(list($key, $columns) = @each($index))
            {
                $createStat .= ", \n";
                
                if($key == 'PRIMARY')
                    $createStat .= "    PRIMARY KEY";
                else if ($index['unique'])
                    $createStat .= "    UNIQUE KEY $key";
                else if ($index['fulltext'])
                    $createStat .= "    FULLTEXT KEY $key";
                else 
                    $createStat .= "    KEY $key";
                
                $createStat .= " (" . implode($index['columns'], ', ') . ')';
            }
        }
        
        $createStat .= "\n);\n\n";
        
        if(get_magic_quotes_runtime())
            echo stripslashes($createStat);
        else
            echo $createStat;
            
        return true;
    }
    
    //--------------------------------------------------------------------------
    
    function getTableInsertStatement($table)
    {
        $GLOBALS['db']->SetFetchMode(ADODB_FETCH_ASSOC);
        $rs = QCore_Sql_DBUnit::executeNoLog("select * from $table", __FILE__, __LINE__);
        if (!$GLOBALS['db']->_queryID)
        {
            if($GLOBALS['db']->ErrorNo() == 1146)
                return false;
        }        
        $GLOBALS['db']->SetFetchMode(ADODB_FETCH_BOTH);
        if (!$rs)
            return false;

        if(!$rs->EOF)
        {
            echo "\n#\n# Table Data for $table\n#\n";
            $fieldNames = array();
            $fieldNamesSql = '(';
            
            foreach($rs->fields as $field => $value)
            {
                $fieldNames[] = $field;
                $fieldNamesSql .= ( $fieldNamesSql != '(' ? ', ': '').$field;
            }
            
            $fieldNamesSql .= ')';

            while(!$rs->EOF)
            {
                $insertStat = "INSERT INTO $table $fieldNamesSql VALUES(";
                $vals = '';
                
                foreach($fieldNames as $field)
                {
                    $vals .= ($vals != '' ? ', ' : '');
                    
                    if(!isset($rs->fields[$field]))
                    {
                        $vals .= 'NULL';
                    }
                    elseif ($rs->fields[$field] != '')
                    {
                        $vals .= '\'' . addslashes($rs->fields[$field]) . '\'';
                    }
                    else
                    {
                        $vals .= '\'\'';
                    }
                }
                
                $insertStat .= $vals.');';
                
                // Go ahead and send the insert statement to the handler function.
                echo trim($insertStat);
                
                $rs->MoveNext();
            }
        }
        
        return true;
    }
}
