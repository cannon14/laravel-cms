<?php

class Cardmatch_Error {

	private $_level;
	private $_number;
	private $_message;

    public function __construct($level, $number, $message) {
    	$this->_level = $level;
    	$this->_number = $number;
    	$this->_message = $message;
    }
    
    public function getLevel()
    {
    	return $this->_level;
    }
    
    public function getNumber()
    {
    	return $this->_number;
    }
    
    public function getMessage()
    {
    	return $this->_message;
    }
    
    public function __toString()
    {
    	return "Error - Level: $this->_level Number: $this->_number Message: $this->_message";
    }
}