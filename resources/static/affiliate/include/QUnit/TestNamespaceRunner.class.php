<?php
/**
*
*   @author Andrej Harsani
*   @copyright Copyright © 2004
*   @package wrapper
*   @since Version 0.1a
*   $Id: TestNamespaceRunner.class.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/
require_once('PHPUnit.php');

class QUnit_TestNamespaceRunner {
    var $_nameSpace;
    
    function QUnit_TestNamespaceRunner($nameSpace = '') {
        $this->_nameSpace = $nameSpace;
        $this->_suite = new PHPUnit_TestSuite();
    }
    
    function run($nameSpace = '') {
        if(!empty($nameSpace)) {
            if(!is_array($nameSpace)) {
                $this->_nameSpace = array($nameSpace);
            } else {
                $this->_nameSpace = $nameSpace;
            }
        }
        foreach ($this->_nameSpace as $nameSpace) {
            $this->_initSuite($nameSpace);
        }
        
        $result = PHPUnit::run($this->_suite);
        echo $result->toString();
    }
    
    function _initSuite($nameSpace) {
        $fullDir = BASEDIR . '/' . $nameSpace;
        if(!is_dir($fullDir)) {
            return;
        }

        $this->_createSuite($fullDir);
    }
    
    function _createSuite($file) {
        
        $classPrefix = str_replace(BASEDIR . '/', '', $file);
        $classPrefix = str_replace('/', '_', $classPrefix);
        $className = $classPrefix . '_Test_All';
        if(QUnit_Global::existsClass($className)) {
            $this->_add($className);
        }
        
        if ($dirHandle = opendir($file)) { 
            while(false !== ($dir = readdir($dirHandle))) { 
                if($dir != '.' && $dir != '..' && is_dir($file . '/' . $dir)) {
                    $this->_createSuite($file . '/' . $dir);                 
                }
            }
            closedir($dirHandle); 
        } 
    }
    
    function _add($className) {
        $allTest = QUnit_Global::newObj($className);
        
        foreach ($allTest->getTests() as $testClass) {
            if(!QUnit_Global::existsClass($testClass)) {
                echo "Cannot include: " . $testClass . "\n";
                continue;
            }
            QUnit_Global::includeClass($testClass);
            $this->_suite->addTestSuite($testClass);
        }
    }
}

?>