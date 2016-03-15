<?PHP
class csCore_Registry_Registry 
{
    var $_cache;
    
    function csCore_Registry_Registry() 
    {
        $this->_cache = array();
    }
    
    function setEntry($key, &$item) 
    {
        $this->_cache[$key] = &$item;
    }
    
    function &getEntry($key) 
    {
        return $this->_cache[$key];
    }
    
    function isEntry($key) 
    {
        return ($this->getEntry($key) !== null);
    }
    
    function getCacheAsArray()
    {
    	return $this->_cache;
    }
}
?>