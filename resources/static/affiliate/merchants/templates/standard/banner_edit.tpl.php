
    <form enctype="multipart/form-data" action=index.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=3>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    
	
	
	<? if($_REQUEST['action'] == 'add') { ?>
	<tr>
      <td class=dir_form nowrap><?=L_G_ID;?></td>
      <td><input type=text name=bid size=60 value="<?=$_POST['bid']?>">
      &nbsp;* 8 char max </td>
    </tr>
	<? } else if($_REQUEST['action'] == 'edit') { ?>
	<tr>
      <td class=dir_form nowrap><?=L_G_ID;?></td>
      <td><b><?=$_POST['bid']?></b></td>
    </tr>
	<? } ?>
	<tr>
      <td width="5%" class=dir_form nowrap><?=L_G_PCNAME;?></td>
      
	  
	  
	  <td>
        <select name=campaign>
<?      while($data=$this->a_list_data->getNextRecord()) { ?>
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['campaign'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
        </select>&nbsp;*
      </td>
    </tr>    
    <tr>
      <td class=dir_form nowrap><?=L_G_DESTURL;?></td>
      <td>
        <input type=text name=desturl size=60 value="<?=$_POST['desturl']?>">&nbsp;*
      </td>
    </tr>
<? if($_REQUEST['type'] == 'text') { ?>
  
    <tr>
      <td class=dir_form nowrap><?=L_G_TITLE;?></td>
      <td><input type=text name=sourceurl size=60 value="<?=$_POST['sourceurl']?>"></td>
    </tr>
    <tr>
      <td class=dir_form nowrap valign=top><?=L_G_BANNERTEXT;?></td>
      <td>
      <textarea name=desc rows=4 cols=60><?=$_POST['desc']?></textarea>
      </td>
    </tr>

<? } else if($_REQUEST['type'] == 'html') { ?>
  
    <tr>
      <td class=dir_form nowrap valign=top><?=L_G_DESCRIPTION;?></td>
      <td>
      <textarea name=desc rows=8 cols=60><?=$_POST['desc']?></textarea>
      </td>
    </tr>
        
<? } else if($_REQUEST['type'] == 'image') { ?>
  
    <tr>
      <td class=dir_form nowrap><?=L_G_PICTUREURL;?></td>
      <td><input type=text name=sourceurl size=54 value="<?=$_POST['sourceurl']?>"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align=left><?=L_G_OR?></td>
    </tr>
    <tr>
      <td class=dir_form nowrap><?=L_G_SELECTIMAGE;?></td>
      <td><input type=file name=sourcebanner size=40 value="<?=$_POST['sourcebanner']?>"></td>
    </tr>
  
<? } ?>

    <tr>
      <td class=dir_form colspan=2 align=left>
      <? if($_REQUEST['action'] == 'edit') { ?>
	  <input type=hidden name=bid value=<?=$_POST['bid']?>>
	  <? } ?>
	  <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_BannerManager'>
      <input type=hidden name=action value=<?=$_POST['action']?>>
      <input type=hidden name=type value=<?=$_REQUEST['type']?>>
      <input type=hidden name=cid value=<?=$_POST['cid']?>>
      <input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
    <tr>
      <td class=smalltexthelp colspan=2>
<? 
      if($_REQUEST['type'] == 'html') {
          showHelp(L_G_HTMLBANNERHELP);
      } else if($_REQUEST['type'] == 'text') {
          showHelp(L_G_TEXTBANNERHELP);
      } else if($_REQUEST['type'] == 'image') {
          showHelp(L_G_IMAGEBANNERHELP);
      }
?>
      </td>
    </tr>
    </table>
    </form>

