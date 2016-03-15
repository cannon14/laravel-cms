<?
/**
 * 
 * ClickSuccess, L.P.
 * March 29, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */ 
 
csCore_Import::importClass('CsCore_UI_SLLists');
csCore_Import::importClass('CMS_libs_Pages');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');

class CMS_view_merchantServiceToPage extends CMS_pages_cmsRestrictedPage
{
    function process()
    {
		
        if(!empty($_REQUEST['sortableListsSubmitted']))
        {
			$orderArray = CsCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'],'assignedList');
			foreach($orderArray as $item) {
				$s = "INSERT INTO merchant_services_page_map (rank, page_id, merchant_service_id) VALUES (" . _q($item['order']) . ", " . _q($_REQUEST['cardpageId']) . ","  . _q($item['element']) . ")";
				//echo $s ."<br>";
				$sql[] = $s; 
			}
			$this->updateOrder($sql);
		}
		
        if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {  
                case 'addPage':
                    if($this->processAddPage())
                        return;
                    break;            	              
                case 'addCard':
                    if($this->processAddMerchantService())
                        return;
                    break;
                case 'addSubCat':
                	if($this->processAddSubCat())
                		return;
                	break;
                case 'removeSubCat':
                	if($this->processRemoveSubCat())
                		return;
                	break;
                case 'removeMerchantService':
                    if($this->processRemoveMerchantService())
                        return;
                    break;
            }
        }        

		$this->showPage();
    }
    
	function processAddPage(){
		$sql = "SELECT MAX(rank) FROM rt_cardpagemap WHERE cardpageId = " . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$max = $rs->fields['MAX(rank)'];
		if($max == '')
			$max = 0;
		$sql = "DELETE FROM rt_cardpagemap WHERE cardId=" . _q($_REQUEST['cardId']) . " AND cardpageId=" . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId, pageInsert) VALUES (" . _q(($max+1)) . ", " . _q($_REQUEST['cardpageId']) . ","  . _q($_REQUEST['cardId']) . "," . _q(1) .")";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		
	}

	
	function processAddMerchantService(){
		$sql = "SELECT MAX(rank) FROM merchant_services_page_map WHERE page_id = " . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$max = $rs->fields['MAX(rank)'];
		if($max == '')
			$max = 0;
		$sql = "DELETE FROM merchant_services_page_map WHERE merchant_service_id=" . _q($_REQUEST['merchantServiceId']) . " AND page_id=" . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "INSERT INTO merchant_services_page_map (rank, page_id, merchant_service_id) VALUES (" . _q(($max+1)) . ", " . _q($_REQUEST['cardpageId']) . ","  . _q($_REQUEST['merchantServiceId']) . ")";
//		echo $sql ."<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		
	}

	function processRemoveMerchantService(){
		$sql = "SELECT * FROM merchant_services_page_map WHERE page_id=" . _q($_REQUEST['cardpageId']) . " AND merchant_service_id!= " . _q($_REQUEST['merchantServiceId']) . " ORDER BY rank";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "DELETE FROM merchant_services_page_map WHERE page_id=" . _q($_REQUEST['cardpageId']);
		_sqlQuery($sql, __LINE__, __FILE__);
		$count = 1;
		while(!$rs->EOF){
			$sql = "INSERT INTO merchant_services_page_map (rank, page_id, merchant_service_id) VALUES (" . _q($count) . ", " . _q($rs->fields['page_id']) . ","  . _q($rs->fields['merchant_service_id']) . ")";
			_sqlQuery($sql, __LINE__, __FILE__);
			$count ++;
			$rs->MoveNext();
		}
		
	}
	
	function updateOrder($sql){
		$deletesql = "DELETE from merchant_services_page_map where page_id = " . _q($_REQUEST['cardpageId']);
		
		$rs = _sqlQuery($deletesql, __LINE__, __FILE__, DEBUG_MODE);
		if($sql != ''){
			foreach($sql as $currentSql)
				$rs = _sqlQuery($currentSql, __LINE__, __FILE__, DEBUG_MODE);
		}
	}
	

    //--------------------------------------------------------------------------
    
    function showPage()
    {
    	$siteDAO = new CMS_libs_Sites();
    	
        $assigned = $this->getAssignedMerchantServices();
		$unassigned = $this->getUnassignedMerchantServices();
		$allSites = $siteDAO->getAllSites();
		
		$_POST['rs_assignedMerchantServices'] = $assigned;
		$_POST['rs_unassignedMerchantServices'] = $unassigned;

		$_POST['pageInfo'] = $this->getPageInfo($_REQUEST['cardpageId']);
		//echo "Category Name: " . $assigned->fields['categoryName'];
		
		$this->assignValue('sites', $allSites);
		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));
		
		$this->addContent('assign_merchant_services_list');
		
    } 

	function getUnassignedMerchantServices()
    {
        
        //------------------------------------------------
        // get records
        $rs = $this->getAssignedMerchantServices();
        $assigned = array();
		while(!$rs->EOF){
			$assigned[] = $rs->fields['merchant_service_id'];
			$rs->MoveNext();
		}
		if(count($assigned) > 0){
			$sqlIds = "('" . implode("','", $assigned) . "')";
		}else
			$sqlIds = "('')";
		$sql = "select * from merchant_services as ms WHERE ms.merchant_service_id not in " . $sqlIds . " and ms.deleted != 1 ORDER BY ms.merchant_service_name";

		//echo "getUnassignedRecords: ".$sql . "<br><br>";
        $rs = _sqlQuery($sql, __LINE__, __FILE__);
        if (!$rs)
        {
            _setMEssage("QUERY Error", true,__LINE__, __FILE__);
            return;
        }

        return $rs;
    }

	function getAssignedMerchantServices()
    {
        //------------------------------------------------
        // get records
        		$sql = "SELECT * FROM
								rt_cardpages as p,
								merchant_services_page_map as m, 
								merchant_service_details as msd, 
								merchant_services as ms 		
				WHERE (msd.merchant_service_id = ms.merchant_service_id) 		
				AND msd.merchant_service_detail_version = -1 		
				AND m.page_id = " . _q($_REQUEST['cardpageId']) . "		
				AND (p.contentType = 'merchant service' OR p.contentType = 'merchant service application')
				AND (m.page_id=p.cardpageId) 		
				AND (m.merchant_service_id=ms.merchant_service_id) 		
				AND ms.deleted != 1 	
				GROUP BY m.merchant_service_id ORDER BY m.rank";
//		echo "getAssignedRecords: ".$sql ."<br><br>";
        $rs = _sqlQuery($sql, __LINE__, __FILE__);
        if (!$rs)
        {
            _setMEssage("QUERY Error", true,__LINE__, __FILE__);
            return;
        }

        return $rs;
    }
    
    function getPageInfo($id){
    	return CMS_libs_Pages::getPage($id, -1);
    }
  
   
	  
}
?>
