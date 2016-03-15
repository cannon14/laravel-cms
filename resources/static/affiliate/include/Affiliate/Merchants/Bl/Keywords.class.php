<?php
//============================================================================
// Rapido Technologies Addition
//============================================================================

QUnit_Global::includeClass('QUnit_Messager');

class Affiliate_Merchants_Bl_Keywords
{
    function checkKeywordExists($term)
    {
        $sql = 'select keyword_text_id from ' . KEYWORD_TEXT_TABLE . ' '.
               'where keyword_text=' . _q($term);
              
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
        return $rs->fields['keyword_text_id'];
    }
    
    //--------------------------------------------------------------------------
    
    function checkKeywordTypeExists($type, $keyword_text_id)
    {
        $sql = 'select keyword_id from ' . KEYWORDS_TABLE .
               ' where keyword_text_id=' . _q($keyword_text_id) .
               ' AND keyword_type=' . _q($type);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
        return $rs->fields['keyword_id'];
    }
    
    //--------------------------------------------------------------------------
    
    function getLastTypeEntered()
    {
    	$sql = 'SELECT keyword_id FROM ' . KEYWORDS_TABLE .
               ' ORDER BY update_time desc' .
               ' LIMIT 1';
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
        return $rs->fields['keyword_id'];
    }
    
    //--------------------------------------------------------------------------
    
    function getKeywordTypesAsArray($keyword_text_id)
    {
        $sql = 'select keyword_id, keyword_type from ' . KEYWORDS_TABLE .
               ' where keyword_text_id=' . _q($keyword_text_id);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
		$types = array();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['keyword_id'] = $rs->fields['keyword_id'];
            $temp['keyword_type'] = $rs->fields['keyword_type'];

            $types[$rs->fields['keyword_id']] = $temp;

            $rs->MoveNext();
        }
        
        return $types;
    }
    
    //--------------------------------------------------------------------------
    
    function getKeywordTypesById($ids)
    {
    	$sqlEIDs = "('" . implode("','", $ids) . "')";
    	
        $sql = 'select keyword_id, keyword_type from ' . KEYWORDS_TABLE .
               ' where keyword_id in ' . _q($sqlEIDs);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
		$types = array();
        while(!$rs->EOF)
        {
            $temp = array();
            $temp['keyword_id'] = $rs->fields['keyword_id'];
            $temp['keyword_type'] = $rs->fields['keyword_type'];

            $types[$rs->fields['keyword_id']] = $temp;

            $rs->MoveNext();
        }
        
        return $types;
    }
    
    //--------------------------------------------------------------------------
    
    function checkKeywordTypeDeleted($keyword_id)
    {
        $sql = 'select keyword_id from ' . KEYWORDS_TABLE .
               ' where keyword_id=' . _q($keyword_id);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
		
        return true;
    }

    //--------------------------------------------------------------------------

    function insert($data)
    {
    	$sql = 'INSERT INTO ' . KEYWORD_TEXT_TABLE . 
				' (`'.implode('`,`', array_keys($data)) .
				'`) VALUES ("'.implode('","', $data).'")';
	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if (!$rs){
			QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
			QUnit_Messager::setErrorMessage(L_G_DBERROR . ' Error adding keyword.');
            return false;
		}
		else
		{
			$retId = 'SELECT keyword_text_id FROM ' . KEYWORD_TEXT_TABLE . ' ORDER BY keyword_text_id DESC LIMIT 1';
			$rsId = QCore_Sql_DBUnit::execute($retId, __FILE__, __LINE__);	
			
			if(!$rsId) {
	            QUnit_Messager::setErrorMessage(L_G_DBERROR);	
	        	return false;
	        }
	        
	        QUnit_Messager::setOkMessage(L_G_RT_KEYWORDADDED);
	        return $rsId->fields['keyword_text_id'];
		}
    }

    //--------------------------------------------------------------------------
    
    function insertType($data)
    {
    	$sql = 'INSERT INTO ' . KEYWORDS_TABLE. 
				' (`'.implode('`,`', array_keys($data)) .
				'`) VALUES ("'.implode('","', $data).'")';
	    $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		
		if (!$rs){
			QCore_History::DebugMsg(WLOG_DBERROR, $sql, __FILE__, __LINE__);
			QUnit_Messager::setErrorMessage(L_G_DBERROR . ' Error adding keyword type.');
            return false;
		}
		
		return true;
    }

    //--------------------------------------------------------------------------

    function delete($EIDs)
    {
    	$sqlEIDs = "('" . implode("','", $EIDs) . "')";
        
        $update_time = date('Y-m-d h:i:s');
        
        $sql = 'update ' . KEYWORD_TEXT_TABLE . ' set deleted=1' .
        		' where keyword_text_id in ' . $sqlEIDs;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        
        $sql2 = 'update ' . KEYWORDS_TABLE . ' set deleted=1, update_time=' ._q($update_time).
        		' where keyword_text_id in ' . $sqlEIDs;
        $rs2 = QCore_Sql_DBUnit::execute($sql2, __FILE__, __LINE__);
        
        if (!$rs2)
        {
        	QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }     
        
		return true;
    }
    
    //--------------------------------------------------------------------------

    function deleteType($EIDs)
    {
    	$sqlEIDs = "('" . implode("','", $EIDs) . "')";
    	
    	$update_time = date('Y-m-d h:i:s');
    	
        $sql = 'update ' . KEYWORDS_TABLE . ' set deleted=1, update_time=' . _q($update_time) .
        		' where keyword_id in ' . $sqlEIDs;
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
        	QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }
        
        return true;
    }
    
    //--------------------------------------------------------------------------

    function updateKeyword($params)
    {
        $sql = 'update ' . KEYWORD_TEXT_TABLE . ' set deleted='. _q($params['deleted']) .
        		', keyword_text=' . _q($params['keyword_text']) .
				' where keyword_text_id=' . $params['keyword_text_id'];
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
        
        if (!$rs)
        {
        	QUnit_Messager::setErrorMessage(L_G_DBERROR);
        	return false;
        }
        
        QUnit_Messager::setOkMessage(L_G_RT_KEYWORDEDITED);
        
		return true;
    }
    //--------------------------------------------------------------------------
    
    function activateKeyword($keyword_text_id)
    {
        $update_time = date('Y-m-d h:i:s');
        
        $sql = 'update ' . KEYWORD_TEXT_TABLE . ' set deleted=0'.
               ' where keyword_text_id='._q($keyword_text_id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }
		
		QUnit_Messager::setOkMessage(L_G_RT_KEYWORDADDED);
		
        return true;
    }
    //--------------------------------------------------------------------------
    
    function activateKeywordType($keyword_id)
    {
    	$update_time = date('Y-m-d h:i:s');
    	
        $sql = 'update ' . KEYWORDS_TABLE . ' set deleted=0, update_time=' . _q($update_time) .
               ' where keyword_id='._q($keyword_id);
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if(!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return false;
        }

        return true;
    }
    //--------------------------------------------------------------------------
    
    function loadKeywordInfo($keyword_id)
    {
    	$sql = 'select k.keyword_id, kt.keyword_text FROM keywords as k LEFT JOIN keyword_text as kt ON k.keyword_text_id=kt.keyword_text_id ' .
    			'WHERE k.keyword_id=' . _q($keyword_id);
        
        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
        
        if(!$rs)
        {
          QUnit_Messager::setErrorMessage(L_G_DBERROR);
          return false;
        }
        
        return $rs->fields;
    }
}
?>
