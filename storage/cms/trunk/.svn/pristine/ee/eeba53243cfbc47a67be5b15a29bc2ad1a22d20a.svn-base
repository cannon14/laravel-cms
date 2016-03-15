<?if($this->merchantServiceNumber == 1 && $this->page->get('flagTopPick')){?>
	<table align='center' border='0' cellpadding='0' cellspacing='0' width='90%' class="tab_table">
		<tbody>
			<tr> 
  				<td><img src="/images/best-merchant-accounts-service-provider.gif" alt="Best <?=$this->page->get('pageHeaderString')?>" height="24" width="184"></td>
			</tr>
		</tbody>
	 </table>
<?}else if($this->merchantServiceNumber == 2 && $this->page->get('flagAdditionalOffer')){?>
	<table align='center' border='0' cellpadding='0' cellspacing='0' width='90%' class="tab_table">
		<tbody>
			<tr> 
  				<td><img src="/images/merchant-accounts-offers.gif" alt="Additional Merchant Account Reviews" height="24" width="184"></td>
			</tr>
		</tbody>
	 </table>
<?}?>
<table class="rc" align="center" cellpadding="0" cellspacing="0" width="90%" style="border-width:3px;border-style:solid;border-color:#cccccc;">
  <tr> 
    <th colspan="2" class="offer-left"><a href="<?=$this->siteProp['individualmerchantservicesdir'].'/'.$this->merchantService->get('merchant_service_link').'.'.$this->siteProp['pagetype']?>"><?=$this->merchantService->get('merchant_service_name')?></a>  
  </tr>
  <tr>  
    <td width="15%" class="cc-card-art-align">
    	<a href='<?=$this->merchantService->get('app_link')?>' target='_blank' name='&lid=<?=$this->merchantService->get('merchant_service_link')?>'>
      		<img src="/images/<?=$this->merchantService->get('merchant_service_image_path')?>" border="0" alt="<?=$this->merchantService->get('merchant_service_image_alt_text')?>"><br>
      		<img style="padding: 5px;" name="More-Info" border="0" src="/images/more-info.gif" width="95" height="28" alt="<?=$this->merchantService->get('apply_button_alt_text')?>">
      	</a>
    </td>
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