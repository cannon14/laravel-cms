<?

class QUnit_UI_ListView
{
    var $columns;
    var $name;
    var $dbid;
    
    //------------------------------------------------------------------------
    
    function setColumns($columns) 
    {
        $this->columns = $columns;
    }
    
    //------------------------------------------------------------------------
    
    function setName($name) 
    {
        $this->name = $name;
    }

    //------------------------------------------------------------------------
    
    function getName() 
    {
        return $this->name;
    }    
}
?>
