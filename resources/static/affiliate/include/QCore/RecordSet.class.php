<?
//============================================================================
// Copyright (c) Maros Fric, Ladislav Tamas, webradev.com 2004
// All rights reserved
//
// For support contact info@webradev.com
//============================================================================

class QCore_RecordSet
{
    var $temp_rs = null;
    
    //--------------------------------------------------------------------------
    
    function getNextRecord()
    {
        if(is_object($this->temp_rs))
        {
            return $this->_getNextRecord();
        }
        else if(is_array($this->temp_rs))
        {
            return $this->_getNextArray();
        }
        else if(is_string($this->temp_rs))
        {
            $temp = $this->$temp_rs;
            $this->setTemplateRS(null);
            return $temp;
        }
        else return false;
    }

    //--------------------------------------------------------------------------
    
    function _getNextRecord()
    {
        if($this->isRecordEOF())
            return false;

        $temp = null;
        $temp = $this->temp_rs->fields;

        $this->temp_rs->MoveNext();

        return $temp;
    }

    //--------------------------------------------------------------------------

    function _getNextArray()
    {
        $temp = current($this->temp_rs);
        next($this->temp_rs);
        
        return $temp;
    }

    //--------------------------------------------------------------------------

    function isRecordEOF()
    {
        if($this->temp_rs->EOF)
        {
            return true;
        }
        else
            return false;
    }
    
    //--------------------------------------------------------------------------
    
    function setTemplateRS($temp_rs)
    {
        $this->temp_rs = $temp_rs;
    }

    //--------------------------------------------------------------------------
    
    function getTemplateRS()
    {
        return $this->temp_rs;
    }
}
?>