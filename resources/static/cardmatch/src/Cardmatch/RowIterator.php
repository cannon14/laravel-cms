<?php

abstract class Cardmatch_RowIterator {

	private $rs;
	private $numRows;
	private $curRow;

    function __construct($rs) {
    	$this->rs = $rs;
    	$this->numRows = mysql_num_rows( $rs );
    	$this->curRow = 0;
    }
    
    public function hasNext()
    {
    	return $this->curRow < $this->numRows;  		
    }
    
    public function getNext()
    {
    	$this->curRow++;
	    $row = $this->_buildFromRow(mysql_fetch_assoc( $this->rs ));
	    return $row;
    }

    
    public function rewind()
    {
    	if ( $this->numRows > 0 )
    	{
    		mysql_data_seek( $this->rs, 0 );
    		$this->curRow = 0;
    	}
    }

    public function length(){
        return $this->numRows;
    }

	/**
	 * @param Array $rs
	 *
	 * @return mixed
	 */
	protected abstract function _buildFromRow($rs);
}