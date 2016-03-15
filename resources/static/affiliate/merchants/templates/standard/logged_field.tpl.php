<? if($this->a_Auth->isLogged()) { ?>
    
<table width="200" border="0" cellspacing="2" cellpadding="0">
<tr>
    <td align="right"><?=L_G_LOGGEDUSER?><b><?=$this->a_Auth->userName?></b></td>
    <td width="3px">&nbsp;</td>
</tr>
<tr>
    <td align="right"><a href="index.php?md=Affiliate_Merchants_Views_AdminsManager&action=edit&aid=<?=$this->a_Auth->getUserID();?>&show_no_popup=1"><?=L_G_EDITUSERPROFILE?></a></td>
    <td width="3px">&nbsp;</td>
</tr>
<tr>
    <td align="right"><a href="logout.php"><?=L_G_LOGOUT?></a></td>
    <td width="3px">&nbsp;</td>
</tr>
</table>
<? } ?>
