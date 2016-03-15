      <div align="center">
        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="headtable">
          <tr>
            <td rowspan="2" valign="top"><img src="/images/<?=$this->merchantService->get('category_image_path')?>" alt="<?=$this->merchantService->get('category_image_alt_text')?>"></td>
            <td rowspan="2"><img src="/images/10-10-spacer.gif" width="10" height="10"></td>
            <td><h1><?=$this->merchantService->get('merchant_service_header_string')?></h1></td>
          </tr>
          <tr>
            <td><p> <?=$this->merchantService->get('merchant_service_intro_detail')?></p></td>
          </tr>
        </table>
      
        <br>
      </div>  
<table class="rc" align="center" cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
  <tr> 
    <th colspan="2" class="offer-left"><?=$this->merchantService->get('merchant_service_name')?>  
  </tr>
  <tr>  
    <td width="15%" class="cc-card-art-align"><a href='<?=$this->merchantService->get('app_link')?>' target='_blank' name='&lid=<?=$this->merchantService->get('merchant_service_link')?>'>
      <img src="/images/<?=$this->merchantService->get('merchant_service_image_path')?>" border="0" alt="<?=$this->merchantService->get('merchant_service_image_alt_text')?>"><br>
      <img style="padding: 5px;" name="More-Info" border="0" src="/images/more-info.gif" width="95" height="28" alt="<?=$this->merchantService->get('apply_button_alt_text')?>"></a></td>
    <td width="85%" class="details"><?=$this->merchantService->get('merchant_service_detail_text')?></td>
  </tr>
  <tr> 
    <td colspan="2">
    	<table width=100%>
    		<tr>
	      		<td class="rate-top">Discount Rate</td>
	      		<td class="rate-top">Transaction Fee</td>
	      		<td class="rate-top">Gateway Fee</td>
	      		<td class="rate-top">Statement Fee</td>
	      		<td class="rate-top">Monthly Minimum</td>
	      		<td class="rate-top">Startup Fee</td>
			 </tr>
			 <tr>
	      		<td class="rates-bottom"><?=$this->merchantServiceData['Discount Rate']?></td>
	      		<td class="rates-bottom"><?=$this->merchantServiceData['Transaction Fee']?></td>
	      		<td class="rates-bottom"><?=$this->merchantServiceData['Gateway Fee']?></td>
	      		<td class="rates-bottom"><?=$this->merchantServiceData['Statement Fee']?></td>
	      		<td class="rates-bottom"><?=$this->merchantServiceData['Monthly Minimum']?></td>
	      		<td class="rates-bottom"><?=$this->merchantServiceData['Setup Fee']?></td>
			 </tr>
		</table>
	  </td>
  </tr>
</table>
<br>
<table width="90%" align="center">
    <tr>
    	<td><?=$this->merchantService->get('merchant_service_more_detail')?></td>
    </tr>
</table>
      <br />
      <br />
      <table border="0" cellspacing="0" cellpadding="0" width="90%" align="center" >
        <tr>
            <td valign="top" class="credit-card-details" width="100%">
                <br><br><?=$this->merchantService->get('disclaimer')?><br><br>
            </td>
        </tr>
      </table>
<img src="/images/1-375-spacer.gif" width="375" height="1">