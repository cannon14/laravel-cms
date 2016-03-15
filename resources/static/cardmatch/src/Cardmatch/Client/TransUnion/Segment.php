<?php

class Cardmatch_Client_TransUnion_Segment {

    protected $_prefix, $_length, $_data;

    public function __construct($prefix, $length, $data = "") {

        $this->_prefix = $prefix;
        $this->_data = $data;
        $this->_length = $length;

    }

    public function getRequestString() {
        $string = $this->_formatStringLength($this->_prefix . $this->_data, $this->getLength());
        return $string;
    }

	public function getResponseString() {
		$lenString = sprintf("%03d", $this->getLength());
		$string = $this->_formatStringLength($this->_prefix . $lenString . $this->_data, $this->getLength());
		return $string;
	}

    public function getPrefix() {
        return $this->_prefix;
    }

    public function setPrefix($_prefix) {
        $this->_prefix = $_prefix;
    }

    public function getLength() {
        return $this->_length;
    }

    public function setLength($_length) {
        $this->_length = $_length;
    }

    public function getData() {
        return $this->_data;
    }

    public function setData($_data) {
        $this->_data = $_data;
    }

	protected function _formatStringLength($string, $length)
	{

		if (strlen($string) > $length) {
			$string = substr($string, 0, $length);
		}
		while (strlen($string) < $length) {
			$string .= " ";
		}

		return $string;
	}


}

