<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright ? 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: EmailTemplates.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class QCore_Test_EmailTemplates extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('QCore_EmailTemplates');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------

    function testGetFilledEmailMessage()
    {
        $params = array('pwd' => '3');
    
        // userid, emailcategory, lang, params
        $data = $this->_registrator->getFilledEmailMessage('3',AFF_EMAIL_SIGNUP,'english',$params);

        $subject = '';
        $text = '';

        $this->assertEquals($subject, $data['subject'], 'Get email subject for emailtemplate: '.AFF_EMAIL_SIGNUP.' failed');
        $this->assertEquals($text, $data['text'], 'Get email text for emailtemplate: '.AFF_EMAIL_SIGNUP.' failed');
            
    }

    //--------------------------------------------------------------------------
}
?>
