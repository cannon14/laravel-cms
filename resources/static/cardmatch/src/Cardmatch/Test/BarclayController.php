<?php

class Cardmatch_Test_BarclayController extends Cardmatch_Test_AbstractTestController {
	# Class precondition: This form should only be displayable to users within the Austin office.\
	#       	        Use .htaccess to refine the available IPs to only those in the Austin office.

	public function run() {

		$action = $this->_getParam('action');

		switch ($action) {
			case 'get-offers':
				$this->_processInquiry();
				break;
			default:
				$this->_showForm();
		}

	}

	protected function _getChannel() {

		if(!$this->_channel) {
			$configFile = CARDMATCH_PATH . '/config/channels.ini';

			// We always want the test pages to point to the test servers
			$config = new Zend_Config_Ini($configFile, 'staging');
			$channelConfig = $config->channels->Barclay->params;
			$this->_channel = new Cardmatch_Channel_Barclay($channelConfig);
		}

		return $this->_channel;

	}

	protected function _showForm() {

		$users = $this->_getTestUsers();
		$this->_tpl->assign('testUsers', $users);
		$this->_tpl->display('test/barclay-users');

	}

	protected function _processInquiry() {

		$users = $this->_getTestUsers();
		$user = $users[$this->_getParam('user')];

		$channel = $this->_getChannel();
		$offers = $channel->getOffers($user, $this->_getVisitId());
		$rawOffers = $channel->getRawOffers();
		$this->_tpl->assign('user', $user);
		$this->_tpl->assign('offers', $offers);
		$this->_tpl->assign('rawOffers', $rawOffers);
		$this->_tpl->display('test/barclay-results');
	}


	protected function _getTestUsers() {

		$path = CARDMATCH_PATH.'/tests/data/barclay/sampleApplicants.json';

		$contents = file_get_contents($path);
		$applicants = json_decode($contents);

		$users = array();

		foreach($applicants as $applicant) {

			$user = new Cardmatch_User();

			$user->setFirstName($applicant->first);
			$user->setLastName($applicant->last);
			$user->setStreetAddress($applicant->street);
			$user->setCity($applicant->city);
			$user->setState($applicant->state);
			$user->setZipCode($applicant->zip);
			$user->setSSN($applicant->ssn);

			$users[] = $user;

		}

		return $users;
	}
}
