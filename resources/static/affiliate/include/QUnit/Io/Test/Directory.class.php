<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright (c) 2004 Quality Unit s.r.o.
*   @package QUnit
*   @since Version 0.1a
*   $Id: Directory.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

class QUnit_Io_Test_Directory extends PHPUnit_TestCase {
    var $_baseDir;
    
    function setUp() {
        QUnit_Global::includeClass('QUnit_Io_Directory');
        $this->_baseDir = dirname(__FILE__) . '/';
    }
    
    function testCreateDirectory() {
        $testDir = 'aaa/bbb/ccc/';
        
        $this->assertFalse(is_dir($this->_baseDir . $testDir), 'directory shouldnt exist');
        QUnit_Io_Directory::create($this->_baseDir . $testDir);
        $this->assertTrue(is_dir($this->_baseDir . $testDir), 'directory should exists');
        $this->_clear($testDir);
    }

    function testCreateEmtyPathDir() {
        $this->assertFalse(QUnit_Io_Directory::create(''));
    }
    
    function _clear($path) {
        $dir = $path;
        
        do {
            if(!QUnit_Io_Directory::delete($this->_baseDir . $dir)) {
                return;
            }
        } while('.' != ($dir = dirname($dir)));
    }
}

?>