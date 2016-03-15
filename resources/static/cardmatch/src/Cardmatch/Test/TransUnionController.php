<?php

class Cardmatch_Test_TransUnionController extends Cardmatch_Test_AbstractTestController {

	/**
	 * @var Cardmatch_Channel_TransUnion
	 */
	protected $_channel;


	# Class precondition: This form should only be displayable to users within the Austin office.
	public function run() {

		$action = $this->_getParam('action');

		switch ($action) {
			case 'show_test_form':
				$this->_showForm();
				break;
			case 'run_tuna_test':
				$this->_processInquiry();
				break;
			default:
				$this->_showForm();
		}
	}

	protected function _getChannel() {
		if(!$this->_channel) {
			$config = $this->_getConfig();

		    $params = $config->channels->TransUnion->params;
			$this->_channel = new Cardmatch_Channel_TransUnion($params);
		}

		return $this->_channel;
	}


    protected function _showForm() {

//        echo '<hr>IP x forwarded for: ' . $_SERVER['HTTP_X_FORWARDED_FOR'] . '<hr>';
//        echo '<hr>IP remote addr: ' . $_SERVER['REMOTE_ADDR'] . '<hr>';

        $test = new Cardmatch_Client_TransUnion_TestUsers();
        $testUsers = $test->getTestUsers();

        $this->_tpl->assign( 'testUsers', $testUsers );
        $this->_tpl->assign( 'action', 'show_test_form' );

        $this->_displayTemplate('test/transunion-users');
	}


    protected function _processInquiry() {

        //create user objects from test data
        $test = new Cardmatch_Client_TransUnion_TestUsers();
		$testUsers = $test->getTestUsers();

	    /**
	     * Pull user to be tested from set of test users
	     * @var $user Cardmatch_User
	     */
		$user = $testUsers[intval($this->_getParam('user'))];


        //set user object
		$this->_user = $user;

	    $offers = $this->_channel->getOffers($this->_user, $this->_getVisitId());
	    $buckets = $this->_channel->getApprovedBuckets();
//	    $buckets = array(1,2,3);
//	    $products = array(1,2,3);
	    $this->_tpl->assign('offers', $offers);
	    $this->_tpl->assign('buckets', $buckets);
	    $this->_tpl->assign('user', $this->_user);

	    $template = 'test/transunion-results';
	    $this->_displayTemplate($template);
	}


	protected function _displayTemplate( $template ) {

		$this->_tpl->assign( 'messages', $this->_messages );
		$this->_tpl->assign( 'errorMessages', $this->_errorMessages );

		$this->_tpl->assign( 'user', $this->_user );

		$this->_tpl->assign( 'processFormAction', 'process_form' );
		$this->_tpl->assign( 'confirmUserInfoAction', 'confirm_user_info' );
		$this->_tpl->assign( 'editUserInfoAction', 'edit_user_info' );
		$this->_tpl->assign( 'processInquiryAction', 'process_inquiry' );
		$this->_tpl->assign( 'showErrorAction', 'show_error' );

		$this->_tpl->display( $template );

	}


}
