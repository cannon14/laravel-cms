<? if($this->a_action_permission['backup']) { ?>
<table width="450" class=listing border=0 cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(1, L_G_DBBACKUP); ?>
<tr>
  <td class=dir_form valign=top align="center" nowrap><?=L_G_DBBACKUPHLP?></td>
</tr>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
<? if(AFF_DEMO != 1) { ?>   
  <form enctype="multipart/form-data" action=index.php method=post>
<? } ?>
  Gzip compress file 
  <?=L_G_NO?> <input type="radio" name="gzipcompress" value="0" checked>
  &nbsp;&nbsp;
  <?=L_G_YES?> <input type="radio" name="gzipcompress" value="1">
  <br>
  <input type="submit" class=formbutton value="<?=L_G_DBBACKUPBTN?>">
<? if(AFF_DEMO != 1) { ?>
  <input type="hidden" name="md" value="Affiliate_Merchants_Views_Maintenance">
  <input type="hidden" name="action" value="backup">
  <input type="hidden" name="commited" value="yes">
  </form>
<? } ?>
  </td>
</tr>
</table>
<br>
<? } ?>

<? if($this->a_action_permission['restore']) { ?>
<table width="450" class=listing border=0 cellspacing=0 cellpadding=2>
<? QUnit_Templates::printFilter(1, L_G_DBRESTORE); ?>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
  <?=L_G_DBRESTOREHLP?>
  <br>
  <font color="#ff0000"><?=L_G_DBRESTOREWARNING?></font>
  </td>
</tr>
<tr>
  <td class=dir_form valign=top align="center" nowrap>
<? if(AFF_DEMO != 1) { ?>   
  <form enctype="multipart/form-data" action=index.php method=post>
<? }
  print L_G_DBBACKUPFILE?> <input type="file" name="sqlfile"><br>
  <input type="submit" class=formbutton value="<?=L_G_DBRESTOREBTN?>">
<? if(AFF_DEMO != 1) { ?>
  <input type="hidden" name="md" value="Affiliate_Merchants_Views_Maintenance">
  <input type="hidden" name="action" value="restore">
  <input type="hidden" name="commited" value="yes">
  </form>
  </td>
</tr>
<? } ?>
</table>
<? } ?>

