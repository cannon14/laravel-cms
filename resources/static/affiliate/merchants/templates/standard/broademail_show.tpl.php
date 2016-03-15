<script>
function changeCategory(sel)
{
  if(sel.value != '')
  {
    document.location.href = 'index.php?md=Affiliate_Merchants_Views_BroadcastMessage&emailcategory='+sel.value;
  }
}

function broadcastEmail()
{
  document.location.href = 'index.php?md=Affiliate_Merchants_Views_BroadcastMessage';
}

function moveFromSelectToSelect(from,to)
{   
  for(i=1; i<from.options.length; i++)
  {
    if(from.options[i].selected == true)
    {
      var option0 = new Option(from.options[i].text,from.options[i].value);
      from.options[i] = null;
      to.options[to.options.length++] = option0;
      i--;
    }
  }
}

function moveAllFromSelectToSelect(from,to)
{   
  for(i=1; i<from.options.length; i++)
  {
      var option0 = new Option(from.options[i].text,from.options[i].value);
      from.options[i] = null;
      to.options[to.options.length++] = option0;
      i--;
  }
}

function validate_selects(form)
{
  form.selectedusers.value = codeSelected(form.chosenaff);
}

function codeSelected(select_object)
{
  codedString = '';
  for (i=1; i<select_object.options.length; i++)
  {
    codedString = codedString + ',' + select_object.options[i].value;
  }
  return codedString.substring(1,codedString.length);
}

function validate(form)
{
  if(form.chosenaff.options.length==1)
  {
    alert("<?=L_G_ERRNOAFFILIATES?>");
    return false;
  }

  if(form.emailsubject.value == '')
  {
    alert("<?=L_G_ERRNOSUBJECT?>");
    return false;
  }

  if(form.emailtext.value == '')
  {
    alert("<?=L_G_ERRNOTEXT?>");
    return false;
  }

  validate_selects(form);
}
</script>
<? if($_POST['action'] != 'edit') { ?>
     <form action=index.php method=post onsubmit="return validate(this)">
<? } else { ?>
     <form action=index_popup.php method=post onsubmit="return validate(this)">
<? } ?>
<table border=0 cellspacing=0 cellpadding=2>
  <tr>
  <td>
    <table class=listing border=0 cellspacing=0 cellpadding=0>
    <?
      QUnit_Templates::printFilter(2, $_POST['header']);
      if($this->a_Auth->getSetting('Aff_display_news') == '1') {
        if($_POST['action'] != 'edit') {
          if($_POST['message_type'] == '') $_POST['message_type'] = MESSAGETYPE_EMAIL; ?>
          <tr>
            <td align=left colspan=2 nowrap>&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=message_type value='<?=MESSAGETYPE_EMAIL?>' <?=($_POST['message_type'] == MESSAGETYPE_EMAIL ? ' checked' : '')?>><?=L_G_COMPOSE_EMAIL?>&nbsp;
            </td>
          </tr>
          <tr>
            <td align=left colspan=2 nowrap>&nbsp;
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=radio name=message_type value='<?=MESSAGETYPE_NEWS?>' <?=($_POST['message_type'] == MESSAGETYPE_NEWS ? ' checked' : '')?>><?=L_G_COMPOSE_NEWS?>&nbsp;
              &nbsp;<br>&nbsp;
            </td>
          </tr>
        <? } else { ?>
          <input type=hidden name=message_type value='<?=$_POST['message_type']?>'>
        <? } ?>
      <? } else { ?>  
        <input type=hidden name=message_type value='<?=MESSAGETYPE_EMAIL?>'>
      <? } ?>
    <tr>
      <td colspan=2 align=left nowrap>&nbsp;<b><?=L_G_CHOOSEAFFILIATES?></b></td>
    </tr>

    <tr>
      <td align=left colspan=2>
        <table border=0>
          <tr>
            <td class=artdata>&nbsp;<input type="hidden" name="selectedusers">
              <select multiple name='allaff' size=5>
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>
<?
              $data3 = $this->a_list_data3;
              while($data1=$this->a_list_data1->getNextRecord()) {
                if(is_array($data3) && in_array($data1['userid'], $data3)) continue;

                echo "<option value=".$data1['userid'].">".$data1['userid']." : ".$data1['name']." ".$data1['surname']." : ".$data1['username'];
                if($data1['rstatus'] == AFFSTATUS_SUPPRESSED) echo " - ".L_G_SUPPRESSED;
                echo "</option>\n";
              }
?>      
              </select>
            </td>
            <td class=artdata align=center>
              <INPUT TYPE="button" class=formbutton VALUE=">>" onClick="moveAllFromSelectToSelect(this.form.allaff,this.form.chosenaff)"><br>
              <INPUT TYPE="button" class=formbutton VALUE=">" onClick="moveFromSelectToSelect(this.form.allaff,this.form.chosenaff)"><br><font size=1>&nbsp;</font><br>
              <INPUT TYPE="button" class=formbutton VALUE="<" onClick="moveFromSelectToSelect(this.form.chosenaff,this.form.allaff)"><br>
              <INPUT TYPE="button" class=formbutton VALUE="<<" onClick="moveAllFromSelectToSelect(this.form.chosenaff,this.form.allaff)">
            </td>
            <td class=artdata>
              <select multiple name='chosenaff' size=5>
                <option value=0>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </option>

<?
              if($_POST['action'] == 'edit') {
                while($data2=$this->a_list_data2->getNextRecord()) {
                  if(is_array($data3) && !in_array($data2['userid'], $data3)) continue;

                  echo "<option value=".$data2['userid'].">".$data2['userid']." : ".$data2['name']." ".$data2['surname']." : ".$data2['username'];
                  if($data2['rstatus'] == AFFSTATUS_SUPPRESSED) echo " - ".L_G_SUPPRESSED;
                  echo "</option>\n";
                }
              }
?>      
              </select>
              &nbsp;&nbsp;<a href=cat_add.php><? print $lu_addnewcat; ?></a>
            </td>
          </tr>
        </table>
        <br>
      </td>
    </tr>
    <tr>
      <td align=left nowrap>&nbsp;<b><?=L_G_TITLE?></b></td>
      <td align=left><input type=text size=60 name=emailsubject value='<?=str_replace("'",'',$_POST['emailsubject'])?>'></td>
    </tr>
    <tr>
      <td colspan=2 align=left nowrap>&nbsp;<b><?=L_G_MESSAGE_TEXT?></b></td>
    </tr>   
    <tr>
      <td colspan=2>&nbsp;
        <textarea name=emailtext rows=15 cols=80><?=$_POST['emailtext']?></textarea>&nbsp;
      </td>
    </tr>
    <tr>
      <td colspan=2>&nbsp;<br>&nbsp;
        <input type=hidden name=commited value=yes>
        <? if($_POST['action'] != 'edit') { ?>
             <input type=hidden name=md value='Affiliate_Merchants_Views_BroadcastMessage'>
        <? } else { ?>
            <input type=hidden name=md value='Affiliate_Merchants_Views_Communications'>
        <? } ?>
        <input type=hidden name=action value='<?=$_POST['action']?>'>
        <input type=hidden name=postaction value='<?=$_POST['postaction']?>'>
        <input type=hidden name=mid value='<?=$_REQUEST['mid']?>'>
        <input class=formbutton type=submit value='<?=L_G_SUBMIT; ?>'>     
        <br>&nbsp;
      </td>
    </tr>
    </table>
  </td>
  <td align=left valign=top>   
    <table class=listing border=0 cellspacing=0 cellpadding=1>
      <? QUnit_Templates::printFilter(1, L_G_ALLOWEDCONSTANTS); ?>
      <tr>
        <td valign=top align=left><? showHelp('L_G_HLPEMAILTEMPLATES'); ?></td>
      </tr>    
      <tr>
        <td valign=top align=left><?=L_G_HLP_AFF_EMAIL_GLOBAL_CONSTANTS?></td>
      </tr>
    </table>
  </td>
  </tr>
</table>
</form>
