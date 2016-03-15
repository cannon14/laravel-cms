<?php
/**
 *
 * Click Success L.P.
 * Jul 6, 2006
 * 
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_Lib
 */
?>
<?php
class CMS_libs_SortBar {
	
	/**
	 * Constructor -- Create a sortbar based on page information
	 * @author Jason Huie
	 * @version 1.0
	 * @param Page Page
	 * @param String CSS class name
	 * @param String Url to the page
	 * @return String HTML for the sort bar
	 */
    function render($page, $cssClass='', $baseURL){
		$result = "	<ul class=".$cssClass."> 
  						<li class='orphan'>Sort by:</li>
  						<li class='sort'><a href='".$baseURL."?page=".$page."&amp;sort=order'>Popularity</a></li>
						<li class='sort'><a href='".$baseURL."?page=".$page."&amp;sort=title'>Card Name</a></li>
						<li class='sort'><a href='".$baseURL."?page=".$page."&amp;sort=introapr'>Intro APR</a></li>
						<li class='sort'><a href='".$baseURL."?page=".$page."&amp;sort=introaprperiod'>Intro APR Period</a></li>
						<li class='sort'><a href='".$baseURL."?page=".$page."&amp;sort=regularapr'>Regular APR</a></li>
   					</ul>";
		return $result;
    }
}
?>