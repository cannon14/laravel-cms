<?php
/*
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Created on Jan 12, 2006
 *
 */
 
QUnit_Global::includeClass('crm_widgets_widget');
class crm_widgets_cccom_cardListingWidget extends crm_widgets_widget {
	
	var $currCard;
	var $applyButton;
	var $applyButtonAltText;
	var $imageAltText;
	
	function crm_widgets_cccom_cardListingWidget($pageArray, $category){
		$this->pages = $pageArray;
		$this->category = $category;
	}
	
	function write(){
		
		if($this->currCard == null){
			return null;	
		}	

			$cardDetailListing = $this->_getCardListingAsAssociativearray($this->currCard);
			$cardString = "       			
<table class=\"rc\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-width:3px;border-style:solid;border-color:#cccccc;\">
	<tr> 
    	<th colspan=\"2\" class=\"offer-left\">  
      	<a href=\"/".$this->_urlEncode($this->currCard['cardLink']).".".$this->extension."\">".$this->currCard['cardTitle']."</a>
	</tr>
	<tr> 	      
		<td width=\"15%\" class=\"cc-card-art-align\"><a href=\"/" . $this->currCard['appLink'] . "\" target=\"_blank\">
		      <img src=\"/images/".$this->currCard['imagePath']."\" width=\"95\" height=\"60\" border=\"0\" alt=\"".$this->currCard['cardTitle']."\"><br />
		      <img name=\"/images/Apply-Now\" border=\"0\" src=\"/images/". $this->applyButton ." \" width=\"95\" height=\"28\" alt=\"Apply for an ".$this->currCard['cardTitle']."\"></a></td>
		 <td width=\"85%\" class=\"details\"> " . $this->currCard['cardDetailText'] .  "
		 </td>
		
	</tr>
	<tr> 
		<td colspan=\"2\"> 
		      <table align=\"center\" class=\"rate-rc\" cellpadding=\"0\" cellspacing=\"1\">
		        <tr >";
		        
		        foreach($cardDetailListing as $name => $data){
		        if($data[0] == 1)
		        	$cardString .=  "<td class=\"rate-top\">".$name."</td>\n";
		        }
		        	
		        $cardString .= "</tr><tr>";
		        
		        foreach($cardDetailListing as $name => $data){
		        if($data[0] == 1)
		        	$cardString .= " <td class=\"rates-bottom\">".$data[1]."</td>\n";
		        }
		          	
		     	
		     	$cardString.=	"</tr>
			</table>
		</td>
	</tr>
</table>
		<br />";
		return "<!--BEGIN cardListingWidget !-->" . $cardString . "<!--END cardListingWidget !-->";
	}
	
	function setCurrentCard($currCard){
		$this->currCard = $currCard;
	}
	
	function setApplyButton($applyButton){
		$this->applyButton = $applyButton;
	}
	function setApplyButtonAltText($applyButtonAltText){
		$this->applyButtonAltText = $applyButtonAltText;
	}
	function setImageAltText($imageAltText){
		$this->imageAltText = $imageAltText;
	}
}
?>