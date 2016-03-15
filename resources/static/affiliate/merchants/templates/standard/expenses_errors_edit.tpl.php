<?PHP
	include('calendar_functions.tpl.php');
?>

<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<center>
  <form action=index_popup.php method=post name=update>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, L_G_EDITEXPENSE); ?>
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_FOR?> <?=L_G_AFFILIATE?></td>
     <td align=left>
        <select name=userid>
<?      while($data=$this->a_list_data2->getNextRecord()) { ?>
          <option value='<?=$data['userid']?>' <?=($_POST['userid'] == $data['userid'] ? 'selected' : '')?>
                ><?=(($data['name'] || $data['surname']) ? $data['name'].' '.$data['surname'] : $data['username'])?></option>
<?      } ?>
      </select>
     </td>
    </tr>   
    
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_FOR?> <?=L_G_CAMPAIGN?></td>
     <td align=left>
        <select name=campaignid>
<?      while($data=$this->a_list_data1->getNextRecord()) { ?>
         <option value='<?=$data['campaignid']?>' <?=($_POST['campcategoryid'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>         
      </select>    
     </td>
    </tr>   
	<tr>
      <td align=left>
        &nbsp;CID-Channel
      </td>
      <td align=left>
        <select name=channel>
          <option value='_'><?=L_G_NONE?></option>
<?      while($data=$this->cid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['trackerId']?>' <?=($_POST['tracker'] == $data['trackerId'] ? 'selected' : '')?>><?=$data['name']?> (<?=$data['trackerId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
	<tr>
      <td align=left>
        &nbsp;DID-Keyword
      </td>
      <td align=left>
        <select name=episode>
          <option value='_'><?=L_G_NONE?></option>
<?      while($data=$this->did_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['keywordId']?>' <?=($_POST['keyword'] == $data['keywordId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['keywordId']?>)</option>
<?      } ?>          
      

     </select>&nbsp;&nbsp;
      </td>
    </tr>
	<tr>
      <td align=left>
        &nbsp;EID-TimeSlot
      </td>
      <td align=left>
        <select name=timeslot>
          <option value='_'><?=L_G_NONE?></option>
<?      while($data=$this->eid_list_data1->getNextRecord()) { ?>
          <option value='<?=$data['timeslotId']?>' <?=($_POST['timeslot'] == $data['timeslotId'] ? 'selected' : '')?>><?=$data['name']?>  (<?=$data['timeslotId']?>)</option>
<?      } ?>          
      </select>&nbsp;&nbsp;
      </td>
    </tr>
	
	
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_TOTALEXPENSE?></td>
     <td align=left>
        <? if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=totalexpense size=6 value='<?=$_POST['totalexpense']?>'>
        <? if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
     </td>
    </tr>          
      <tr>
      <td align="left">&nbsp;<?=L_G_QUANTITY?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left"></td>
                <td>
					<input type='text' name='quantity' size='4' value='<?= $_POST['quantity']?>'>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>    
    
    <tr>
      <td colspan=2><HR size=1 noshade></td>
    </tr>           
      <tr>
      <td align="left">&nbsp;<?=L_G_PURCHASEDATE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left"></td>
                <td>
					<input type='text' name='exp_date1' onfocus="this.blur();" value='<?= $_POST['purchasedate']?>'> <a class=mainlink href="javascript:javascript:show_calendar('update.exp_date1');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">[Edit]</a>                          
                </td>
            </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan=2><HR size=1 noshade></td>
    </tr>    
      <tr>
      <td align="left">&nbsp;<?=L_G_EXPENSEDATE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left"></td>
                <td>
					<input type='text' name='exp_date2' onfocus="this.blur();" value='<?= $_POST['expensedate']?>'> <a class=mainlink href="javascript:javascript:show_calendar('update.exp_date2');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">[Edit]</a>                                                         
                </td>
            </tr>
            
        </table>
      </td>
    </tr>
        
    <tr>
      <td align="left">&nbsp;<?=L_G_ENDEXPENSEDATE?>&nbsp;</td>
      <td align="left">
        <table>
            <tr>
                <td align="left"></td>
                <td>
                    <input type='text' name='exp_date3' onfocus="this.blur();" value='<?= $_POST['endexpensedate']?>'> <a class=mainlink href="javascript:javascript:show_calendar('update.exp_date3');" onMouseOver="window.status='Date Picker'; overlib('Click here to choose a date.'); return true;" onMouseOut="window.status=''; nd(); return true;">[Edit]</a>                                                      
                </td>
            </tr>
        </table>
      </td>
    </tr> 
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>   
    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=md value='Affiliate_Merchants_Views_ExpensesErrorsManager'>
      <input type=hidden name=action value='update'>
      <input type=hidden name=postaction value='update'>
      <input type=hidden name=eid value='<?=$_POST['eid']?>'>
      <input class=formbutton type=submit value="<?=L_G_UPDATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
  </table>
  </form>
</center>
