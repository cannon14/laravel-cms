<?php

/**
 * Disclosure/confirmation text
 *
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */ 
class Cardmatch_Disclosure {


	public function __construct($db = null) {

		if($db == null) {
			$db = Cardmatch_Database::getDbAdapter();
		}

		$this->_db = $db;
	}

	/**
	 * @param Cardmatch_User $user
	 * @param string $version Disclosure text version
	 *
	 * @return int Number of inserted rows
	 */
	public function saveConsentLog(Cardmatch_User $user, $version) {

		/**
		 * For some unknown reason, we're generating
		 * our own ids instead of using an autoincrement
		 * field.
		 */
		$consentId = md5(rand().date('Y-m-d H:i:s'));

		$values = array(
			'consent_id' => $consentId,
			'first_name' => $user->getFirstName(),
			'middle_initial' => $user->getMiddleInitial(),
			'last_name' => $user->getLastName(),
			'consent_version' => $version,
			'insert_time' => new Zend_Db_Expr('NOW()'),
		);

		return $this->_db->insert('tuna_consent_log', $values);
	}

	/**
	 * @param $version
	 *
	 * @return string
	 */
	public function getDisclosureText($version) {

		$select = $this->_db->select();

		$select->from('tuna_consent_versions')
			->where('consent_version = ?', $version);

		$row = $this->_db->query($select)->fetch();

		$text = $row['text'];

		return $text;

	}
}
 