<?php

/**
 * Cardmatch Offer
 * Store results received from channels
 *
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Offer {

	protected $_cardId, $_ptvValues;

	public function __construct($_cardId, $_ptvValues = '')
	{
		$this->_cardId = $_cardId;
		$this->_ptvValues = $_ptvValues;
	}


	/**
	 * @param mixed $cardId
	 */
	public function setCardId($cardId)
	{
		$this->_cardId = $cardId;
	}

	/**
	 * @return mixed
	 */
	public function getCardId()
	{
		return $this->_cardId;
	}

	/**
	 * @param mixed $offerId
	 */
	public function setPtvs($ptvValues)
	{
		$this->_ptvValues = $ptvValues;
	}

	/**
	 * @return mixed
	 */
	public function getPtvValues()
	{
		return $this->_ptvValues;
	}
	
}
