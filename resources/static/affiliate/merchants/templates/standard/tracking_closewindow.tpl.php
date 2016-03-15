<center>
<? if($this->redirect_modul != '' ) { ?>
    <input type=button class=formbutton value='<?=L_G_CLOSE?>' onClick='javascript:window.opener.document.location.href="index.php?md=<?=$this->redirect_modul?>&mode=<?=$_REQUEST['mode']?>"; window.close();'>
<? } else { ?>
    <input type=button class=formbutton value='<?=L_G_CLOSE?>' onClick='window.close();'>
<? } ?>
</center>
