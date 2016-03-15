<?
    include_once('global.php');

    // process logout
    $GLOBALS['Auth']->logout();
  
//    QUnit_Templates::includeTemplate('header_popup.tpl.php');

    if($GLOBALS['Auth']->getSetting('Aff_afflogouturl') != '')
        Redirect($GLOBALS['Auth']->getSetting('Aff_afflogouturl'));
    else
        Redirect('index.php');  
    exit;
?>