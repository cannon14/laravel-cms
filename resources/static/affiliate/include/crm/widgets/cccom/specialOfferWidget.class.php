<?php

/*
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Created on Jan 12, 2006
 *
 */

 
QUnit_Global::includeClass('crm_widgets_widget');
class crm_widgets_cccom_specialOfferWidget extends crm_widgets_widget {
	
	var $linkPath;
	var $image;
	var $description;

	function crm_widgets_cccom_specialOfferWidget(){

	}
	
	function write(){
		$retString =  "<table width=\"191\" border=\"0\"  cellspacing=\"0\" cellpadding=\"0\">
      <tr> 
    <td class=\"specials\">      <div align=\"center\">".$this->description."<br>
      CREDIT CARD SPECIALS<br>
      FOR
		<script language=\"JavaScript\" type=\"text/javascript\">
<!--
getit1=\"\";
getit2=\"\";
today = new Date();
weekday = today.getDay();
if (weekday == 0) getit1='Sunday';
if (weekday == 1) getit1='Monday';
if (weekday == 2) getit1='Tuesday';
if (weekday == 3) getit1='Wednesday';
if (weekday == 4) getit1='Thursday';
if (weekday == 5) getit1='Friday';
if (weekday == 6) getit1='Saturday';
month = today.getMonth();
if (month == 0) getit2='January';
if (month == 1) getit2='Febuary';
if (month == 2) getit2='March';
if (month == 3) getit2='April';
if (month == 4) getit2='May';
if (month == 5) getit2='June';
if (month == 6) getit2='July';
if (month == 7) getit2='August';
if (month == 8) getit2='September';
if (month == 9) getit2='October';
if (month == 10) getit2='November';
if (month == 11) getit2='December';
date = today.getDate();
year=today.getFullYear();
document.write (\"<font class='specials'>\" + getit2,' ',date,', ',year +\"</font>\");
// -->
</script><br>      
        <br>
        <? echo \"<a href='\".\$GLOBALS['RootPath'].\"".$this->linkPath."' target='_blank'>\"; ?><img src=\"/images/".$this->image."\" border=\"0\" alt=\"Click Here for a ".$this->description." Credit Card Special Offer\"></a></div></td>
  </tr>
  			<tr> 
          <td>

          </td>
        </tr>
</table>";
		return "<!--BEGIN specialOfferWidget !-->" . $retString . "<!--END specialOfferWidget !-->";
	}
}
?>
