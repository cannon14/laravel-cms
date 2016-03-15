    <center>
    <form action=index_popup.php method=post>
    <table border=0 class=listing cellspacing=0 cellpadding=2>
    <? QUnit_Templates::printFilter(2, $this->header); ?>
    <tr>
      <td class=dir_form>&nbsp;<b>Short Name:</b>&nbsp;</td>
      <td><input type=text name=shortName size=44 value="<?=$this->shortName?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Long Name:</b>&nbsp;</td>
      <td><input type=text name=longName size=44 value="<?=$this->longName?>">*&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Bank Rule:</b>&nbsp;</td>
      <td><SELECT name=bankRule>
      <?foreach($this->bankRules as $id=>$label){ ?>
      		<option value=<?=$id?> <?=($id == $this->bankRule ? 'SELECTED' : '')?> ><?=$label?></option>
      	<? } ?>
      </SELECT>
      *&nbsp;</td>
    </tr>      
    <tr>
      <td class=dir_form valign=top>&nbsp;<b>Description:</b>&nbsp;</td>
      <td><TEXTAREA COLS=40 ROWS=7><?=$this->description?></TEXTAREA></td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Address 1:</b>&nbsp;</td>
      <td><input type=text name=addressLine1 size=44 value="<?=$this->addressLine1?>">&nbsp;</td>
    </tr>    
    <tr>
      <td class=dir_form>&nbsp;<b>Address 2:</b>&nbsp;</td>
      <td><input type=text name=addressLine2 size=44 value="<?=$this->addressLine2?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>City:</b>&nbsp;</td>
      <td><input type=text name=city size=44 value="<?=$this->addressLine2?>">&nbsp;</td>
    </tr> 
    <tr>
      <td class=dir_form>&nbsp;<b>Province:</b>&nbsp;</td>
      <td><input type=text name=state size=44 value="<?=$this->state?>">&nbsp;</td>
    </tr>     
    <tr>
      <td class=dir_form>&nbsp;<b>Zip:</b>&nbsp;</td>
      <td><input type=text name=zipCode size=44 value="<?=$this->zipCode?>">&nbsp;</td>
    </tr>
    <tr>
      <td class=dir_form>&nbsp;<b>Phone:</b>&nbsp;</td>
      <td><input type=text name=phone size=44 value="<?=$this->phone?>">&nbsp;</td>
    </tr> 
    <tr>
      <td class=dir_form>&nbsp;<b>Contact:</b>&nbsp;</td>
      <td><input type=text name=contact size=44 value="<?=$this->contact?>">&nbsp;</td>
    </tr>                
        
    
    <tr>
    </tr>    
    <tr>
      <td class=dir_form colspan=2 align='center'>
      <input type=hidden name=commited value='yes'>
      <input type=hidden name=md value='<?=$_REQUEST['md']?>'>
      <input type=hidden name=action value='<?=$this->action?>'>
      <input type=hidden name=merchantId value='<?=$this->merchantId?>'>
      <input type=hidden name=postaction value='<?=$this->postAction?>'>
      <input type=submit class=formbutton value='<?=L_G_SUBMIT; ?>'>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    </table>
    </form>
    </center>
