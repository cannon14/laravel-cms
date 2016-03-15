<?if($this->cardNumber == 1 && $this->page->get('flagTopPick')){?>
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr> 
    	<td> 
        	<div align="left"><img src="images/Top-Pick.gif" width="182" height="18" alt="Best <?=$this->card->get('primaryNavString')?>"></div>
      	</td>
    </tr>
</table>
<?}?>

<table class="rc" align="center" cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
	<tr> 
		<th colspan="2" class="offer-left"><?=$this->card->get('cardTitle')?></th>
	</tr>
	<tr>      
		<td width="15%" class="cc-card-art-align"><a href="http://www1.credit-card-offer.com/?a_aid=0d981fdb&amp;a_bid=<?=$this->card->get('cardId')?>&amp;a_fid=<?=$this->page->get('cardpageId')?>" target="blank">
			<img src="images/<?=$this->card->get('imagePath')?>" width="95" height="60" border="0" alt="<?=$this->card->get('imageAltText')?>"><br>
			<img name="Apply-Now" border="0" src="images/apply-now.gif" width="95" height="28" alt="<?=$this->card->get('imageAltText')?>"></a></td>
		<td width="85%" class="details"> 
			<?=$this->card->get('cardDetailText')?>
		</td>
	</tr>
	<tr> 
		<td colspan="2"> 
			<table align="center" class="rate-rc" cellpadding="0" cellspacing="1">
				<tr>
					<?
					$output = '';
					foreach($this->cardData as $name => $data)
						if($data != '')
							$output .= '<td class="rate-top">'.$name.'</td>';
					$output .= '</tr><tr>';
					
					foreach($this->cardData as $name => $data)
						if($data != '')
							$output .= '<td class="rates-bottom">'.$data.'</td>';
					echo $output;
					?>
				</tr>
			</table>
		</td>
	</tr>
</table>
<br>