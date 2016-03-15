<?php
/**
 * Patrick J. Mizer (patrick@clicksuccess.com)
 * Click Success, L.P.
 * January 3, 2005
 * 
 * SiteBuild.class.php
 */

QUnit_Global::includeClass('Affiliate_Merchants_Bl_Sites');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Pages');
QUnit_Global::includeClass('Affiliate_Merchants_Bl_Cards');

class Affiliate_Merchants_Bl_SiteBuild {
	
	// This defines the location of your site's source. 
	// This variable can be overridden in the layout file.
	// Treat this as a PROTECTED Var.
	//var $sourceBase = "/home/patrickm/cccom/";
	var $sourceBase = "c:/cardsdev/projects/cccom/";
	
	// This defines where you want your project built.
	// This variable can be overridden in the layout file.
	// Treat this as a PROTECTED Var.
	var $baseBuild = "C:/cardsdev/projects/build/";
	//var $baseBuild = "/usr/local/apache2/htdocs/ccbuild/";
	
	// This defines many pages you want displayed per page.
	// This variable can be overridden in the layout file.
	// Treat this as a PROTECTED Var.
	var $cardsPerPage = 15;
	
	// This defines which categories you want displayed on your page.
	// This variable is meant to be overrode in the layout file.
	// Treat this as a PROTECTED Var.	
	var $categories = array("cccom-left-type", "cccom-left-bank", "cccom-mid-type", "cccom-mid-bank");
	
	// This defines the file extension of the pages to be written i.e., php, html, htm, asp, etc...
	// This variable is meant to be overrode in the layout file.
	// Treat this as a PROTECTED Var.	
	var $extension = "php";
	
	// These variables define some style and image attributes
	// of the Nav Bar.
	// These are meant to be overridden by the layout file.
	// Treat these as PROTECTED Vars.
	// **************************************************
	var $cssSelecedLink = "class='nav-red-bold'";
	var $cssUnSelectedLinkImage = "<img src='/images/bb.gif' width='15' height='8'>";
	var $cssSelectedLinkImage = "<img src='/images/br1.gif' width='15' height='8'>";
	var $cssNavClass = "class='leftnav'";
	// ************************************************** 
	
	// These variables are defined by the class itself... 
	// ... so don't touch.  Treat these as PRIVATE Vars.
	//***************************************************
	var $absolutePublishPath = "";
	var $relativePagePath = "";
	var $staticContent = array();
	var $siteInfo;
	var $pages = array();
	var $cards = array();
	var $distinctCards = array();
	var $fileNameArray = array();
	//****************************************************
	
	//Affiliate_Merchants_Bl_SiteBuild
	// 
	// The SiteBuild constructor should not be overridden, it compiles all of the data associated
	// with the site being built and serilaizes the data into arrays which can be used by this 
	// object's children layout files.
	//
	// ******************************************************************************************
	// @param $id of site to be built. 
	// ******************************************************************************************
	
	function Affiliate_Merchants_Bl_SiteBuild($id) {
		$this->siteInfo = Affiliate_Merchants_Bl_Sites::getSite($id);
		//put this --------------------------v into a setting.
		$this->absolutePublishPath = $this->baseBuild . $this->siteInfo->fields['publishPath'];

		if($this->siteInfo->fields['siteId'] != $id){
			QUnit_Messager::setErrorMessage(L_G_SITEINFONOTFOUND);
		}else{
			$this->_compilePages();
			$this->_compileCards();
			$this->_getDistinctCards();
		}
    }
    
    
	// These functions must be implemented and overridden by the 
	// layout file.  See cclayout.class.php for usage.
	// ************************************************************
		function createPageHeader($currPage = null, $pageNum = null, $category = null){
			return false;	
		}
		function createCardString($cardObject){
			return false;
		}
		function createPagingString(){
			return false;
		}
		function createNavBar($categoryShortName){
			return false;	
		}
		function createPageFooter($currPage){
			return false;	
		}
		function createSplash($pages){
			return false;	
		}
		function createWidgets($pages, $cards){
			return false;	
		}
		function createSiteMap($pages, $cards){
			return false;	
		}		
		
	// ************************************************************
	
	
	// ************************************************************
	// DO NOT OVERRIDE ANY FUNCTIONS BELOW THIS LINE -----0
	//                                                    |
	//                                                    |
	//									                  V
	// ************************************************************
	
	
	function _createSplash(){
			$splashString = $this->createSplash($this->pages);
			if($splashString === false)
				return false;
			$filename = "index.php";
			$pageStr = $this->createPageHeader().$splashString;
			if (!($this->_writeFile($filename, $pageStr))) {
				QUnit_Messager::setErrorMessage("There was an error writing: $filename");
				return false;
				} else {
					//QUnit_Messager::setOkMessage($filename . " was written successfully.");
				}				
			return true;
	}
	
	// createListings DO NOT OVERRIDE
	// 
	// Create listings calls on the layout's member functions above and actually writes the
	// the code to the php files. 
	//
	// ****************************************************************************************** 
	// @return True if build is successful.
	// ******************************************************************************************

	function _createListings(){
		$pagenum = 0;
		foreach ($this->pages as $category => $currPages) {
			foreach($currPages as $currPage){				
				$cardObject = $this->_getCardsByPage($currPage['cardpageId']);
				if($cardObject != null){
					$numCards = $cardObject->NumRows();
					if (($numCards % $this->cardsPerPage) == 0) 
						$numPages = $numCards/$this->cardsPerPage;
					else $numPages = ($numCards/$this->cardsPerPage)+1;
						for ($pageNum=1; $pageNum<=$numPages; $pageNum++) {
							$pageStr = "";
							$pageStr = $this->createTrackingTop($currPage['fid']) . $this->createPageHeader($currPage, $pageNum, $category);
							for ($j=1; ($j<=$this->cardsPerPage) && (!($cardObject->EOF)); $j++) {	
								if($cardObject->fields['subCat'] == 0)
									$pageStr .= $this->createCardString($cardObject->fields);
								else 
									$pageStr .= $this->createSubHeadingString($cardObject->fields);
								$cardObject->MoveNext();
							}
							
							if($numPages >= 2){
								$pageStr .= $this->createPagingString() . $this->_createPaging($currPage, $numPages, $pageNum);
							}
							$pageStr .= $this->createPageFooter($currPage);
							
							
			 				
			 				$pageName = $this->_urlEncode($currPage['pageLink']);
							if($pageNum > 1)
								$filename = $pageName."-page-".$pageNum.".".$this->extension;
							else
								$filename = $pageName.".".$this->extension;
							if(array_search($filename, $this->fileNameArray) === false){
								if (!($this->_writeFile($filename, $pageStr))) {
									QUnit_Messager::setErrorMessage("There was an error writing: $filename");
									return false;
								} else {
									//QUnit_Messager::setOkMessage($filename . " was written successfully.");
								}
							}	
						}
					$this->fileNameArray[] = $filename;
				}
			}
		}
		return true;
	}
	
	function _createDetails(){
		if(!is_array($this->distinctCards)){
			QUnit_Messager::setErrorMessage("Distinct Cards not set!");
			return false;
		}
		foreach($this->distinctCards as $cardId => $currCard){
				$pageStr = $this->createPageHeader() . $this->createDetails($currCard) . $this->createPageFooter();
				
				$pageName = $this->_urlEncode($currCard['cardLink']);
				
				$filename = $pageName.".".$this->extension;
				if (!($this->_writeFile($filename, $pageStr))) {
					QUnit_Messager::setErrorMessage("There was an error writing: $filename");
					return false;
				} else {
					//QUnit_Messager::setOkMessage($filename . " was written successfully.");
				}			
		}
		return true;
	}
	
	function _createSiteMap(){
		$this->_compileCards();
		$siteMapString = $this->createSiteMap($this->pages, $this->cards);
		if ($siteMapString === false)
			return false;
		
		$pageStr = $this->createTrackingTop(1) . $this->createPageHeader() . $siteMapString;
		
		$filename = "site-map.".$this->extension;
		if (!($this->_writeFile($filename, $pageStr))) {
			QUnit_Messager::setErrorMessage("There was an error writing: $filename");
				return false;
		} else {
			//QUnit_Messager::setOkMessage($filename . " was written successfully.");
		}			
	}
	
	// createPaging DO NOT OVERRIDE
	// 
	// This function creates paging links. Placement is handeled by the layout file.  See
	// cclayout.class.php for usage.
	//
	// ******************************************************************************************
	// @param $categoryName category name i.e., "type", "bank", ... etc. 
	// @return string containing html encoded text.
	// ******************************************************************************************
	
	function _createPaging($currPage, $numPages, $pagenum){
		 $pageName = $this->_urlEncode($currPage['pageName']);   		
		  for ($k=1; $k<=$numPages; $k++) {
		  	if($k > 1 && $k <= $numPages)
				$pageStr .= " | ";			
				if ($k == $pagenum) {
					$pageStr .= "Page $k";
		    	} else {
		    		
		    		if($k == 1){
		    			$pageStr .= "<a href=\"".$currPage['pageLink'].".".$this->extension."\">Page $k</a>";	
		    		}else
		    			$pageStr .= "<a href=\"".$currPage['pageLink']."-page-".$k.".".$this->extension."\">Page $k</a>";
		    	}
		   }
		   return $pageStr . "</div></table>";	
	}
	
	// buildSite DO NOT OVERRIDE
	// 
	// This function is called after the constructor and checks to make sure that build is
	// ready and then calls the createAll function which builds the site.
	//
	// ******************************************************************************************
	// @return True if build is successful.
	// ******************************************************************************************
	
	function _buildSite(){
		if(!$this->_prepareBuild()){
			return false;
		}
		
		$this->_createAll();
		return true;
	}
	
	// writeFile DO NOT OVERRIDE
	// 
	// This function takes in a filename and a filestring and writes the filestring to a file
	// whose name is defined by filename.
	//
	// ******************************************************************************************
	// @param $filename name of file to be written
	// @param $filestring content to be written to file.
	// @return True if file is successfully created.
	// ******************************************************************************************
	
	function _writeFile($filename, $filestring) {
		if(!is_dir($this->absolutePublishPath.$this->relativePagePath))
			mkdir($this->absolutePublishPath.$this->relativePagePath);
		$fullname = $this->absolutePublishPath . $this->relativePagePath ."/" . $filename;
			if (!$handle = fopen($fullname, 'w')) {
				QUnit_Messager::setErrorMessage("Cannot open file ($fullname)");
				return false;
			}

			if (fwrite($handle, $filestring) === FALSE) {
       			QUnit_Messager::setErrorMessage("Cannot write to file ($filename)");
       			return false;
   			}
			QUnit_Messager::setOkMessage($filename . " created successfully.");
			fclose($handle);
			return true;
	}	
	
	// createAll DO NOT OVERRIDE
	// 
	// This function calls of the the layout file's member functions in succession.  If these
	// functions do not exist the build is aborted and reverted.
	//
	// ******************************************************************************************
	// @return True if site's layout files are run '.
	// ******************************************************************************************
	
	function _createAll() {
		// now we call all of layout's build functions.
		if ($this->createWidgets($this->pages, $this->cards) === false){
			$this->_revertLastBuild();
			QUnit_Messager::setErrorMessage("Error Creating Widgets.  Build aborted.");
			return false;
		}
		
		if ($this->_createSplash() === false){
			$this->_revertLastBuild();
			QUnit_Messager::setErrorMessage("Error Creating Splash.  Build aborted.");
			return false;
		}
		
		if ($this->_createListings() === false){
			$this->_revertLastBuild();
			QUnit_Messager::setErrorMessage("Error Creating Listings.  Build aborted.");
			return false;
		}
		
		if ($this->_createDetails() === false){
			$this->_revertLastBuild();
			QUnit_Messager::setErrorMessage("Error Creating Card Details.  Build aborted.");
			return false;
		}
		
		if ($this->_createSiteMap() === false){
			$this->_revertLastBuild();
			QUnit_Messager::setErrorMessage("Error Creating Site Map.  Build aborted.");
			return false;
		}
		
		// next we create articles....
		
		// ...then static content.
		
		$this->_timestamp();
		
		QUnit_Messager::setOkMessage($this->siteInfo->fields['siteName']." was created successfully.");
		return true;
	}
	
	// revertLastBuild DO NOT OVERRIDE
	// 
	// This function reverts to last version of build if it exists.
	
	function _revertLastBuild(){
		if(is_dir($this->absolutePublishPath."~")){
			rename($this->absolutePublishPath."~", $this->absolutePublishPath);
		}
	}
	
	// getCardsByPage DO NOT OVERRIDE
	// 
	// This function returns the cards assigned to a particular page by id.
	//
	// ******************************************************************************************
	// @return resultset of cards.
	// ******************************************************************************************
	
	function _getCardsByPage($pageId){
		
		return $this->cards[$pageId];
		
	}
	
	// _prepareBuild() DO NOT OVERRIDE
	function _prepareBuild(){
		// First we make sure that layout file exists.
		if (!file_exists("../../include/crm/layouts/".$this->siteInfo->fields['layout'].".class.php")){
			QUnit_Messager::setErrorMessage(L_G_LAYOUTFILENOTFOUND);
			return false;
		}
		
		// then check that publish path is not null
		if($this->siteInfo->fields['publishPath'] == null){
			QUnit_Messager::setErrorMessage(L_G_PUBLISHPATHINVALID);
			return false;			
		}
		// finally we rename existing dir in build path and create
		// dir structure
		
		
		if(is_dir($this->absolutePublishPath."~")){
			$this->_rmdirr($this->absolutePublishPath."~");
		}
		
		if(is_dir($this->absolutePublishPath)){

			rename($this->absolutePublishPath, $this->absolutePublishPath."~");
		}
		mkdir($this->absolutePublishPath);
		
		$this->_moveAllStaticContent($this->sourceBase, $this->absolutePublishPath);
		
		return true;
		
	}	
	
	// _compilePages() DO NOT OVERRIDE
	// Populates the $this->pages array in the following manner:
	// $this->pages['category_name'] = array('col' => 'data', ..., ..., ...)
	// where the array holds page's attributes.
	function _compilePages(){
		foreach($this->categories as $category){
			$rs = Affiliate_Merchants_Bl_Pages::getPagesByCategory($category, $this->siteInfo->fields['siteId']);
			while(!$rs->EOF){
				$tempArray[] = $rs->fields;
				$rs->MoveNext();
			}
			$this->pages[$category] = $tempArray;
			$tempArray = null;
		}
	}
	
	// _compileCards() DO NOT OVERRIDE
	// Populates the $this->cards array in the following manner:
	// $this->cards['cardpageId'] = array('col' => 'data', ..., ..., ...)
	// where the array holds card's attributes.
	function _compileCards(){
		$i = 1;
		foreach($this->pages as $id=>$data){
			foreach($data as $currPage){
				$this->cards[$currPage['cardpageId']] = Affiliate_Merchants_Bl_Cards::getCardsByPage($currPage['cardpageId'], $this->siteInfo->fields['siteId']);
				++ $i;
			}
		}
	}
	
	
	
	// _getDistinctCards() NOT USED DO NOT OVERRIDE
	function _getDistinctCards(){
		
		foreach($this->cards as $pageId=>$cards){
			while(!$cards->EOF){
				$this->distinctCards[$cards->fields['cardId']] = $cards->fields;
				$cards->MoveNext();
			}
		}
		$this->_compileCards();
		 
		 
	}
	
	// _rmdirr($dir) DO NOT OVERRIDE
	function _rmdirr($dir) {
		if($objs = glob($dir."/*")){
			foreach($objs as $obj) {
				is_dir($obj)? $this->_rmdirr($obj) : unlink($obj);
			}
		}
		rmdir($dir);
	}
	
	// _moveStaticContent() DO NOT OVERRIDE
	function _moveStaticContent(){
		foreach($this->staticContent as $filename => $details){
			copy($details[0] ."/".$filename, $this->absolutePublishPath."/".$details[1]."".$filename);
		}
	}
	
	// _moveAllStaticContent($fromDir,$toDir,$chmod=0777,$verbose=false) DO NOT OVERRIDE
	function _moveAllStaticContent($fromDir,$toDir,$chmod=0777,$verbose=false)
	{
		$errors=array();
		$messages=array();
		if (!is_writable($toDir))
			$errors[]='target '.$toDir.' is not writable';
		if (!is_dir($toDir))
			$errors[]='target '.$toDir.' is not a directory';
		if (!is_dir($fromDir))
			$errors[]='source '.$fromDir.' is not a directory';
		if (!empty($errors))
		{
			if ($verbose)
				foreach($errors as $err)
					QUnit_Messager::setErrorMessage($err);
			return false;
		}
		$exceptions=array('.','..');
		$handle=opendir($fromDir);
		while (false!==($item=readdir($handle)))
		   if (!in_array($item,$exceptions))
		       {
				set_time_limit(45);

		       $from=str_replace('//','/',$fromDir.'/'.$item);
		       $to=str_replace('//','/',$toDir.'/'.$item);
		       //*/
		       if (is_file($from) && !$this->_endsWith($from, ".project"))
		           {
		           if (@copy($from,$to))
		               {
		               chmod($to,$chmod);
		               touch($to,filemtime($from));
		               $messages[]='File copied from '.$from.' to '.$to;
		               }
		           else
		               $errors[]='cannot copy file from '.$from.' to '.$to;
		           }
		       if (is_dir($from) && !$this->_endsWith($from, "CVS"))
		           {
		           if (@mkdir($to))
		               {
		               chmod($to,$chmod);
		               $messages[]='Directory created: '.$to;
		               }
		           else
		               $errors[]='cannot create directory '.$to;
		           $this->_moveAllStaticContent($from,$to,$chmod,$verbose);
		           }
		       }
		closedir($handle);
		if ($verbose)
		   {
		   foreach($errors as $err)
		       QUnit_Messager::setErrorMessage($err);
		   foreach($messages as $msg)
		      QUnit_Messager::setOkMessage($msg);
		   }
		return true;
	}

	// _timestamp() DO NOT OVERRIDE
	function _timestamp(){
		$sql = "UPDATE rt_sites set dateLastBuilt = " . _q(date("Y-m-d H:i:s")) . " WHERE siteId = " . _q($this->siteInfo->fields['siteId']);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
	}
	
	// _endsWith( $str, $sub ) DO NOT OVERRIDE
	function _endsWith( $str, $sub ) {
		return ( substr( $str, strlen( $str ) - strlen( $sub ) ) == $sub );
	}
	
	// __urlEncode($input) DO NOT OVERRIDE
	function _urlEncode($input){
	   $input = trim($input);
	   $output = preg_replace("/\s/e" , "_" , $input);
	   //$output = preg_replace("/\W/e" , "" , $output);
	   $output = str_replace("_", "-", $output);
	   return $output;
	}
	function _getCardListingAsAssociativearray($cardObject){
		$listingArray = array();
		$listingArray['Intro APR'] = array($cardObject['active_introApr'], $cardObject['introApr']);
		$listingArray['Intro APR Period'] = array($cardObject['active_introAprPeriod'], $cardObject['introAprPeriod']);
		$listingArray['Regular APR'] = array($cardObject['active_regularApr'], $cardObject['regularApr']);
		$listingArray['Annual Fee'] = array($cardObject['active_regularApr'], $cardObject['regularApr']);
		$listingArray['Monthly Fee'] = array($cardObject['active_monthlyFee'], $cardObject['monthlyFee']);
		$listingArray['Balance Transfers'] = array($cardObject['active_balanceTransfers'], $cardObject['balanceTransfers']);
		$listingArray['Credit Needed'] = array($cardObject['active_creditNeeded'], $cardObject['creditNeeded']);
		
		return $listingArray;
	}
}
?>
