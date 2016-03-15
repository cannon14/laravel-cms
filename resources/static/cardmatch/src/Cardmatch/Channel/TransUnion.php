<?php

/**
 * Get products
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */
class Cardmatch_Channel_TransUnion extends Cardmatch_Channel_Abstract {

	protected $_buckets;

	private $_error;

	/**
	 * @var Cardmatch_Client_TransUnion
	 */
	protected $_client;

	/**
	 * @param Cardmatch_User $user
	 * @param $visitId
	 *
	 * @return Cardmatch_Offer[]
	 */
	public function getOffers(Cardmatch_User $user = null, $visitId = '') {

		$buckets = $this->_client->getApprovedBuckets($user, $visitId);

		$this->_logger->debug("Buckets received: " . implode('|', $buckets));

		$this->_error = $this->_client->getError();

		$this->_buckets = $buckets;

		if (empty($buckets)) {
			// customer was not approved for any buckets
			$cards = array();
			$this->_logger->debug("Transunion - No buckets received");
		} else {
			$logMsg = "Transunion - Buckets received: ".implode(',', $buckets);
			$this->_logger->debug($logMsg);
			$cards = $this->_getCardsFromBuckets($buckets);
		}

		$offers = array();
		foreach ($cards as $card) {
			$offer = new Cardmatch_Offer($card);
			$offers[] = $offer;
		}

		return $offers;
	}

	public function getErrors() {

		$errors = array();

		if (!empty($this->_error)) {
			$errors = array($this->_error);
		}

		return $errors;
	}

	public function clearErrors() {
		$this->_error = false;
	}

	public function getApprovedBuckets() {
		return $this->_buckets;
	}

	public function ackDisplayed() {
		return true;
	}

	/**
	 * @param Zend_Config $config
	 *
	 * @return Cardmatch_Client_TransUnion
	 */
	protected function _createApiClient(Zend_Config $config) {
		$this->_client = new Cardmatch_Client_TransUnion($config);
		return $this->_client;
	}

	public function setApiClient($client) {
		$this->_client = $client;
	}

	/**
	 * @param array $buckets
	 * @return array
	 */
	protected function _getCardsFromBuckets($buckets) {

		$bucketIds = array();
		$cardIds = array();

		if (count($buckets) == 0) {
			return $cardIds;
		}

		foreach ($buckets as $name) {
			$bucketId = $this->_getBucketIdByName($name);
			if ($bucketId) {
				$bucketIds[] = $bucketId;
			}
		}

		$cardquery = $this->_getCardQueryClient();

		$bucketList = implode('|', $bucketIds);
		if (count($buckets) != count($bucketIds)) {
			$msg = "TUNA: Unknown buckets received: " . implode('|', $bucketIds);
			$this->_logger->err($msg);
		}


		try {
			$cardQueryCards = $cardquery->getCreditCardsByExpression($bucketList, CMS_CONTEXT_IFILTERING);
			foreach ($cardQueryCards as $cardInfo) {
				$cardIds[] = $cardInfo->cardId;
			}

		} catch (Exception $e) {
			$this->_logger->err("There was a problem communicating with cardquery: " . $e->getMessage());
		}


		return $cardIds;
	}

	protected function _getBucketIdByName($bucketName) {
		$sql = "SELECT card_category_id
                FROM cms_card_categories
                WHERE card_category_name = '" . $bucketName . "'
                AND deleted != 1";
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);
		if ($rs && !$rs->EOF) {

			return $rs->fields['card_category_id'];
		} else {
			return false;
		}
	}

	/**
	 * @return CardQuery
	 */
	protected function _getCardQueryClient() {
		require_once(CARDMATCH_PATH . "/src/Cardmatch/Client/CardQuery/CardQuery.class.php");
		return new CardQuery();
	}


}
