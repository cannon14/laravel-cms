<? if($this->a_Auth->isLogged()) { 
	
		$tabs = array( 	array("name"=>"Manager",
							 "url"=>$GLOBALS['RootPath']."/merchants/index.php",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"1"),
						array("name"=>"A/R Uploads",
							 "url"=>$GLOBALS['RootPath']."/merchants/new_acctsreceive/index.php",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"1"),						 
						array("name"=>"Exp Uploads",
							 "url"=>$GLOBALS['RootPath']."/merchants/new_expenseuploads/index.php",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"1"),						
						/**
						array("name"=>"Manager Console",
							 "url"=>$GLOBALS['RootPath']."/merchants/crm/index.php",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"1"),						
						**/
						array("name"=>"Download Protect",
							 "url"=>"",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"0"),
						array("name"=>"Help Support",
							 "url"=>"",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"0"),
						array("name"=>"Newsletter",
							 "url"=>"",
							 "image"=>"",
							 "disabled"=>"1",
							 "active"=>"0"),
						array("name"=>"Reports",
                             "url"=>$GLOBALS['RootPath']."/merchants/introspect/index.php",
                             "image"=>"",
                             "disabled"=>"1",
                             "active"=>"1"),
						array("name"=>"Search",
                             "url"=>$GLOBALS['RootPath']."/merchants/search_admin/index.php",
                             "image"=>"",
                             "disabled"=>"1",
                             "active"=>"1"),
                             );
		if ($_SESSION["TABSELECTED"]){ $tabs[$_SESSION["TABSELECTED"]]["disabled"] = 0;}
		else { $tabs[0]["disabled"] = 0;}	
		?>

<table height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<?
	for($i=0;$i<count($tabs);$i++){
			
		$classSuffix = "";
		$thisTab = $tabs[$i];
		
		if ($thisTab["active"]){
			if ($thisTab["disabled"]){
				$classSuffix = "Disabled";
			}
			if ($thisTab["url"]){
				$tabLabel = "<a href='".$thisTab['url']."'> ".$thisTab['name']."</a>";
			}
			else {
				$tabLabel = $thisTab["name"];
			} 
			
			?>
  	<td class="headerTopMenuSpacer"></td>
  	<td id="tab<? echo $i ;?>left" class="topMenuLeftTab<? echo $classSuffix ; ?>" nowrap="nowrap"></td>
  	<td id="tab<? echo $i ;?>middle" class="topMenuContent<? echo $classSuffix ; ?>" nowrap="nowrap"><? echo $tabLabel ; ?></td>
  	<td id="tab<? echo $i ;?>right" class="topMenuRightTab<? echo $classSuffix ; ?>" nowrap="nowrap"></td>
			<?
		}
	}
?>
  <td class="headerTopMenuSpacer"></td>
</tr>
</table>

<? } ?>
