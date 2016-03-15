<?
/**
 * 
 * ClickSuccess, L.P.
 * August 7, 2006
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */ 

csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('csCore_UI_filter');
csCore_Import::importClass('csCore_UI_formItem');
csCore_Import::importClass('CMS_libs_Merchants');
csCore_Import::importClass('CMS_libs_Pages');
csCore_Import::importClass('CMS_libs_CardCategories');
csCore_Import::importClass('CMS_libs_Cards');

class CMS_view_merchants extends CMS_pages_cmsList
{
	var $filter;
    function process()
    {
		if(!empty($_REQUEST['action'])){
			switch($_REQUEST['action']){
				case 'deleteMerchant':
                    if($this->processDeleteMerchant())
                        return;
                    break;     
				case 'createMerchant':
                    if($this->drawFormCreateMerchant())
                        return;
                    break;   
				case 'processCreateMerchant':
                    if($this->processCreateMerchant())
                        return;
                    break; 
				case 'updateMerchant':
                    if($this->drawFormUpdateMerchant())
                        return;
                    break;   
				case 'processUpdateMerchant':
                    if($this->processUpdateMerchant())
                        return;
                    break;                                                                 	
			}			
		}
		$this->showData();      
    }
    
    function getRequiredPermissions()
    {
    	return array('CMS_cards');	
    }
	
	function setSql()
    {
    	$columns =  implode(", ", array_keys($this->getColumns()));
    	$this->sql = "SELECT " . $columns ." FROM cs_merchants ";
    	
		$search = $this->filter->getValue('searchMerchant');
   		
   		if($search != ''){
   			$this->where .= ' AND (merchantid=' . _q($search) . ' OR merchantname LIKE ' . _q('%'.$search.'%') .')';
   		}    	
    
    }	
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM cs_merchants';
		
    }
    
    function setFilter()
    {
        $_REQUEST['searchMerchant'] = isset($_REQUEST['searchMerchant']) ? $_REQUEST['searchMerchant'] : ''; 
    	$this->filter->setTitle("Merchant Filter");
    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchMerchant', 
															'value' => $_REQUEST['searchMerchant'],
															'label' => 'Search (by Name or ID): ')));	
    }
    
	function getColumns()
    {
		// db Column name => array(Label, sortable, table, callback function)
		return array(
			"merchantname"		 		=> array("Merchant Name", true),
			"merchantid"				=> array("Merchant ID", true),			
		);    
		
    }
    
    function getKey()
    {
    	return "merchantid";
    }
    
    function setSelectActions()
    {
    	
    	$label 		= "Update Merchant";
    	$action		= "updateMerchant";
    	$vars 		= array("merchantid" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);     	
    	
    	$label 		= "Delete Merchant";
    	$action		= "deleteMerchant";
    	$vars 		= array("merchantid" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);   
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Merchant";
    	$action		= "createMerchant";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }
    
    function processDeleteMerchant()
    {
    	CMS_libs_Merchants::deleteMerchants($_REQUEST['merchantid']);
    }
    
    function drawFormCreateMerchant()
    {
    	$this->assignValue('categories', CMS_libs_CardCategories::getAllCardCategories());
    	$this->assignValue('pages', CMS_libs_Pages::getAllDistinctPages());
    	$this->assignValue('merchants', CMS_libs_Merchants::getAllMerchants());
    	$this->assignValue('ccxmerchants', CMS_libs_Merchants::getAllCcxMerchants());
    	$this->addContent('merchant_create');
    	
    	return true;
    }
    
    function processCreateMerchant()
    {
    	if ($_REQUEST['ccx_issuer_id'] == 0) {
    		echo "ERROR: Unable to create merchant.<br/>";
    		echo "You must select an issuer to import from CCX into CMS. If none are listed you must first create the issuer in CCX.";    		
    	} else {
	    	$data = array(	"merchantname" 	    => $_REQUEST['name'],
	    					"merchantcardpage"	=> $_REQUEST['cardpage'],
	    					"category_id"		=> $_REQUEST['category_id'],
	    	                "logo"              => $_REQUEST['logo'],
	    					"site_code"         => $_REQUEST['site_code'],
	    					"merchantid"		=> $_REQUEST['ccx_issuer_id']
	    	);
	    	CMS_libs_Merchants::addMerchant($data);
    	}
    }
    
    function drawFormUpdateMerchant()
    {
    	$this->assignValue('merchantid', $_REQUEST['merchantid']);
    	$this->assignValue('pages', CMS_libs_Pages::getAllDistinctPages());
    	$this->assignValue('categories', CMS_libs_CardCategories::getAllCardCategories());
    	$this->assignValue('data', CMS_libs_Merchants::getMerchantById($_REQUEST['merchantid']));
    	
    	$this->addContent('merchant_edit');
    	
    	return true;    		
    }
    
    function processUpdateMerchant()
    {
    	$data = array(	"merchantname" 	    => $_REQUEST['name'],
    					"merchantcardpage"	=> $_REQUEST['cardpage'],
    					"category_id"		=> $_REQUEST['category_id'],
    	                "logo"              => $_REQUEST['logo'],
    					"site_code"         => $_REQUEST['site_code']
        );
        
    	CMS_libs_Merchants::updateMerchant($_REQUEST['merchantid'], $data);
    }
}
?>
