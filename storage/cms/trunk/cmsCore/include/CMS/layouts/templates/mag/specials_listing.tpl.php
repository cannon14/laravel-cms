<?php
/*
 * Created on Jun 30, 2006 
 *
 * Click Success L.P.
 * Author: Jason Huie
 * <jasonh@clicksuccess.com>
 */
?>
<table align="center" border="0" cellpadding="2" cellspacing="0" width="90%">
	<tr> 
    	<td>
    		<table border="0" cellpadding="1" width="100%">
				<tr>
	    			<td><h1><?//I hate this, but here's a nasty hack remove plurality to "credit cards" so English will make sense
	    						echo substr($this->card->get('pageName'), -1)=='s'?substr($this->card->get('pageName'), 0, -1):$this->card->get('pageName')?> Special</h1></td>
				</tr>
			</table>
			<table align="center" border="0" cellpadding="0" width="100%">
	  			<tr>
	    			<td><p><?=$this->card->get('specialsDescription')?></p></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div class="cbr">
<table class="rc" align="center" cellpadding="0" cellspacing="0" style="border-width:3px;border-style:solid;border-color:#cccccc;">
  <tr>
  	<th colspan='2' class='offer-left'> 
    <?=$this->siteProp['individualcards']
    ?"<a href='".$this->siteProp['individualcarddir'].'/'.$this->card->get('cardLink').".".$this->siteProp['pagetype']."'>".$this->card->get('cardTitle')."</a>"
    :$this->card->get('cardTitle')?>
    </th>
  </tr>
  <tr> 
    <td width="15%" class="cc-card-art-align"><?='<? echo "<a href=\'/oc/?'.$this->card->get('cardId').'\' target=\'_blank\'>"; ?>'?>
    <img src="/images/<?=$this->card->get('imagePath')?>" width="95" height="60" border="0" alt="<?=$this->card->get('cardIOAltText')?>"><br>
    <img name="Apply-Now" border="0" src="/images/apply-now.gif" width="95" height="28" alt="<?=$this->card->get('cardButtonAltText')?>"><br>
    <img name="More-Info" border="0" src="/images/more-info-button.gif" alt="More Information - <?=$this->card->get('cardTitle')?>"></a></td>
    <td width="85%" class="details"> 
		<?=$this->card->get('cardDetailText')?>
    </td>
  </tr>
  <tr> 
    <td colspan="2"> 
      <table align="center" class="rate-rc" cellpadding="0" cellspacing="1">
        <tr>
          	<?foreach($this->cardData as $name => $data){
		       		if($data != '')
		       			$cardString .=  "<td class=\"rate-top\">".$name."</td>\n";
		      		 }
		       $cardString .= "</tr><tr>";
		       
		       foreach($this->cardData as $name => $data){
		       		if($data != '')
		       			$cardString .= " <td class=\"rates-bottom\">".$data."</td>\n";
		      		 }
		    ?>
		    <?=$cardString?>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br>
<table align="center" border="0" cellpadding="0" width="90%">
	<tr>
    	<td class="credit-card-regular"><div align="right"><a href="/<?=$this->card->get('pageLink')?>.php"><?=$this->card->get('specialsAdditionalLink')?></a></div></td>
    </tr>
</table></div>