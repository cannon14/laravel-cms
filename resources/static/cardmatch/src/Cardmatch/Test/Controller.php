<?php

class Cardmatch_Test_Controller {
	protected $tpl;
	protected $messages;
	protected $errorMessages;

    public function __construct() {
        $this->tpl = new Cardmatch_Template();

	    $configFile = CARDMATCH_PATH . '/config/channels.ini';
	    $config = new Zend_Config_Ini($configFile, APPLICATION_ENV);

	    if(!$config->testing->enabled) {
		    header("Location: /cardmatch");
		    exit;
	    }

    }

	public function run() {
		$this->showChannelsForm();
	}

    protected function displayTemplate( $template ) {
        $this->tpl->assign( 'messages', $this->messages );
        $this->tpl->assign( 'errorMessages', $this->errorMessages );
        $this->tpl->display( $template );

        exit;
    }

	public function showChannelsForm() {
		$this->displayTemplate('test/channels');
	}
}
