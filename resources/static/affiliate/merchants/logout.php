<?
    include_once('global.php');

    // process logout
    $GLOBALS['Auth']->logout();
  
//    QUnit_Templates::includeTemplate('header_popup.tpl.php');
  
    Redirect('index.php');  
    exit;
?>