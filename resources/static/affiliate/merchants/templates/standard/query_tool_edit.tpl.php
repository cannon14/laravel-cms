
    <center>
    <form action=index.php method=post>
    <table class=listing border=0 cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $_POST['header']); ?>
    <tr>
		
	  	<td>Provider Channel: </td><td><input type=text name=providerchannel size=44 value="<?=$_POST['providerchannel']?>"></td>
    </tr>
    <tr>
    	<td>Transaction status: </td><td><select name=rstatus>        <?
          if($_POST['rstatus'] == '') $_POST['rstatus'] = AFFSTATUS_APPROVED;
          echo "<option value=\"".AFFSTATUS_NOTAPPROVED."\" ".($_POST['rstatus'] == AFFSTATUS_NOTAPPROVED ? ' selected' : '').">".L_G_WAITINGAPPROVAL."</option>\n";
          echo "<option value=\"".AFFSTATUS_APPROVED."\" ".($_POST['rstatus'] == AFFSTATUS_APPROVED ? 'selected' : '').">".L_G_APPROVED."</option>\n";
          echo "<option value=\"".AFFSTATUS_SUPPRESSED."\" ".($_POST['rstatus'] == AFFSTATUS_SUPPRESSED ? 'selected' : '').">".L_G_SUPPRESSED."</option>\n";
          echo "<option value='0'".($_POST['rstatus'] == 0 ? 'selected' : '').">Unset</option>\n";	 
        ?>
        </select>*</td>
    </tr>

    <tr>
    	<td>Payout Status: </td><td><select name=payoutstatus>
        <?
          if($_POST['payoutstatus'] == '') $_POST['payoutstatus'] = AFFSTATUS_APPROVED;
          echo "<option value=\"".AFFSTATUS_NOTAPPROVED."\" ".($_POST['payoutstatus'] == AFFSTATUS_NOTAPPROVED ? ' selected' : '').">".L_G_WAITINGAPPROVAL."</option>\n";
          echo "<option value=\"".AFFSTATUS_APPROVED."\" ".($_POST['payoutstatus'] == AFFSTATUS_APPROVED ? ' selected' : '').">".L_G_APPROVED."</option>\n";
          echo "<option value=\"".AFFSTATUS_SUPPRESSED."\" ".($_POST['payoutstatus'] == AFFSTATUS_SUPPRESSED ? ' selected' : '').">".L_G_SUPPRESSED."</option>\n";
          echo "<option value='0'".($_POST['payoutstatus'] == 0 ? 'selected' : '').">Unset</option>\n";	 
        ?>
        </select>*&nbsp;</td>
   	</tr>
   	<tr>
     
      	<td>Referer URL: </td><td><input type=text name=refererurl size=44 value="<?=$_POST['refererurl']?>"></td>
	</tr>
	<tr>
      	<td>Afilliate: </td><td><select name=affiliate>
        <?
            while($data=$this->a_list_data->getNextRecord()) {
              echo '<option value="'.$data['userid'].'" '.($_POST['affiliate'] == $data['userid'] ? ' selected' : '').'>'.$data['name'].' '.$data['surname'].'</option>';
            }
        ?>
        </select>*&nbsp;</td>
    </tr>
    <tr>
      	<td>Parent Trans: </td><td><input type=text name=parenttrans size=6 value="<?=$_POST['parenttrans']?>"></td>
	</tr>
	<tr>
      	<td>IP: </td><td><input type=text name=ip size=15 value="<?=$_POST['ip']?>"></td>
	</tr>
	<tr>
	  <td>Product ID: </td><td><input type=text name=productid size=44 value="<?=$_POST['productid']?>"></td>
	</tr>
	<tr> 
      <td>Order ID: </td><td><input type=text name=orderid size=44 value="<?=$_POST['orderid']?>"> </td>
	</tr>
	<tr>
 	  <td>Channel: </td><td><input type=text name=channel size=44 value="<?=$_POST['channel']?>"> </td>
	</tr>
	<tr>
 	  <td>Episode: </td><td><input type=text name=episode size=44 value="<?=$_POST['episode']?>"> </td>
	</tr>
	<tr>
      <td>Timeslot: </td><td><input type=text name=timeslot size=44 value="<?=$_POST['timeslot']?>"> </td>      
	</tr>
	<tr>
	  <td>Provider Action Name: </td><td><input type=text name=provideractionname size=44 value="<?=$_POST['provideractionname']?>"> </td>
	</tr>
	<tr>
      <td>Provider Order ID: </td><td><input type=text name=providerorderid size=44 value="<?=$_POST['providerorderid']?>"> </td>
	</tr>
	<tr>
      <td>Provider Type: </td><td><input type=text name=providertype size=44 value="<?=$_POST['providertype']?>"> </td>
	</tr>
	<tr>
      <td>Merchant Name: </td><td><input type=text name=merchantname size=44 value="<?=$_POST['merchantname']?>"> </td>
	</tr>
	<tr>
      <td>Merchant ID: </td><td><input type=text name=merchantid size=44 value="<?=$_POST['merchantid']?>"> </td>
	</tr>
	<tr>
      <td>Merchant Sales: </td><td><input type=text name=merchantsales size=44 value="<?=$_POST['merchantsales']?>"> </td>
	</tr>
	<tr>
      <td>Quantity: </td><td><input type=text name=quantity size=44 value="<?=$_POST['quantity']?>"> </td>
	</tr>
	<tr>
      <td>Provider Status: </td><td><input type=text name=providerstatu size=44 value="<?=$_POST['providerstatus']?>"> </td>
	</tr>
	<tr>
      <td>Provider Corrected: </td><td><input type=text name=providercorrected size=44 value="<?=$_POST['providercorrected']?>"> </td>
	</tr>
	<tr>
      <td>Provider Website ID: </td><td><input type=text name=providerwebsiteid size=44 value="<?=$_POST['providerwebsiteid']?>"> </td>
	</tr>
	<tr>
      <td>Provider Website Name: </td><td><input type=text name=providerwebsitename size=44 value="<?=$_POST['providerwebsitename']?>"> </td>
	</tr>
	<tr>
      <td>Provider Action ID: </td><td><input type=text name=provideractionid size=44 value="<?=$_POST['provideractionid']?>"></td>
	</tr>
	<tr>
		<td>&nbsp;</td><td>&nbsp;</td>
	</tr>
	<tr>
		<td class=dir_form colspan=2 align=center>
      		<input type=hidden name=commited value=yes>
      		<input type=hidden name=md value='Affiliate_Merchants_Views_QueryTool'>
      		<input type=hidden name=action value=<?=$_POST['action']?>>
      		<input type=hidden name=postaction value=<?=$_POST['postaction']?>>
      		<input type=hidden name=tid value=<?=$_POST['tid']?>>
      		<input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      	</td>
    </tr>
    </table>
    </form>
    </center>

