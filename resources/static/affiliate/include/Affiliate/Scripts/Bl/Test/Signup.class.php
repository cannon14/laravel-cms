<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright � 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: Signup.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

QUnit_Global::includeClass('Affiliate_Test_SetUpScriptsTest');

class Affiliate_Scripts_Bl_Test_Signup extends Affiliate_Test_SetUpScriptsTest
{
    function setUp() 
    {
        $this->mainSetUp();
        $this->_registrator = QUnit_Global::newObj('Affiliate_Scripts_Bl_Signup');
    }

    //--------------------------------------------------------------------------
    // class tests
    //--------------------------------------------------------------------------
/*
    function testSetLanguageFile()
    {
        // language file
        $this->assertTrue($this->_registrator->setLanguageFile('english'),
                            'Set language file failed');

        // language file
        $this->assertFalse($this->_registrator->setLanguageFile('aaa'),
                            'Set language file passed');

    }
*/
    //--------------------------------------------------------------------------

    function testGetParentUser()
    {
        $_POST['parentuserid'] = '3';

        // language file
        $this->assertEquals('3',$this->_registrator->getParentUser(),
                                'Get parent user failed');
    }

    //--------------------------------------------------------------------------    
    // Other functions
    //--------------------------------------------------------------------------
/*
    function testSetRegVariables() 
    {
        $this->fail('abdc');
    }
*/
}

?>