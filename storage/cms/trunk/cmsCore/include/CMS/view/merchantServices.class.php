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
csCore_Import::importClass('CMS_libs_MerchantServices');
csCore_Import::importClass('FCKeditor_FCKeditor');
csCore_Import::importClass('CMS_libs_MerchantServiceMergeFilter');

class CMS_view_merchantServices extends CMS_pages_cmsList
{
	var $filter;
    function process()
    {
    	if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {

               case 'update':
                    $this->processUpdateMerchantService();
                    break;
					
               case 'updateVersion':
                    $this->processUpdateVersion();
                    break;
										
               case 'createVersion':
                    $this->processCreateVersion();
                    break;	
                    	
				case 'create':
                    $this->processCreateMerchantService();
                    break;				
            }
        }
            
		if(!empty($_REQUEST['action'])){
			switch($_REQUEST['action']){
				case 'deleteMerchantService':
                    if($this->processDeleteMerchantService())
                        return;
                    break;     
				case 'createMerchantService':
                    if($this->drawFormCreateMerchantService())
                        return;
                    break;   
				case 'editMerchantService':
					$this->loadServiceInfo();
	                if($this->drawFormEditMerchantService())
	                	return;
                    break;   
				case 'processEditMerchantService':
                    if($this->processUpdateMerchantService())
                        return;
                    break;
                case 'createVersion':
                	if($this->drawFormCreateVersion())
                		return;
                	break;
                case 'editVersion':
			   		$this->loadVersionInfo();
                    if($this->drawFormEditVersion())
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
    	$this->sql = "SELECT " . $columns ." FROM merchant_services ";
    	
		$search = $this->filter->getValue('searchMerchant');
   		
   		if($search != ''){
   			$this->where .= ' AND (merchant_service_id=' . _q($search) . ' OR merchant_service_name LIKE ' . _q('%'.$search.'%') .')';
   		}    	
    
    }	
    
    function setPaging()
    {
    	$this->paging = 'select count(*) as count FROM merchant_services';
		
    }
    
    function setFilter()
    {
    	$this->filter->setTitle("Merchant Services Filter");
    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchMerchantServices', 
															'value' => $_REQUEST['searchMerchantServices'],
															'label' => 'Search (by Name or ID): ')));	
    }
    
	function getColumns()
    {
		// db Column name => array(Label, sortable, table, callback function)
		return array(
			"merchant_service_name"		 		=> array("Merchant Service Name", true),
			"merchant_service_id"				=> array("Merchant Service ID", true),
			"url"						=> array("URL", true),
			"date_created"				=> array("Date Created", true),		
		);    
		
    }
    
    function getKey()
    {
    	return "merchant_service_id";
    }
    
    function setSelectActions()
    {
    	
    	$label 		= "Edit Merchant Service";
    	$action		= "editMerchantService";
    	$vars 		= array("merchant_service_id" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);     	
    	
    	$label 		= "Delete Merchant Service";
    	$action		= "deleteMerchantService";
    	$vars 		= array("merchant_service_id" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);   
    }
    
    function setTextActions()
    {
    	$label 		= "Create New Merchant Service";
    	$action		= "createMerchantService";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }
    
    function processDeleteMerchant()
    {
    	CMS_libs_Merchants::deleteMerchants($_REQUEST['merchant_service_id']);
    }
    
    function drawFormCreateMerchantService()
    {
    	$sBasePath = '../cmsCore/include/FCKeditor/';

		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceDetailText');
		$oFCKeditor->Value = $_POST['merchantServiceDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceIntroDetail');
		$oFCKeditor->Value = $_POST['merchantServiceIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceMoreDetail');
		$oFCKeditor->Value = $_POST['merchantServiceMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;	
    	$this->addContent('merchant_service_create');
    	
    	return true;
    }
    
    function processCreateMerchantService()
    {
		
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$params = array(
			'merchant_service_id'		=> $_REQUEST['merchantServiceId'],
            'merchant_service_name'		=>	$_REQUEST['merchantServiceName'],
            'url'						=>	$_REQUEST['url'],
            'active'					=> $_REQUEST['active'],
            'setup_fee'					=>	$_REQUEST['setupFee'],
			'active_setup_fee'			=>	$_REQUEST['activeSetupFee'],
			'monthly_minimum'			=>	$_REQUEST['monthlyMinimum'],
			'active_monthly_minimum'	=>	$_REQUEST['activeMonthlyMinimum'],	
			'discount_rate'				=>	$_REQUEST['discountRate'],
			'active_discount_rate'		=>	$_REQUEST['activeDiscountRate'],
			'gateway_fee'				=>	$_REQUEST['gatewayFee'],		
			'active_gateway_fee'		=>	$_REQUEST['activeGatewayFee'],
			'statement_fee'				=>	$_REQUEST['statementFee'],
			'active_statement_fee'		=>	$_REQUEST['activeStatementFee'],
			'transaction_fee'			=>	$_REQUEST['transactionFee'],
			'active_transaction_fee'	=>	$_REQUEST['activeTransactionFee'],
			'tech_support_fee'			=>	$_REQUEST['techSupportFee'],
			'active_tech_support_fee'	=>	$_REQUEST['activeTechSupportFee'],
			'internet_discount_rate'	=>	$_REQUEST['internetDiscountRate'],
    		'active_internet_discount_rate'	=>	$_REQUEST['activeInternetDiscountRate'],
    		'internet_transaction_fee'	=>	$_REQUEST['internetTransactionFee'],
    		'active_internet_transaction_fee'	=>	$_REQUEST['activeInternetTransactionFee'],
    		'address_verification_fee'	=>	$_REQUEST['addressVerificationFee'],
    		'active_address_verification_fee'	=>	$_REQUEST['activeAddressVerificationFee'],
    		'application_fee'			=>	$_REQUEST['applicationFee'],
    		'active_application_fee'	=>	$_REQUEST['activeApplicationFee'],
    		'reserve'					=>	$_REQUEST['reserve'],
    		'active_reserve'			=>	$_REQUEST['activeReserve'],
    		'chargeback_fee'			=>	$_REQUEST['chargebackFee'],
    		'active_chargeback_fee'		=>	$_REQUEST['activeChargebackFee']	
		);
		
        // save changes to db
        CMS_libs_MerchantServices::addMerchantService($params);
        
        //correct link (i.e. "merchantX" instead of "merchantX.php")
        $temp = explode(".", $_REQUEST['merchantServiceLink']);
		if(is_array($temp)){
			$_REQUEST['merchantServiceLink'] = $temp[0];	
		}
		
		$params = array(
		    'merchant_service_image_path'		=>	$_REQUEST['merchantServiceImagePath'],
			'merchant_service_link'				=>	$_REQUEST['merchantServiceLink'],
			'app_link'					        =>	$_REQUEST['appLink'],
			'merchant_service_header_string'	=>	$_REQUEST['merchantServiceHeaderString'],
			'fid'						        =>	$_REQUEST['fid'],
			'apply_button_alt_text'		        =>	$_REQUEST['applyButtonAltText'],
			'merchant_service_image_alt_text'	=>	$_REQUEST['merchantServiceImageAltText'],
			'merchant_service_detail_text'		=>	$_REQUEST['merchantServiceDetailText'],
			'merchant_service_intro_detail'		=>	$_REQUEST['merchantServiceIntroDetail'],
			'merchant_service_more_detail'		=>	$_REQUEST['merchantServiceMoreDetail']	
		);
		
		//add the version as default
		CMS_libs_MerchantServices::addDefaultVersion($_REQUEST['merchantServiceId'], $params);
       	
       	
	    $params = array(
	    				'setup_fee'					=>	$_REQUEST['d_setupFee'],						
						'monthly_minimum'			=>	$_REQUEST['d_monthlyMinimum'],						
						'discount_rate'				=>	$_REQUEST['d_discountRate'],						
						'gateway_fee'				=>	$_REQUEST['d_gatewayFee'],					
						'statement_fee'				=>	$_REQUEST['d_statementFee'],					
						'transaction_fee'			=>	$_REQUEST['d_transactionFee'],					
						'tech_support_fee'			=>	$_REQUEST['d_techSupportFee'],
	    				'internet_discount_rate'	=>	$_REQUEST['d_internetDiscountRate'],						
						'internet_transaction_fee'	=>	$_REQUEST['d_internetTransactionFee'],						
						'address_verification_fee'	=>	$_REQUEST['d_addressVerificationFee'],						
						'application_fee'			=>	$_REQUEST['d_applicationFee'],					
						'reserve'					=>	$_REQUEST['d_reserve'],					
						'chargeback_fee'			=>	$_REQUEST['d_chargebackFee']);
		
        CMS_libs_MerchantServices::updateMerchantData($_REQUEST['merchantServiceId'], $params);
        _setSuccess("Merchant Service Successfully Created");   
        
        return false;
    }
    
    function drawFormEditMerchantService()
    {
    	$id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);
		
		$_POST['defaultVersion'] = CMS_libs_MerchantServices::getDefaultVersion($id);
		$_POST['versions'] = CMS_libs_MerchantServices::getVersions($id);
		
		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));
		$this->addContent('merchant_service_edit');
		return true;
    }
    
    function processUpdateMerchantService()
    {   

        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$params = array(
			'merchant_service_id'		=> $_REQUEST['merchantServiceId'],
            'merchant_service_name'		=>	$_REQUEST['merchantServiceName'],
            'url'						=>	$_REQUEST['url'],
            'active'					=> $_REQUEST['active'],
            'setup_fee'					=>	$_REQUEST['setupFee'],
			'active_setup_fee'			=>	isset( $_REQUEST['activeSetupFee'] ) ? '1' : '0',
			'monthly_minimum'			=>	$_REQUEST['monthlyMinimum'],
			'active_monthly_minimum'	=>	isset($_REQUEST['activeMonthlyMinimum'] ) ? '1' : '0',	
			'discount_rate'				=>	$_REQUEST['discountRate'],
			'active_discount_rate'		=>	isset($_REQUEST['activeDiscountRate'] ) ? '1' : '0',
			'gateway_fee'				=>	$_REQUEST['gatewayFee'],		
			'active_gateway_fee'		=>	isset($_REQUEST['activeGatewayFee'] ) ? '1' : '0',
			'statement_fee'				=>	$_REQUEST['statementFee'],
			'active_statement_fee'		=>	isset($_REQUEST['activeStatementFee'] ) ? '1' : '0',
			'transaction_fee'			=>	$_REQUEST['transactionFee'],
			'active_transaction_fee'	=>	isset($_REQUEST['activeTransactionFee'] ) ? '1' : '0',
			'tech_support_fee'			=>	$_REQUEST['techSupportFee'],
			'active_tech_support_fee'	=>	isset($_REQUEST['activeTechSupportFee'] ) ? '1' : '0',
			'internet_discount_rate'	=>	$_REQUEST['internetDiscountRate'],
    		'active_internet_discount_rate'	=>	isset($_REQUEST['activeInternetDiscountRate'] ) ? '1' : '0',
    		'internet_transaction_fee'	=>	$_REQUEST['internetTransactionFee'],
    		'active_internet_transaction_fee'	=>	isset($_REQUEST['activeInternetTransactionFee'] ) ? '1' : '0',
    		'address_verification_fee'	=>	$_REQUEST['addressVerificationFee'],
    		'active_address_verification_fee'	=>	isset($_REQUEST['activeAddressVerificationFee'] ) ? '1' : '0',
    		'application_fee'			=>	$_REQUEST['applicationFee'],
    		'active_application_fee'	=>	isset($_REQUEST['activeApplicationFee'] ) ? '1' : '0',
    		'reserve'					=>	$_REQUEST['reserve'],
    		'active_reserve'			=>	isset($_REQUEST['activeReserve'] ) ? '1' : '0',
    		'chargeback_fee'			=>	$_REQUEST['chargebackFee'],
    		'active_chargeback_fee'		=>	isset($_REQUEST['activeChargebackFee'] ) ? '1' : '0'			
		);		
		
        // save changes of user to db
        CMS_libs_MerchantServices::updateMerchantService($_REQUEST['merchantServiceId'], $params);
        
        $temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];	
		}
        
        
	    $params = array(
	    				'setup_fee'		=>	$_REQUEST['d_setupFee'],						
						'monthly_minimum'	=>	$_REQUEST['d_monthlyMinimum'],						
						'discount_rate'	=>	$_REQUEST['d_discountRate'],						
						'gateway_fee'		=>	$_REQUEST['d_gatewayFee'],					
						'statement_fee'	=>	$_REQUEST['d_statementFee'],					
						'transaction_fee'	=>	$_REQUEST['d_transactionFee'],					
						'tech_support_fee'=>	$_REQUEST['d_techSupportFee'],
	    				'internet_discount_rate'	=>	$_REQUEST['d_internet_discount_rate'],						
						'internet_transaction_fee'	=>	$_REQUEST['d_internet_transaction_fee'],						
						'address_verification_fee'	=>	$_REQUEST['d_address_verification_fee'],						
						'application_fee'			=>	$_REQUEST['d_application_fee'],					
						'reserve'					=>	$_REQUEST['d_reserve'],					
						'chargeback_fee'			=>	$_REQUEST['d_chargeback_fee']);
		
        CMS_libs_MerchantServices::updateMerchantData($_REQUEST['merchantServiceId'], $params);

        _setSuccess("Merchant Service Successfully Created");   
        
        return false;
    }
    
    function processDeleteMerchantService()
    {
		CMS_libs_MerchantServices::deleteMerchantService($_REQUEST['merchant_service_id']);
        return false;
    }
    
    function drawFormCreateVersion(){
		$_POST['action'] = "createVersion";
		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceDetailText');
		$oFCKeditor->Value = $_POST['merchantServiceDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceIntroDetail');
		$oFCKeditor->Value = $_POST['merchantServiceIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceMoreDetail');
		$oFCKeditor->Value = $_POST['merchantServiceMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;
		
		$_POST['rs_sites'] = CMS_libs_MerchantServices::getUnusedVersions($_REQUEST['merchantServiceId']);
		$_POST['merchantServiceId'] = $_REQUEST['merchantServiceId'];

		$this->addContent('merchant_service_createVersion');
		return true;
	}
	
	function processCreateVersion()
    {   
        
		if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
        
        $temp = explode(".", $_REQUEST['merchantServiceLink']);
		if(is_array($temp)){
			$_REQUEST['merchantServiceLink'] = $temp[0];	
		}
		
		$params = array(
			'merchant_service_id'				=>	$_REQUEST['merchantServiceId'],
			'merchant_service_detail_version'	=>	$_REQUEST['merchantServiceDetailVersion'],
		    'merchant_service_image_path'		=>	$_REQUEST['merchantServiceImagePath'],
			'merchant_service_link'				=>	$_REQUEST['merchantServiceLink'],
			'app_link'							=>	$_REQUEST['appLink'],
			'merchant_service_header_string'	=>	$_REQUEST['merchantServiceHeaderString'],
			'fid'								=>	$_REQUEST['fid'],
			'apply_button_alt_text'				=>	$_REQUEST['applyButtonAltText'],
			'merchant_service_image_alt_text'	=>	$_REQUEST['merchantServiceImageAltText'],
			'merchant_service_detail_text'		=>	$_REQUEST['merchantServiceDetailText'],
			'merchant_service_intro_detail'		=>	$_REQUEST['merchantServiceIntroDetail'],
			'merchant_service_more_detail'		=>	$_REQUEST['merchantServiceMoreDetail']	
		);
		
		
        // save changes of user to db
        CMS_libs_MerchantServices::addVersion($params);
              
        return true;
    }
    
    function drawFormEditVersion(){
		$_POST['action'] = "updateVersion";
		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceDetailText');
		$oFCKeditor->Value = $_POST['merchantServiceDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceIntroDetail');
		$oFCKeditor->Value = $_POST['merchantServiceIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;
		
		$oFCKeditor = new FCKeditor_FCKeditor('merchantServiceMoreDetail');
		$oFCKeditor->Value = $_POST['merchantServiceMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;
		
		$_POST['rs_sites'] = CMS_libs_MerchantServices::getUnusedVersions($_REQUEST['merchantServiceId']);
		$_POST['merchantServiceId'] = $_REQUEST['merchantServiceId'];
		
		$_POST['edit'] = true;
		
		$this->addContent('merchant_service_createVersion');
		
		return true;
	}
	
	function processUpdateVersion(){
        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
        
        $temp = explode(".", $_REQUEST['merchantServiceLink']);
		if(is_array($temp)){
			$_REQUEST['merchantServiceLink'] = $temp[0];	
		}
		
		$params = array(
			'merchant_service_id'				=>	$_REQUEST['merchantServiceId'],
			'merchant_service_detail_version'	=>	$_REQUEST['merchantServiceDetailVersion'],
		    'merchant_service_image_path'		=>	$_REQUEST['merchantServiceImagePath'],
			'merchant_service_link'				=>	$_REQUEST['merchantServiceLink'],
			'app_link'							=>	$_REQUEST['appLink'],
			'merchant_service_header_string'	=>	$_REQUEST['merchantServiceHeaderString'],
			'fid'								=>	$_REQUEST['fid'],
			'apply_button_alt_text'				=>	$_REQUEST['applyButtonAltText'],
			'merchant_service_image_alt_text'	=>	$_REQUEST['merchantServiceImageAltText'],
			'merchant_service_detail_text'		=>	$_REQUEST['merchantServiceDetailText'],
			'page_meta'		                    =>	$_REQUEST['pageMeta'],
			'disclaimer'		                =>	$_REQUEST['disclaimer'],
			'merchant_service_intro_detail'		=>	$_REQUEST['merchantServiceIntroDetail'],
			'merchant_service_more_detail'		=>	$_REQUEST['merchantServiceMoreDetail'],
			'category_image_path'				=>	$_REQUEST['categoryImagePath'],
			'category_image_alt_text'			=>	$_REQUEST['categoryImageAltText']	
		);

        // save changes of user to db
        CMS_libs_MerchantServices::updateVersion($_REQUEST['versionId'], $params); 
        return true;		
		
	}
    
    function loadServiceInfo()
    {
        $id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);
		
		$rs = CMS_libs_MerchantServices::getMerchantServiceById($id);

        if (!$rs || $rs->EOF) {
          _setMessage("Query Error", true, __LINE__, __FILE__);
          return false;
        }
			$_POST['merchantServiceId'] =  $id;
            $_POST['merchantServiceName'] = $rs->fields['merchant_service_name'];
            $_POST['url'] = $rs->fields['url'];
            $_POST['description'] = $rs->fields['description'];
            $_POST['setupFee'] = $rs->fields['setup_fee'];
            $_POST['activeSetupFee'] = $rs->fields['active_setup_fee'];
			$_POST['monthlyMinimum'] = $rs->fields['monthly_minimum'];
			$_POST['activeMonthlyMinimum'] = $rs->fields['active_monthly_minimum'];
            $_POST['gatewayFee'] = $rs->fields['gateway_fee'];
            $_POST['activeGatewayFee'] = $rs->fields['active_gateway_fee'];
            $_POST['statementFee'] = $rs->fields['statement_fee'];
            $_POST['activeStatementFee'] = $rs->fields['active_statement_fee'];
            $_POST['discountRate'] = $rs->fields['discount_rate'];
            $_POST['activeDiscountRate'] = $rs->fields['active_discount_rate'];
            $_POST['transactionFee'] =$rs->fields['transaction_fee'];
            $_POST['activeTransactionFee'] =$rs->fields['active_transaction_fee'];
            $_POST['techSupportFee'] = $rs->fields['tech_support_fee'];
            $_POST['activeTechSupportFee'] = $rs->fields['active_tech_support_fee'];
            
            $_POST['internetDiscountRate'] = $rs->fields['internet_discount_rate'];
            $_POST['activeInternetDiscountRate'] = $rs->fields['active_internet_discount_rate'];
            $_POST['internetTransactionFee'] = $rs->fields['internet_transaction_fee'];
            $_POST['activeInternetTransactionFee'] = $rs->fields['active_internet_transaction_fee'];
            $_POST['addressVerificationFee'] = $rs->fields['address_verification_fee'];
            $_POST['activeAddressVerificationFee'] = $rs->fields['active_address_verification_fee'];
            $_POST['applicationFee'] = $rs->fields['application_fee'];
            $_POST['activeApplicationFee'] = $rs->fields['active_application_fee'];
            $_POST['reserve'] = $rs->fields['reserve'];
            $_POST['activeReserve'] = $rs->fields['active_reserve'];
            $_POST['chargebackFee'] = $rs->fields['chargeback_fee'];
            $_POST['activeChargebackFee'] = $rs->fields['active_chargeback_fee'];
            
            $_POST['active'] = $rs->fields['active'];
            
            $_POST['d_setupFee'] = $rs->fields['d_setup_fee'];
			$_POST['d_monthlyMinimum'] = $rs->fields['d_monthly_minimum'];
            $_POST['d_gatewayFee'] = $rs->fields['d_gateway_fee'];
            $_POST['d_statementFee'] = $rs->fields['d_statement_fee'];
            $_POST['d_discountRate'] = $rs->fields['d_discount_rate'];
            $_POST['d_transactionFee'] = $rs->fields['d_transaction_fee'];
            $_POST['d_techSupportFee'] = $rs->fields['d_tech_support_fee'];
            
            $_POST['d_internet_discount_rate'] = $rs->fields['d_internet_discount_rate'];
            $_POST['d_internet_transaction_fee'] = $rs->fields['d_internet_transaction_fee'];
            $_POST['d_address_verification_fee'] = $rs->fields['d_address_verification_fee'];
            $_POST['d_application_fee'] = $rs->fields['d_application_fee'];
            $_POST['d_reserve'] = $rs->fields['d_reserve'];
            $_POST['d_chargeback_fee'] = $rs->fields['d_chargeback_fee'];
                  			
			$mFilter = new CMS_libs_MerchantServiceMergeFilter();
			$meshArray = array(	'setupFee', 
								'monthlyMinimum', 
								'gatewayFee', 
								'statementFee', 
								'discountRate',
								'transactionFee',
								'techSupportFee'); 

			foreach($meshArray as $col){
				$_POST['m_'.$col] = $mFilter->translate($_POST[$col], $_POST['merchantServiceId']).'';
				$_POST['d_'.$col] = $rs->fields['d_'.$col];
				
				//echo $col . " " . $_POST['d_'.$col] . "<br>";
			}
    }
    
    function loadVersionInfo()
    {
		$rs = CMS_libs_MerchantServices::getVersion($_REQUEST['versionId']);

        if (!$rs || $rs->EOF) {
          _setMessage("Query Error", true, __LINE__, __FILE__);
          return false;
        }
        	$_POST['versionId'] 					=	$_REQUEST['versionId'];
			$_POST['merchantServiceId']				=	$rs->fields['merchant_service_id'];
			$_POST['merchantServiceDetailVersion']	=	$rs->fields['merchant_service_detail_version'];
		    $_POST['merchantServiceImagePath']		=	$rs->fields['merchant_service_image_path'];
			$_POST['merchantServiceLink']			=	$rs->fields['merchant_service_link'];
			$_POST['appLink']						=	$rs->fields['app_link'];
			$_POST['merchantServiceHeaderString']	=	$rs->fields['merchant_service_header_string'];
			$_POST['fid']							=	$rs->fields['fid'];
			$_POST['applyButtonAltText']			=	$rs->fields['apply_button_alt_text'];
			$_POST['merchantServiceImageAltText']	=	$rs->fields['merchant_service_image_alt_text'];
			$_POST['pageMeta']		                =	$rs->fields['page_meta'];
			$_POST['disclaimer']		            =	$rs->fields['disclaimer'];
			$_POST['merchantServiceDetailText']		=	$rs->fields['merchant_service_detail_text'];
			$_POST['merchantServiceIntroDetail']	=	$rs->fields['merchant_service_intro_detail'];
			$_POST['merchantServiceMoreDetail']		=	$rs->fields['merchant_service_more_detail'];
			$_POST['categoryImagePath']				=	$rs->fields['category_image_path'];
			$_POST['categoryImageAltText']			=	$rs->fields['category_image_alt_text'];
    }
}
?>
