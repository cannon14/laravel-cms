<?php
/*
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Created on Jan 12, 2006
 *
 */
 
QUnit_Global::includeClass('crm_widgets_widget');
class crm_widgets_cccom_subHeadingWidget extends crm_widgets_widget {
	
	var $heading;
	
	function crm_widgets_cccom_subHeadingWidget(){

	}
	
	function write(){
		
		if($this->heading == null){
			return null;	
		}	

			$cardString = "
<!-- #EndLibraryItem --><br>
      <br>
      <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
        <tr>
          <td rowspan=\"2\" valign=\"top\"><img src=\"/images/".$this->heading['catImage']."\" alt=\"".$this->heading['catImageAltText']."\"  border=\"0\" ></td>
          <td rowspan=\"2\"><img src=\"/images/spacer.gif\" width=\"10\" height=\"10\"></td>
          <td><h1><font color=\"#003399\" face=\"Arial, Helvetica, sans-serif\"><b>Prepaid Debit Cards for Students</b></font></h1></td>
        </tr>
        <tr>
          <td><p>".$this->heading['catDescription']."<br>
            <br>
          </p></td>
        </tr>
      </table><br>				
					";
			return "<!--BEGIN subHeadingWidget !-->" . $cardString . "<!--BEGIN endSubHeadingWidget !-->";	
	}
	
	function setHeading($heading){
		$this->heading = $heading;
	}
	
}
?>