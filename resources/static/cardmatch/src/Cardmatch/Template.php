<?php


class Cardmatch_Template
{
	/**
	 * array to hold errors to (potentially) display on the template
	 */
	private $_errors = array();

	private $_path;

	
	/**
	 * Template Constructor
	 * 
	 * @access public
	 */
    public function __construct() {
	    $this->setTemplatePath(TEMPLATE_BASE_PATH);
    }
    
    /**
     * Brings value into scope of template
     * via PHP nuance
     * 
     * @access public
     * @param string $key
     * @param mixed $value
     */
    public function assign($key, $value)
    {
    	$this->$key = $value;
    }

	/**
	 * Renders the template
	 *
	 * @param $tplFile
	 * @return boolean
	 */
	public function display( $tplFile )
	{
		$path = $this->_path."/$tplFile.tpl.php";
		return include($path);
	}

	/**
	 * Get contents of the template
	 *
	 * @param $tplFile
	 * @return String
	 */
	public function getDisplay( $tplFile )
	{
		ob_start();
		$this->display($tplFile);
		return ob_get_clean();
	}
    
    /**
     * Sets errors to be available for this template
     * 
     * @param string $id Identifier to use when referencing the error, could be any type allowed as array key
     * @param Cardmatch_Error $error Error object to be associated with the $id parameter
     */
    public function setError( $id, Cardmatch_Error $error )
    {
    	$this->_errors[$id] = $error;
    }

	/**
	 * @param $id
	 *
	 * @return Cardmatch_Error|boolean
	 */
	public function getError( $id )
    {
    	if ( !isset( $this->_errors[ $id ] ) )
    	{
    		return false;
    	}
    	
    	return $this->_errors[ $id ];
    }

	/**
	 * @param $catId
	 *
	 * @return int
	 */
	public function getResultCount( $catId )
    {
    	if ( isset( $this->resultCount ) && isset( $this->resultCount[ $catId ] ) )
    	{
    		return $this->resultCount[ $catId ];
    	}
    	
    	return 0;
    }

	public function setTemplatePath($path) {
		$this->_path = $path;
	}
    
    
}