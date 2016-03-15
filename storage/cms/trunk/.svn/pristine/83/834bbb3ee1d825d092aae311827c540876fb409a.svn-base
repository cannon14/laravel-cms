    <td valign="top">
    
    
    
      <div align="center">
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="headtable">
          <tr>
            <td rowspan="2" valign="top"><img src="/images/<?=$this->merchantService->get('category_image_path')?>" alt="<?=$this->merchantService->get('category_image_alt_text')?>" width="65" height="65"></td>
            <td rowspan="2"><img src="/images/10-10-spacer.gif" width="10" height="10"></td>
            <td><h1><?=$this->merchantService->get('merchant_service_header_string')?></h1></td>
          </tr>
          <tr>
            <td><p> <?=$this->merchantService->get('merchant_service_intro_detail')?></p></td>
          </tr>
        </table>
      
        <br>
      </div>  
<table width="100%" cellpadding="0" cellspacing="0" style="border: 3px solid #ccc;">
  <tr> 
    <th colspan="2" class="offer-left"><?=$this->merchantService->get('merchant_service_name')?>  
  </tr>
  <tr>  
    <td width="15%" class="cc-card-art-align"><a href='/oc/?<?=$this->merchantService->get('merchant_service_id')?>' target='_blank' name='&lid=<?=$this->merchantService->get('merchant_service_link')?>'>
      <img src="/images/<?=$this->merchantService->get('merchant_service_image_path')?>" border="0" alt="<?=$this->merchantService->get('merchant_service_image_alt_text')?>"><br>
      <img name="Apply-Now" border="0" src="/images/apply-now.gif" width="95" height="28" alt="<?=$this->merchantService->get('apply_button_alt_text')?>"></a></td>
    <td width="85%" class="details"><?=$this->merchantService->get('merchant_service_detail_text')?></td>
  </tr>
  <tr> 
    <td colspan="2">
    	<table width=100%>
    	  <tr>
	      		<?foreach($this->merchantServiceData as $name => $data)
			       		if($data != '')
			       			$merchantServiceString .=  "<td class=\"rate-top\">".$name."</td>\n";
			       $merchantServiceString .= "</tr><tr>";
			       foreach($this->merchantServiceData as $name => $data)
			       		if($data != '')
			       			$merchantServiceString .= " <td class=\"rates-bottom\">".$data."</td>\n";
			    ?>
			    <?=$merchantServiceString?></td>
			 </tr>
		</table>
	  </td>
  </tr>
</table>
<br>
<table width="90%" align="center" >
          <tr>
            <td><?=$this->merchantService->get('merchant_service_more_detail')?></td>
          </tr>
      </table>
      <img src="/images/445spacer.gif" width="445" height="1"><br>
      <table border="0" cellspacing="0" cellpadding="0" width="90%" align="center" >
        
        <td valign="top" class="credit-card-details" width="100%"> <br>
          <br>
            See the online <?=$this->merchantService->get('merchant_service_name')?> Merchant Services application for details
            about terms and conditions of offer. Reasonable efforts are made to 
            maintain accurate information. However all credit card information 
            is presented without warranty. When you click on the &quot; Apply Now &quot; button you can review the credit card terms and conditions 
            on the credit card issuer's web site.
            <br>
            <br>
          </td>
        </tr>
      </table>
<img src="/images/1-375-spacer.gif" width="375" height="1"></td>
</tr></table>