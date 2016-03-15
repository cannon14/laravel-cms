<?
/**
* Return created object
*
* @author 	Ladislav Tamas
* @version  0.1a
*/

class QUnit_Messager
{
    function initMessages()
    {
        $GLOBALS['okMessage'] = '';
        $GLOBALS['errorMessage'] = '';
        $GLOBALS['okMessages'] = array();
        $GLOBALS['errorMessages'] = array();
    }
    
    //------------------------------------------------------------------------

    function resetMessages()
    {
        QUnit_Messager::initMessages();
    }
    
    //------------------------------------------------------------------------
    
	function setOkMessage($msg)
    {
        $GLOBALS['okMessage'] .= $msg.'<br>';
        $GLOBALS['okMessages'][] = $msg;
	}
	
	//------------------------------------------------------------------------

	function setErrorMessage($msg)
    {
        $GLOBALS['errorMessage'] .= $msg.'<br>';
        $GLOBALS['errorMessages'][] = $msg;
	}
	
	//------------------------------------------------------------------------
	
	function getOkMessage()
	{
	   return $GLOBALS['okMessage'];
    }
	
	//------------------------------------------------------------------------

	function getErrorMessage()
	{
	   return $GLOBALS['errorMessage'];
    }
    
	//------------------------------------------------------------------------
	
	function getOkMessages()
	{
        return $GLOBALS['okMessages'];
    }
	
	//------------------------------------------------------------------------

	function getErrorMessages()
	{
        return $GLOBALS['errorMessages'];
    }
    
}
?>
