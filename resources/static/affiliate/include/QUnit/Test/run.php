<?php
include_once('../Global.class.php');
/**
*
*   @author Andrej Harsani
*   @copyright Copyright © 2004
*   @package QUnit
*   @since Version 0.1a
*   $Id: run.php,v 1.2 2008-04-21 19:58:17 cesarg Exp $
*/

$namespaceRunner = QUnit_Global::newObj('QUnit_TestNamespaceRunner');
$namespaceRunner->run('QUnit');
?>