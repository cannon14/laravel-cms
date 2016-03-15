<? if($this->redirect_modul != '' ) { ?>
    <input type=button class=formbutton value='<?=L_G_BACK?>' onClick='javascript:document.location.href="index.php?md=<?=$this->redirect_modul?>";'>
<? } else { ?>
    <input type=button class=formbutton value='<?=L_G_BACK?>' onClick='javascript:history.go(-1);'>
<? } ?>
