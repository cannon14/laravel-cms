<table border=0 width="100%" cellspacing=0 cellpadding=3>
<? if(in_array(TRANSTYPE_CPM, $_POST['commtype'])) { ?>
      <tr>
        <td colspan=2 align=left class=commcat>
        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td align=left><b><?=L_G_TYPECPM?></b>
          &nbsp;
          <? if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          &nbsp;<input type=text name=cpmcommission size=5 value='<?=$_POST['cpmcommission']?>'>
          <? if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
               print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          </td>
        </tr>
        </table>
        </td>
      </tr>
      <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
<? } ?>        
   
<? if(in_array(TRANSTYPE_CLICK, $_POST['commtype'])) { ?>
      <tr>
        <td colspan=2 align=left class=commcat>
        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td align=left><b><?=L_G_PERCLICK?></b>
          &nbsp;
          <? if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          <input type=text name=clickcommission size=5 value='<?=$_POST['clickcommission']?>'>
          <? if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
               print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
          ?>
          </td>
        </tr>
<?     if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?> 
        <tr>
          <td colspan=3 align=left>
          &nbsp;<?=L_G_OFFERSECONDTIER?>&nbsp;<? showPopupHelp(G_HLPCOMTYPE); ?>
          <table border=0 width=100%>
<?        for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++) 
          { 
              if(($i-2)%3 == 0) echo "<tr>";
?>
            <td align=right>&nbsp;<?=$i.' - '.L_G_TIER?>&nbsp;
            <? if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
                 print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
            ?>
            <input type=text name=st<?=$i?>clickcommission size=5 value='<?=$_POST['st'.$i.'clickcommission']?>'>
            <? if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
                 print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
            ?>
<?
              if(($i-2)%3 == 0) echo "</tr>";
          } ?>
          </table>
          </td>
        </tr>
<?     } ?>
        </table>
        </td>
      </tr>
      <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
      
<? } ?>        

<? if(in_array(TRANSTYPE_SALE, $_POST['commtype']) || in_array(TRANSTYPE_LEAD, $_POST['commtype'])) { ?>
      <tr>
        <td colspan=2 align=left class=commcat>

        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td align=left><b><?=(in_array(TRANSTYPE_SALE, $_POST['commtype']) ? L_G_PERSALE : L_G_PERLEAD)?></b>&nbsp;&nbsp;
            <select name=salecommtype>
              <option value='$' <? print ($_POST['salecommtype'] == '$' ? 'selected' : ''); ?>><?=$this->a_Auth->getSetting('Aff_system_currency')?></option>
              <option value='%' <? print ($_POST['salecommtype'] == '%' ? 'selected' : ''); ?>>%</option>
            </select>

            &nbsp;<input type=text name=salecommission size=5 value='<?=$_POST['salecommission']?>'>
          </td>
        </tr>

<?     if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?> 
        <tr>
          <td colspan=3 align=left nowrap>
          &nbsp;<?=L_G_OFFERSECONDTIER?>&nbsp;
          <select name=stsalecommtype>
            <option value='$' <? print ($_POST['stsalecommtype'] == '$' ? 'selected' : ''); ?>><?=$this->a_Auth->getSetting('Aff_system_currency')?></option>
            <option value='%' <? print ($_POST['stsalecommtype'] == '%' ? 'selected' : ''); ?>>%</option>
          </select>
          &nbsp;
          <? showPopupHelp(G_HLPCOMTYPE); ?>
          <table border=0 width=100%>
<?        for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++) 
          { 
              if(($i-2)%3 == 0) echo "<tr>";
?>
            <td align=right>&nbsp;<?=$i.' - '.L_G_TIER?>&nbsp;
            <input type=text name=st<?=$i?>salecommission size=5 value='<?=$_POST['st'.$i.'salecommission']?>'>
<?
              if(($i-2)%3 == 0) echo "</tr>";
          } ?>
          </table>
          </td>
        </tr>
<?     } ?>

        </table>
        </td>
      </tr>
      <tr><td class=settingsLine colspan=2><img border=0 src="<?=$_SESSION[SESSION_PREFIX.'templateImages']?>blank.png"></td></tr> 
      

<?  if($this->a_Auth->getSetting('Aff_support_recurring_commissions') == 1) { ?>
      <tr>
        <td colspan=2 align=left class=commcat>

        <table border=0 cellspacing=0 cellpadding=3>
        <tr>
          <td colspan=3 align=left>
          <input type=checkbox name=recurring value='1' <? print ($_POST['recurring'] == '1' ? 'checked' : ''); ?>>&nbsp;
          <b><?=L_G_ENABLERECURRINGCOMMISSIONS?></b>
          &nbsp;
            <select name=recurringcommtype>
              <option value='$' <? print ($_POST['recurringcommtype'] == '$' ? 'selected' : ''); ?>><?=$this->a_Auth->getSetting('Aff_system_currency')?></option>
              <option value='%' <? print ($_POST['recurringcommtype'] == '%' ? 'selected' : ''); ?>>%</option>
            </select>

            &nbsp;<input type=text name=recurringcommission size=5 value='<?=$_POST['recurringcommission']?>'>
            &nbsp;&nbsp;<? showPopupHelp(G_HLPRECURRINGCOMM); ?>          
          </td>
        </tr>

        <tr>
          <td colspan=3 align=left>
          &nbsp;<?=L_G_RECURRINGPERIOD?>&nbsp;
            <select name=recurringdatetype>
              <option value='<?=RECURRINGTYPE_WEEKLY?>' <? print ($_POST['recurringdatetype'] == RECURRINGTYPE_WEEKLY ? 'selected' : ''); ?>><?=L_G_WEEKLY?></option>
              <option value='<?=RECURRINGTYPE_MONTHLY?>' <? print ($_POST['recurringdatetype'] == RECURRINGTYPE_MONTHLY ? 'selected' : ''); ?>><?=L_G_MONTHLY?></option>
              <option value='<?=RECURRINGTYPE_QUARTERLY?>' <? print ($_POST['recurringdatetype'] == RECURRINGTYPE_QUARTERLY ? 'selected' : ''); ?>><?=L_G_QUARTERLY?></option>
              <option value='<?=RECURRINGTYPE_BIANNUALLY?>' <? print ($_POST['recurringdatetype'] == RECURRINGTYPE_BIANNUALLY ? 'selected' : ''); ?>><?=L_G_BIANNUALLY?></option>
              <option value='<?=RECURRINGTYPE_YEARLY?>' <? print ($_POST['recurringdatetype'] == RECURRINGTYPE_YEARLY ? 'selected' : ''); ?>><?=L_G_YEARLY?></option>
            </select>
            &nbsp;&nbsp;<? showPopupHelp(G_HLPRECURRINGCOMMPAYMENT); ?> 
          </td>
        </tr>

<?     if($this->a_Auth->getSetting('Aff_maxcommissionlevels') > 1) { ?> 
        <tr>
          <td colspan=3 align=left>
          &nbsp;<?=L_G_OFFERSECONDTIER?>&nbsp;
          <select name=strecurringcommtype>
            <option value='$' <? print ($_POST['strecurringcommtype'] == '$' ? 'selected' : ''); ?>><?=$this->a_Auth->getSetting('Aff_system_currency')?></option>
            <option value='%' <? print ($_POST['strecurringcommtype'] == '%' ? 'selected' : ''); ?>>%</option>
          </select>
          &nbsp;
          <? showPopupHelp(G_HLPCOMTYPE); ?>
          <table border=0 width=100%>
<?        for($i=2; $i<=$this->a_Auth->getSetting('Aff_maxcommissionlevels'); $i++) 
          { 
              if(($i-2)%3 == 0) echo "<tr>";
?>
            <td align=right>&nbsp;<?=$i.' - '.L_G_TIER?>&nbsp;
            <input type=text name=st<?=$i?>recurringcommission size=5 value='<?=$_POST['st'.$i.'recurringcommission']?>'>
<?
              if(($i-2)%3 == 0) echo "</tr>";
          } ?>
          </table>
          </td>
        </tr>
<?     } ?>

      
<?  } ?>   

        </table>
        </td>
      </tr>        
<? } ?>
</table>

