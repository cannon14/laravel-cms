
<center>
  <form action=index_popup.php method=post>
  <table border=0>
  <tr>
  <td align=center>
    <table class=listing border=0 cellspacing=0 cellpadding=1>
    <? QUnit_Templates::printFilter(3, L_G_CREATETRANSACTION); ?>
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_FOR?> <?=L_G_AFFILIATE?></td>
     <td align=left>
        <select name=userid>
<?      while($data=$this->a_list_data2->getNextRecord()) { ?>
          <option value='<?=$data['userid']?>' <?=($_REQUEST['userid'] == $data['userid'] ? 'selected' : '')?>
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
          <option value='<?=$data['campaignid']?>' <?=($_REQUEST['campaignid'] == $data['campaignid'] ? 'selected' : '')?>><?=$data['name']?></option>
<?      } ?>          
      </select>    
     </td>
    </tr>   
<!--    
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_TYPE?></td>
     <td align=left>
        <select name=transtype>
          <option value=<?=TRANSTYPE_SALE?> <? print ($_REQUEST['transtype'] == TRANSTYPE_SALE ? 'selected' : '');?>><?=L_G_TYPESALE?></option>
          <option value=<?=TRANSTYPE_CLICK?> <? print ($_REQUEST['transtype'] == TRANSTYPE_CLICK ? 'selected' : '');?>><?=L_G_TYPECLICK?></option>
        </select>  
     </td>
    </tr>
--!>       
<!--
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_TOTALCOST?></td>
     <td align=left>
        <? if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=totalcost size=6 value='<?=$_POST['totalcost']?>'>
        <? if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
     </td>
    </tr>      
!-->
    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_ORDERID?></td>
     <td align=left>
        <input type=text name=orderid size=30 value='<?=$_POST['orderid']?>'>
     </td>
    </tr>      

    <tr>
     <td align=left nowrap>&nbsp;<?=L_G_PRODUCTID?></td>
     <td align=left>
        <input type=text name=productid size=30 value='<?=$_POST['productid']?>'>
     </td>
    </tr>    
    
     <tr>
     <td align=left nowrap>&nbsp;<?=L_G_QUANTITY?></td>
     <td align=left>
        <input type=text name=quantity size=4 value='1'>
     </td>
    </tr>      
 <!--     
    <tr>
      <td colspan=2>&nbsp;</td>
    </tr>
    <tr>
     <td align=left nowrap colspan=2>
     <table border=0 cellspacing=0 cellpadding=2>
     <tr>
       <td valign=top><input type=radio name=createtype value=manual <?=($_POST['createtype'] == 'manual' ? 'checked' : '')?>></td>
       <td align=left nowrap colspan=2>
        <b><?=L_G_TRANSCREATEMANUALLY?></b>
        <br>
        <?=L_G_HLPCREATETRANSACTION?>
       </td>
     </tr>
  
     <tr>
       <td></td>
       <td align=left nowrap>
        <?=L_G_COMMISSION?>
       </td>
       <td align=left nowrap>
        <? if($this->a_Auth->getSetting('Aff_currency_left_position') == '1')
               print $this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
        <input type=text name=commission size=6 value='<?=$_POST['commission']?>'>
        <? if($this->a_Auth->getSetting('Aff_currency_left_position') != '1')
             print '&nbsp;'.$this->a_Auth->getSetting('Aff_system_currency').'&nbsp;';
        ?>
       </td>
     </tr>
     <tr>
       <td></td>
       <td align=left valign=top nowrap>
        <?=L_G_STATUS?>
       </td>
       <td align=left nowrap>
        <select name=rstatus>
          <option value=<?=AFFSTATUS_NOTAPPROVED?> <? print ($_REQUEST['rstatus'] == AFFSTATUS_NOTAPPROVED ? 'selected' : '');?>><?=L_G_WAITINGAPPROVAL?></option>
          <option value=<?=AFFSTATUS_APPROVED?> <? print ($_REQUEST['rstatus'] == AFFSTATUS_APPROVED ? 'selected' : '');?>><?=L_G_APPROVED?></option>
          <option value=<?=AFFSTATUS_SUPPRESSED?> <? print ($_REQUEST['rstatus'] == AFFSTATUS_SUPPRESSED ? 'selected' : '');?>><?=L_G_SUPPRESSED?></option>
        </select>
        <br><br>
       </td>

     </tr>
     <tr>
       <td valign=top><input type=radio name=createtype value=auto <?=($_POST['createtype'] == 'auto' ? 'checked' : '')?>></td>
       <td align=left nowrap colspan=2>
        <b><?=L_G_TRANSCREATEAUTOMATICALLY?></b>
        <br>
        <?=L_G_HLPTRANSCREATEAUTOMATICALLY?>
       </td>
     </tr>
     
 !-->    
     </table>
     <br><br>
     </td>
    </tr>   

    <tr>
      <td colspan=3 align=center>
      <input type=hidden name=commited value=yes>
      <input type=hidden name=transtype value=1>
      <input type=hidden name=md value='Affiliate_Merchants_Views_TransactionManager'>
      <input type=hidden name=action value='create'>
      <input type=hidden name=postaction value='create'>
      <input class=formbutton type=submit value="<?=L_G_CREATE?>">     
      </td>
    </tr> 
    </table>
  </td>
  </tr>
   
  </table>
  </form>
</center>
