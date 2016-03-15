<?  if( QUnit_Messager::getErrorMessage() != '') { ?>
        <center><span class='error'><?=QUnit_Messager::getErrorMessage()?></span></center><br>
<?  }
    if( QUnit_Messager::getOkMessage() != '') { ?>
        <center><span class='ok'><?=QUnit_Messager::getOkMessage()?></span></center><br>
<?
        QUnit_Messager::resetMessages();
    } 
?>