<?if($this->merchantServiceNumber == 1 && $this->page->get('flagTopPick')){?>
	<table align='center' border='0' cellpadding='0' cellspacing='0' width='90%'>
		<tbody>
			<tr> 
  				<td><img src="/images/best-merchant-accounts-service-provider.gif" alt="Best <?=$this->page->get('pageHeaderString')?>" height="24" width="184"></td>
			</tr>
		</tbody>
	 </table>
<?}else if($this->merchantServiceNumber == 2 && $this->page->get('flagAdditionalOffer')){?>
	<table align='center' border='0' cellpadding='0' cellspacing='0' width='90%'>
		<tbody>
			<tr> 
  				<td><img src="/images/merchant-accounts-offers.gif" alt="Additional Merchant Account Reviews" height="24" width="184"></td>
			</tr>
		</tbody>
	 </table>
<?}?>
<table width="100%" cellpadding="0" cellspacing="0" style="border: 3px solid #ccc;">
  <tr> 
    <th colspan="2" class="offer-left"><a href="<?=$this->siteProp['individualmerchantservicesdir'].'/'.$this->merchantService->get('merchant_service_link').'.'.$this->siteProp['pagetype']?>"><?=$this->merchantService->get('merchant_service_name')?></a>  
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