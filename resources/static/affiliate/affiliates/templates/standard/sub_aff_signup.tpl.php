<center>
<table class=tableresult width=600 border=0 cellspacing=0 cellpadding=1>
<tr>
  <td class=listresult2 align=center><b><?=L_G_SUBAFFSIGNUP?></b></td>
</tr>
<tr>
  <td class=listresult2 align=center>
  <textarea cols=80 rows=2><?=$this->a_Auth->getSetting('Aff_signup_url')?>?pid=<?=$this->a_Auth->getUserID()?></textarea></td>
</tr>
<tr>
  <td class=listresult2 valign=top><? showHelp('L_G_HLPSUBAFFSIGNUP'); ?></td>
</tr>
</table>
</center>