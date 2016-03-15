<?
/**
 *
 * ClickSuccess, L.P.
 * March 28, 2006
 *
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 *
 * @package CMS_View
 */

csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_libs_Cards');
csCore_Import::importClass('CMS_libs_Pages');
csCore_Import::importClass('CMS_libs_Networks');
csCore_Import::importClass('CMS_libs_MergeFilter');
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('FCKeditor_FCKeditor');
csCore_Import::importClass('csCore_UI_filter');
csCore_Import::importClass('csCore_UI_formItem');
csCore_Import::importClass('CMS_libs_Amenities');
csCore_Import::importClass('CMS_libs_Merchants');
csCore_Import::importClass('CMS_libs_ProductLinks');
csCore_Import::importClass('CMS_libs_DeviceTypes');
csCore_Import::importClass('CMS_libs_PartnerAccountTypes');

class CMS_view_cards extends CMS_pages_cmsList
{
	var $filter;

	/**
	 * Handles the traffic of the view by directing flow based on $_POST variables
	 * @author Patrick Mizer
	 * @version 1.3
	 */
    function process()
    {
        if(!empty($_POST['commited']))
        {
            switch($_POST['postaction'])
            {

               case 'update':
                    if($this->processUpdateCard())
                        return;
                    break;

               case 'updateVersion':
                    if($this->processUpdateVersion())
                        return;
                    break;

               case 'createVersion':
                    if($this->processCreateVersion())
                        return;
                    break;

				case 'create':
                    if($this->processCreateCard())
                        return;
                    break;
            }
            //$this->loadCardInfo();
            //$this->drawFormEditCard();

			$_POST['massaction'] = isset($_POST['massaction']) ? $_POST['massaction'] : '';
			switch($_POST['massaction'])
            {
                case 'delete':
                    if($this->processDelete())
                        return;
                break;

			}
        }
        else if(!empty($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {

                case 'delete':
                    if($this->processDelete())
                        return;
                    break;

                case 'syndicate':
                    if($this->processUpdateSyndicate())
                        return;
                    break;

                case 'active':
                    if($this->processUpdateActive())
                        return;
                    break;

                case 'makeinact':
                    if($this->processMakeActive(false))
                        return;
                    break;

                case 'makeact':
                    if($this->processMakeActive(true))
                        return;
                    break;

                case 'restriction':
                    if($this->processUpdateRestriction())
                        return;
                    break;

                case 'requiresapproval':
                    if($this->processUpdateRequiresApproval())
                        return;
                    break;

				case 'editVersion':

					$this->loadVersionInfo();
                    if($this->drawFormEditVersion())
                        return;
                    break;

                case 'createVersion':
                    if($this->drawFormCreateVersion())
                        return;
                    break;

                case 'edit':
					$this->loadCardInfo();
                    if($this->drawFormEditCard())
                        return;
                    break;
				case 'create':
                    if($this->drawFormCreateCard())
                        return;
                    break;
				case 'trendStats':
                    if($this->drawTrendStats())
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

    function getMouseOverStyle($row)
    {
    	if(isset($row[2]) && $row[2] != '')
    		return 'listresultMouseOver';
    	else
    		return 'listresultInactive';
    }

    function getMouseOutStyle($row)
    {
    	if(isset($row[2]) && $row[2] != '')
    		return 'listresult';
    	else
    		return 'listresultInactive';
    }

	function setSql()
    {

    	$columns =  implode(", ", $this->keys);
    	$this->sql = "SELECT {$columns}
    	                FROM rt_cards AS c
    	                JOIN cs_carddata AS d ON c.cardId = d.cardId
    	                LEFT JOIN product_links AS pl ON c.cardId = pl.product_id AND pl.link_type_id = 1 AND pl.device_type_id = 1";

   		$this->where = " WHERE c.deleted != 1";

   		$search = $this->filter->getValue('search');

   		if($search != ''){
   			$this->where .= ' AND (c.cardId=' . _q($search) . '
   							  OR c.cardTitle LIKE ' . _q('%'.$search.'%') .'
   							  OR c.cardDescription LIKE ' . _q('%'.$search.'%') .')';
   		}

   		$status = $this->filter->getValue('status');

   		if($status == 'active'){
   			$this->where .= ' AND (c.syndicate = 1 AND c.active = 1)';
   		}else if ($status == 'inactive'){
   			$this->where .= ' AND (c.syndicate != 1 AND c.active != 1)';
   		}

   		if(isset($_REQUEST['merchant']) && $_REQUEST['merchant'] != 'all'){
   			$this->where .= ' AND (c.merchant = '._q(str_replace("~", " ", $_REQUEST['merchant'])).') ';
   		}
    }

    function setPaging()
    {
	    $this->paging = "SELECT COUNT(1) AS count
    	                FROM rt_cards AS c
    	                JOIN cs_carddata AS d ON c.cardId = d.cardId
    	                LEFT JOIN product_links AS pl ON c.cardId = pl.product_id AND pl.link_type_id = 1 AND pl.device_type_id = 1";

    }

    function setFilter()
    {

    	$this->filter->setTitle("Card Filter");

    	$this->filter->addItem(new csCore_UI_formText(array('name' => 'search',
															'value' => isset($_REQUEST['search']) ? $_REQUEST['search'] : '',
															'label' => 'Search (by title or ID): ')));

		$merchants = CMS_libs_Merchants::getAllMerchants();
		$options['all'] = 'All';
		foreach($merchants as $id=>$merchant)
			$options[$merchant['merchantid']] = $merchant['merchantname'];
		//_printR($options);
		$this->filter->addItem(new csCore_UI_formSelect(array('name' => 'merchant',
																'label' => 'Merchant:',
																'options' => $options,
																'value' => isset($_REQUEST['merchant']) ? $_REQUEST['merchant'] : '')));

		$this->filter->addItem(new csCore_UI_formSelect(array('name' => 'status',
																'label' => 'Status:',
																'options' => array('all' => 'All', 'active' => 'Active', 'inactive' => 'Inactive'),
																'value' => isset($_REQUEST['status']) ? $_REQUEST['status'] : '')));

    }


	function getColumns()
    {
		// db Column name => array(Label, sortable, table, callback function)
		return array(
			"cardId"		 		=> array("Card ID", true, "c"),
			"active"				=> array("Active", true, '', 'drawActive'),
			"syndicate"				=> array("Syndication", true, "c", 'drawSyndicate'),
			"private"				=> array("Restictions", true, "c", 'drawPrivate'),
            "requires_approval"     => array("Requires Approval", true, "c", 'drawRequiresApproval'),
			"cardDescription" 		=> array("Internal Name", true, "c"),
			"merchant" 				=> array("Merchant", true, "c"),
			"introApr"				=> array("Intro APR", true, "d"),
			"introAprPeriod"		=> array("Intro APR Period", true, "d"),
			"regularApr"			=> array("Regular APR", true, "d"),
			"monthlyFee"			=> array("Monthly Fee (up&nbsp;to)", true, "d"),
			"annualFee"				=> array("Annual Fee", true, "d"),
			"balanceTransfers"		=> array("Balance Transfers", true, "d"),
			"creditNeeded"			=> array("Credit Needed", true, "d"),
			"url"				    => array("Card Link", true, "pl"),
			"network_id"			=> array("Network", true, "c"),
			"dateCreated" 			=> array("Date Created", true, "c"),
			"dateUpdated" 			=> array("Date Updated", true, "c"),
		);

    }

    function getKey()
    {
    	return "cardId";
    }

    function setSelectActions()
    {

		$label 		= "Make Card Inactive";
    	$action		= "makeinact";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);

		$label 		= "Make Card Active";
    	$action		= "makeact";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= true;
    	$message	=   'If you make this card active it will be available for publishing and syndication.  ' .
    					'In order to restrict this card from syndication or publication you will need to toggle them indivdually.  Proceed?';
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm, $message);

		$label 		= "Toggle Publishable";
    	$action		= "active";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);

		$label 		= "Toggle Syndication";
    	$action		= "syndicate";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);


    	$label 		= "Toggle Restrictions";
    	$action		= "restriction";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);

    	$label 		= "Toggle Req. Approval";
    	$action		= "requiresapproval";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);

    	$label 		= "Edit Card";
    	$action		= "edit";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

 		$label 		= "Delete Card";
    	$action		= "delete";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= true;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);

    	$label 		= "View Trend Statistics";
    	$action		= "trendStats";
    	$vars 		= array("cardId" => $this->getKey());
    	$confirm	= false;
    	$this->selectActions[] = new csCore_UI_action($label, $action,  $vars, $confirm);
    }

    function setTextActions()
    {
    	$label 		= "Create New Card";
    	$action		= "create";
    	$vars 		= array();
    	$confirm	= false;
    	$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
    }

    function loadCardInfo()
    {
        $id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);

		$rs = CMS_libs_Cards::getCard($id);

        if (!$rs || $rs->EOF) {
          _setMessage("Query Error", true, __LINE__, __FILE__);
          return false;
        }
			$_POST['cardId'] =  $id;
            $_POST['site_code'] = $rs->fields['site_code'];
            $_POST['cardTitle'] = $rs->fields['cardTitle'];
            $_POST['cardDescription'] = $rs->fields['cardDescription'];
            $_POST['merchant'] = $rs->fields['merchant'];
            $_POST['introApr'] = $rs->fields['introApr'];
            $_POST['active_introApr'] = $rs->fields['active_introApr'];
			$_POST['regularApr'] = $rs->fields['regularApr'];
			$_POST['active_regularApr'] = $rs->fields['active_regularApr'];
            $_POST['introAprPeriod'] = $rs->fields['introAprPeriod'];
            $_POST['active_introAprPeriod'] = $rs->fields['active_introAprPeriod'];
            $_POST['annualFee'] = $rs->fields['annualFee'];
            $_POST['active_annualFee'] = $rs->fields['active_annualFee'];
            $_POST['monthlyFee'] = $rs->fields['monthlyFee'];
            $_POST['active_monthlyFee'] = $rs->fields['active_monthlyFee'];
            $_POST['balanceTransfers'] =$rs->fields['balanceTransfers'];
            $_POST['balanceTransferFee'] = $rs->fields['balanceTransferFee'];
            $_POST['active_balanceTransferFee'] = $rs->fields['active_balanceTransferFee'];
            $_POST['balanceTransferIntroApr'] = $rs->fields['balanceTransferIntroApr'];
            $_POST['active_balanceTransferIntroApr'] = $rs->fields['active_balanceTransferIntroApr'];
            $_POST['balanceTransferIntroAprPeriod'] = $rs->fields['balanceTransferIntroAprPeriod'];
            $_POST['active_balanceTransferIntroAprPeriod'] = $rs->fields['active_balanceTransferIntroAprPeriod'];
            $_POST['active_balanceTransfers'] =$rs->fields['active_balanceTransfers'];
            $_POST['creditNeeded'] = $rs->fields['creditNeeded'];
            $_POST['active_creditNeeded'] = $rs->fields['active_creditNeeded'];
            $_POST['ratesAndFees'] = $rs->fields['ratesAndFees'];
            $_POST['rewards'] = $rs->fields['rewards'];
			$_POST['cardBenefits'] = $rs->fields['cardBenefits'];
			$_POST['onlineServices'] = $rs->fields['onlineServices'];
			$_POST['footNotes'] = $rs->fields['footNotes'];
			$_POST['layout'] = $rs->fields['layout'];
            $_POST['active'] = $rs->fields['active'];
			$_POST['imagePath'] = $rs->fields['imagePath'];
			$_POST['tPageText'] = $rs->fields['tPageText'];
			$_POST['url'] = $rs->fields['url'];
            $_POST['network_id'] = $rs->fields['network_id'];
			$_POST['applyByPhoneNumber'] = $rs->fields['applyByPhoneNumber'];
			$_POST['syndicate'] = $rs->fields['syndicate'];
			$_POST['active_epd_pages'] = $rs->fields['active_epd_pages'];
			$_POST['active_show_epd_rates'] = $rs->fields['active_show_epd_rates'];
			$_POST['show_verify'] = $rs->fields['show_verify'];
			$_POST['secured'] = ($rs->fields['secured'] ? $rs->fields['secured'] : '0');
	        $_POST['suppress_mobile'] = $rs->fields['suppress_mobile'];

			$mFilter = new CMS_libs_MergeFilter();
			$meshArray = array(	'introApr',
								'regularApr',
								'introAprPeriod',
								'annualFee',
								'monthlyFee',
								'balanceTransfers',
								'balanceTransferFee',
								'balanceTransferIntroApr',
								'balanceTransferIntroAprPeriod',
								'creditNeeded',
							);

			foreach($meshArray as $col){
				$_POST['m_'.$col] = $mFilter->translate($_POST[$col], $_POST['cardId']);
				$_POST['d_'.$col] = $rs->fields['d_'.$col];

				//echo $col . " " . $_POST['d_'.$col] . "<br>";
			}
    }
	function drawFormEditCard()
	{
		$id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);

		$_POST['rs_versions'] = $this->getVersions($id);
		$_POST['defaultVersion'] = CMS_libs_Cards::getDefaultVersion($id);

		$this->assignValue('allAmenities', CMS_libs_Amenities::getUnassignedAmenitiesByCardId($id));
		$this->assignValue('assignedAmenities', CMS_libs_Amenities::getAmenitiesByCardId($id));
		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));
		$this->assignValue('allMerchants', CMS_libs_Merchants::getAllMerchants());
		$this->assignValue('allNetworks', CMS_libs_Networks::getAllNetworks());
		$this->assignValue('productLinks', CMS_libs_ProductLinks::getProductLinksByProductId($id));
		$this->assignValue('deviceTypes', CMS_libs_DeviceTypes::getAllDeviceTypes());
		$this->assignValue('accountTypes', CMS_libs_PartnerAccountTypes::getAllAccountTypes());
		$this->assignValue('username', $this->auth->username);

		$fiveDaysAgo = date('Y') . '-' . date('m') . '-' . (date('d')-5);
		$this->assignValue('unassignedSites', CMS_libs_Cards::getUnassignedSitesByCardId($id));
		$this->assignValue('assignedSites', CMS_libs_Cards::getSitesByCardId($id));
		$this->assignValue('recentlyAssignedSites', CMS_libs_Cards::getSitesByCardIdAndDate($id, $fiveDaysAgo));

		$this->assignValue('nonExcluded', CMS_libs_Cards::getNonExcludedSites($id));
		$this->assignValue('excluded', CMS_libs_Cards::getExcludedSites($id));

		$this->addContent('card_edit');
		return true;
	}

	function drawTrendStats()
	{
		$this->addContent('card_trend');
		return true;
	}

	function drawFormCreateCard(){
		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('cardDetailText');
		$oFCKeditor->Value = $_POST['cardDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('cardIntroDetail');
		$oFCKeditor->Value = $_POST['cardIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('cardMoreDetail');
		$oFCKeditor->Value = $_POST['cardMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;

		$this->assignValue('allAmenities', CMS_libs_Amenities::getAllAmenities());
		$this->assignValue('allSites', CMS_libs_Sites::getAllSites());
		$this->assignValue('allMerchants', CMS_libs_Merchants::getAllMerchants());

		$this->addContent('card_create');
		return true;
	}

	function getVersions($cardId)
	{
		$sql = "SELECT * FROM rt_carddetails WHERE cardId = " . _q($cardId) . " AND deleted != 1 ORDER BY cardDetailLabel ASC";
		//echo $sql;
		return _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

    function processUpdateCard()
    {
		if(!isset($_REQUEST['network_id']) || $_REQUEST['network_id']==-1) {
			_setMessage("ERROR: Please select a network for the card!!!");
			return true;
		}


        if(isset($_REQUEST['cardId']) && isset($_REQUEST['assignedAmenities'])){
		    CMS_libs_Amenities::assignAmenities($_REQUEST['cardId'], $_REQUEST['assignedAmenities']);
		}else{
			CMS_libs_Amenities::assignAmenities($_REQUEST['cardId'], array());
		}
		if(isset($_REQUEST['cardId']) && isset($_REQUEST['assignedSites'])){
			CMS_libs_Cards::assignSites($_REQUEST['cardId'], $_REQUEST['assignedSites']);
		}
		if(isset($_REQUEST['cardId']) && isset($_REQUEST['unassignedSites'])){
			CMS_libs_Cards::removeSites($_REQUEST['cardId'], $_REQUEST['unassignedSites']);
		}
	    if(isset($_REQUEST['cardId']) && isset($_REQUEST['excluded'])){
			CMS_libs_Cards::assignExcludes($_REQUEST['cardId'], $_REQUEST['excluded']);
		}
		if(isset($_REQUEST['cardId']) && isset($_REQUEST['nonExcluded'])){
			CMS_libs_Cards::removeExcludes($_REQUEST['cardId'], $_REQUEST['nonExcluded']);
		}

        if(!isset($_REQUEST['active']) || $_REQUEST['active'] != 1) {
			$_REQUEST['active'] = 0;
		}

		$params = array(
            'site_code'                       	    => isset($_REQUEST['site_code']) ? $_REQUEST['site_code'] : '',
            'cardDescription'                	    => isset($_REQUEST['cardDescription']) ? $_REQUEST['cardDescription'] : '',
            'introApr'                       	    => isset($_REQUEST['introApr']) ? $_REQUEST['introApr'] : '',
			'active_introApr'                	    => isset($_REQUEST['active_introApr']) ? $_REQUEST['active_introApr'] : '',
			'regularApr'                     	    => isset($_REQUEST['regularApr']) ? $_REQUEST['regularApr'] : '',
			'active_regularApr'              	    => isset($_REQUEST['active_regularApr']) ? $_REQUEST['active_regularApr'] : '',
            'introAprPeriod'                  	    => isset($_REQUEST['introAprPeriod']) ? $_REQUEST['introAprPeriod'] : '',
            'active_introAprPeriod'           	    => isset($_REQUEST['active_introAprPeriod']) ? $_REQUEST['active_introAprPeriod'] : '',
            'annualFee'                       	    => isset($_REQUEST['annualFee']) ? $_REQUEST['annualFee'] : '',
            'active_annualFee'                	    => isset($_REQUEST['active_annualFee']) ? $_REQUEST['active_annualFee'] : '',
            'monthlyFee'                     	    => isset($_REQUEST['monthlyFee']) ? $_REQUEST['monthlyFee'] : '',
            'active_monthlyFee'              	    => isset($_REQUEST['active_monthlyFee']) ? $_REQUEST['active_monthlyFee'] : '',
            'balanceTransfers'               	    => isset($_REQUEST['balanceTransfers']) ? $_REQUEST['balanceTransfers'] : '',
            'active_balanceTransfers'         	    => isset($_REQUEST['active_balanceTransfers']) ? $_REQUEST['active_balanceTransfers'] : '',
            'balanceTransferFee'	         	    => isset($_REQUEST['balanceTransferFee']) ? $_REQUEST['balanceTransferFee'] : '',
            'active_balanceTransferFee'	     	    => isset($_REQUEST['active_balanceTransferFee']) ? $_REQUEST['active_balanceTransferFee'] : '',
            'balanceTransferIntroApr'	      	    => isset($_REQUEST['balanceTransferIntroApr']) ? $_REQUEST['balanceTransferIntroApr'] : '',
            'active_balanceTransferIntroApr'	    => isset($_REQUEST['active_balanceTransferIntroApr']) ? $_REQUEST['active_balanceTransferIntroApr'] : '',
            'balanceTransferIntroAprPeriod'	        => isset($_REQUEST['balanceTransferIntroAprPeriod']) ? $_REQUEST['balanceTransferIntroAprPeriod'] : '',
            'active_balanceTransferIntroAprPeriod'	=> isset($_REQUEST['active_balanceTransferIntroAprPeriod']) ? $_REQUEST['active_balanceTransferIntroAprPeriod'] : '',
            'creditNeeded'                          => isset($_REQUEST['creditNeeded']) ? $_REQUEST['creditNeeded'] : '',
            'active_creditNeeded'                   => isset($_REQUEST['active_creditNeeded']) ? $_REQUEST['active_creditNeeded'] : '',
            'ratesAndFees'                          => isset($_REQUEST['ratesAndFees']) ? $_REQUEST['ratesAndFees'] : '',
            'rewards'                               => isset($_REQUEST['rewards']) ? $_REQUEST['rewards'] : '',
            'cardBenefits'                          => isset($_REQUEST['cardBenefits']) ? $_REQUEST['cardBenefits'] : '',
            'onlineServices'                        => isset($_REQUEST['onlineServices']) ? $_REQUEST['onlineServices'] : '',
            'footNotes'                             => isset($_REQUEST['footNotes']) ? $_REQUEST['footNotes'] : '',
            'layout'                                => isset($_REQUEST['layout']) ? $_REQUEST['layout'] : '',
			'tPageText'                             => isset($_REQUEST['tPageText']) ? $_REQUEST['tPageText'] : '',
//			'url'                                   => isset($_REQUEST['url']) ? $_REQUEST['url'] : '',
            //'network_id'                            => isset($_REQUEST['network_id']) ? $_REQUEST['network_id'] : '',
			'applyByPhoneNumber'                   => isset($_REQUEST['applyByPhoneNumber']) ? $_REQUEST['applyByPhoneNumber'] : '',
			'active_epd_pages'                      => isset($_REQUEST['active_epd_pages']) ? $_REQUEST['active_epd_pages'] : '',
			'active_show_epd_rates'                 => isset($_REQUEST['active_show_epd_rates']) ? $_REQUEST['active_show_epd_rates'] : '',
			'show_verify'                           => isset($_REQUEST['show_verify']) ? $_REQUEST['show_verify'] : 0,
			'secured'								=> isset($_REQUEST['secured']) ? $_REQUEST['secured'] : 0,
		    'network_id'							=> $_REQUEST['network_id'],
			'suppress_mobile'                       => isset($_REQUEST['suppress_mobile']) ? $_REQUEST['suppress_mobile'] : 0
			);

        // save changes of user to db
        CMS_libs_Cards::updateCard($_REQUEST['cardId'], $params);

        $_REQUEST['cardLink'] = isset($_REQUEST['cardLink']) ? $_REQUEST['cardLink'] : '';
        $temp = explode(".", $_REQUEST['cardLink']);

		if(is_array($temp)) {
			$_REQUEST['cardLink'] = $temp[0];
		}


        $params = array();
        $meshArray = array(	'introApr',
							'regularApr',
							'introAprPeriod',
							'annualFee',
							'monthlyFee',
							'balanceTransfers',
							'balanceTransferFee',
							'balanceTransferIntroApr',
							'balanceTransferIntroAprPeriod',
							'creditNeeded',
							);

		foreach($meshArray as $col) {
			if(isset( $_REQUEST['d_'.$col])) {
				$params[$col] = $_REQUEST['d_'.$col];
			}
		}

        CMS_libs_Cards::updateCardData($_REQUEST['cardId'], $params);

		_setMessage("Card Successfully Updated");
        return false;
    }

    function drawFormCreateVersion(){
		$_POST['action'] = "createVersion";
		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('cardDetailText');
		$oFCKeditor->Value = $_POST['cardDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('cardIntroDetail');
		$oFCKeditor->Value = $_POST['cardIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('cardMoreDetail');
		$oFCKeditor->Value = $_POST['cardMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('specialsDescription');
		$oFCKeditor->Value = $_POST['specialsDescription'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject4'] = $oFCKeditor;

		$_POST['rs_sites'] = CMS_libs_Cards::getUnusedVersions($_REQUEST['cardId']);
		$_POST['cardId'] = $_REQUEST['cardId'];
		$this->addContent('card_createVersion');
		return true;
	}


   function processMakeActive($active){
   		$bit =	$active ? 1 : 0;
   		$params = array('active' => $bit);

   		//print'<pre>';print_r($params);print'</pre>';
   		CMS_libs_Cards::updateCard($_REQUEST['cardId'], $params);
   }


   function processUpdateSyndicate()
   {
   		$sql = "SELECT syndicate FROM rt_cards WHERE cardId = " . _q($_REQUEST[$this->getKey()]);

   		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

   		$bit = ((int)$rs->fields['syndicate']) ^ 1;

   		$params = array('cardId' => $_REQUEST[$this->getKey()],
   						'syndicate' => $bit);

   		CMS_libs_Cards::updateCard($_REQUEST['cardId'], $params);
   }

   function processUpdateRequiresApproval() {
        $sql = "SELECT requires_approval FROM rt_cards WHERE cardId = " . _q($_REQUEST[$this->getKey()]);

   		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

   		$bit = ((int)$rs->fields['requires_approval']) ^ 1;

   		$params = array('cardId' => $_REQUEST[$this->getKey()],
   						'requires_approval' => $bit);

   		CMS_libs_Cards::updateCard($_REQUEST['cardId'], $params);
   }

   function processUpdateRestriction()
   {
   		$sql = "SELECT private FROM rt_cards WHERE cardId = " . _q($_REQUEST[$this->getKey()]);

   		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

   		$bit = ((int)$rs->fields['private']) ^ 1;

   		$params = array('cardId' => $_REQUEST[$this->getKey()],
   						'private' => $bit);

   		CMS_libs_Cards::updateCard($_REQUEST['cardId'], $params);
   }


   function processUpdateActive()
   {
   		$sql = "SELECT active FROM rt_cards WHERE cardId = " . _q($_REQUEST[$this->getKey()]);


   		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

   		$bit = ((int)$rs->fields['active']) ^ 1;

   		$params = array('cardId' => $_REQUEST[$this->getKey()],
   						'active' => $bit);

   		CMS_libs_Cards::updateCard($_REQUEST['cardId'], $params);
   }

   function processCreateVersion()
    {

		if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;
		/**
		foreach($_REQUEST as $col=>$data){
			echo $col . " : " . $data . "<br>";
		}
		**/

		$temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];
		}

		$params = array(
			'cardId' => $_REQUEST['cardId'],
			'cardDetailVersion' => $_REQUEST['cardDetailVersion'],
			//'cardDetailLabel' =>  $rs->fields['pageName'],
            'cardDetailText' =>  $_REQUEST['cardDetailText'],
            'cardIntroDetail' => $_REQUEST['cardIntroDetail'],
            'cardMoreDetail' => $_REQUEST['cardMoreDetail'],
            'cardSeeDetails' => $_REQUEST['cardSeeDetails'],
			'categoryImage' => $_REQUEST['categoryImage'],
            'categoryAltText' => $_REQUEST['categoryAltText'],
            'cardIOImage' => $_REQUEST['cardIOImage'],
            'cardIOAltText' =>  $_REQUEST['cardIOAltText'],
            'cardButtonAltText' =>  $_REQUEST['cardButtonAltText'],
            'cardIOButtonAltText' =>  $_REQUEST['cardIOButtonAltText'],
            'cardIconSmall' => $_REQUEST['cardIconSmall'],
            'cardIconMid' => $_REQUEST['cardIconMid'],
            'cardIconLarge' => $_REQUEST['cardIconLarge'],
            'specialsDescription' => $_REQUEST['specialsDescription'],
            'specialsAdditionalLink' => $_REQUEST['specialsAdditionalLink'],
            'cardLink' => $_REQUEST['cardLink'],
            'appLink' => $_REQUEST['appLink'],
            'cardListingString' =>  $_REQUEST['cardListingString'],
            'cardPageHeaderString' =>  $_REQUEST['cardPageHeaderString'],

			'fid' =>  $_REQUEST['fid'],
			'cardTeaserText' =>  $_REQUEST['cardTeaserText']

		);


        // save changes of user to db
        CMS_libs_Cards::addVersion($params);

        return true;
    }

    function loadVersionInfo()
    {
        $id = $_REQUEST['versionId'];

		$rs = CMS_libs_Cards::getVersion($id);

        if (!$rs || $rs->EOF) {
          _setMessage("Query Error", true, __LINE__, __FILE__);
          return false;
        }
			$_POST['versionId'] = $id;
            $_POST['cardDetailText'] =  $rs->fields['cardDetailText'];
            $_POST['cardIntroDetail'] = $rs->fields['cardIntroDetail'];
            $_POST['cardMoreDetail'] = $rs->fields['cardMoreDetail'];
            $_POST['cardSeeDetails'] = $rs->fields['cardSeeDetails'];
			$_POST['categoryImage'] = $rs->fields['categoryImage'];
            $_POST['categoryAltText'] = $rs->fields['categoryAltText'];
            $_POST['cardIOImage'] = $rs->fields['cardIOImage'];
            $_POST['cardIOAltText'] = $rs->fields['cardIOAltText'];
            $_POST['cardButtonAltText'] = $rs->fields['cardButtonAltText'];
            $_POST['cardIOButtonAltText'] = $rs->fields['cardIOButtonAltText'];
            $_POST['cardIconSmall'] = $rs->fields['cardIconSmall'];
            $_POST['cardIconMid'] = $rs->fields['cardIconMid'];
            $_POST['cardIconLarge'] = $rs->fields['cardIconLarge'];
            $_POST['specialsDescription'] = $rs->fields['specialsDescription'];
            $_POST['specialsAdditionalLink'] = $rs->fields['specialsAdditionalLink'];
			$_POST['cardLink'] = $rs->fields['cardLink'];
			$_POST['appLink'] = $rs->fields['appLink'];
			$_POST['cardPageMeta'] = $rs->fields['cardPageMeta'];
			$_POST['cardListingString'] = $rs->fields['cardListingString'];
			$_POST['cardPageHeaderString'] = $rs->fields['cardPageHeaderString'];
			$_POST['fid'] = $rs->fields['fid'];
			$_POST['cardTeaserText'] = $rs->fields['cardTeaserText'];

			//print htmlentities($_POST['cardPageMeta']);
			//print'<pre>';print_r($rs);print'</pre>';
    }


    function drawFormEditVersion(){
		$_POST['action'] = "updateVersion";
		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('cardDetailText');
		$oFCKeditor->Value = $_POST['cardDetailText'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject1'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('cardIntroDetail');
		$oFCKeditor->Value = $_POST['cardIntroDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject2'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('cardMoreDetail');
		$oFCKeditor->Value = $_POST['cardMoreDetail'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject3'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('specialsDescription');
		$oFCKeditor->Value = $_POST['specialsDescription'];
		$oFCKeditor->BasePath = $sBasePath ;
		$_POST['editorObject4'] = $oFCKeditor;

		$_POST['rs_sites'] = CMS_libs_Cards::getUnusedVersions($_REQUEST['cardId']);
		$_POST['cardId'] = $_REQUEST['cardId'];
		$this->loadCardInfo();

		$_POST['edit'] = true;


		//print htmlentities($_POST['cardPageMeta']);
		$this->addContent('card_createVersion');



		return true;
	}

	function processUpdateVersion(){
        if(isset($_REQUEST['active']) && $_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];
		}

		$params = array(
            'cardIntroDetail'         => isset($_REQUEST['cardIntroDetail'])        ? $_REQUEST['cardIntroDetail']      : '',
            'cardMoreDetail'          => isset($_REQUEST['cardMoreDetail'])         ? $_REQUEST['cardMoreDetail']       : '',
            'cardSeeDetails'          => isset($_REQUEST['cardSeeDetails'])         ? $_REQUEST['cardSeeDetails']       : '',
			'categoryImage'           => isset($_REQUEST['categoryImage'])          ? $_REQUEST['categoryImage']                             : '',
            'categoryAltText'         => isset($_REQUEST['categoryAltText'])        ? $_REQUEST['categoryAltText']      : '',
            'cardIOImage'             => isset($_REQUEST['cardIOImage'])            ? $_REQUEST['cardIOImage']                               : '',
            'cardIOAltText'           => isset($_REQUEST['cardIOAltText'])          ? $_REQUEST['cardIOAltText']        : '',
            'cardButtonAltText'       => isset($_REQUEST['cardButtonAltText'])      ? $_REQUEST['cardButtonAltText']    : '',
            'cardIOButtonAltText'     => isset($_REQUEST['cardIOButtonAltText'])    ? $_REQUEST['cardIOButtonAltText']  : '',
            'cardIconSmall'           => isset($_REQUEST['cardIconSmall'])          ? $_REQUEST['cardIconSmall']                             : '',
            'cardIconMid'             => isset($_REQUEST['cardIconMid'])            ? $_REQUEST['cardIconMid']                               : '',
            'cardIconLarge'           => isset($_REQUEST['cardIconLarge'])          ? $_REQUEST['cardIconLarge']                             : '',
            'specialsDescription'     => isset($_REQUEST['specialsDescription'])    ? $_REQUEST['specialsDescription']  : '',
            'specialsAdditionalLink'  => isset($_REQUEST['specialsAdditionalLink']) ? $_REQUEST['specialsAdditionalLink']                    : '',
            'cardLink'                => isset($_REQUEST['cardLink'])               ? $_REQUEST['cardLink']                                  : '',
            'appLink'                 => isset($_REQUEST['appLink'])                ? $_REQUEST['appLink']                                   : '',
            'cardPageMeta'            => isset($_REQUEST['cardPageMeta'])           ? $_REQUEST['cardPageMeta']         : '',
            'cardListingString'       => isset($_REQUEST['cardListingString'])      ? $_REQUEST['cardListingString']    : '',
            'cardPageHeaderString'    => isset($_REQUEST['cardPageHeaderString'])   ? $_REQUEST['cardPageHeaderString'] : '',
            'fid'                     => isset($_REQUEST['fid'])                    ? $_REQUEST['fid']                                       : '',
			'cardTeaserText'          => isset($_REQUEST['cardTeaserText'])         ? $_REQUEST['cardTeaserText']      : ''
		);

        // save changes of user to db
        CMS_libs_Cards::updateVersion($_REQUEST['versionId'], $params);

        print_r($_REQUEST['cardPageMeta']);
        print_r($params['cardPageMeta']);


		_setMessage("Version Successfully Updated");

      	$this->loadCardInfo();
        $this->drawFormEditCard();

        return true;

	}

	function drawSyndicate($row)
	{

		if($row['syndicate'] == 1){
			return "<font color ='green'><b>ON</b></font>";
		}
		return "<font color='red'><b>OFF</b></font>";


	}

	function drawActive($row)
	{

		return $row['active'] == 1?"<font color ='green'><b>ACTIVE</b></font>":"<font color='red'><b>INACTIVE</b></font>";


	}

    function drawRequiresApproval($row)
    {
        if($row['requires_approval']){
			return "<font color ='red'><b>REQUIRED</b></font>";
		}
		return "<font color='green'><b>NOT REQUIRED</b></font>";
    }

	function drawPrivate($row)
	{
		if($row['private']){
			return "<font color ='red'><b>PRIVATE</b></font>";
		}
		return "<font color='green'><b>PUBLIC</b></font>";
	}


    // **********************************************************************
    // **********************************************************************


    function processCreateCard()
    {

        if($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$params = array(
            'cardId' =>  $_REQUEST['cardId'],
            'site_code' =>  $_REQUEST['site_code'],
            'cardTitle' =>  $_REQUEST['cardTitle'],
            'url' => $_REQUEST['url'],
            //'network_id' => $_REQUEST['network_id'],

			'applyByPhoneNumber' => $_REQUEST['applyByPhoneNumber'],

			'cardDescription' => $_REQUEST['cardDescription'],
            'merchant' => $_REQUEST['merchant'],
            'introApr' => $_REQUEST['introApr'],
			'active_introApr' => $_REQUEST['active_introApr'],
			'regularApr' => $_REQUEST['regularApr'],
			'active_regularApr' => $_REQUEST['active_regularApr'],
            'introAprPeriod' => $_REQUEST['introAprPeriod'],
            'active_introAprPeriod' => $_REQUEST['active_introAprPeriod'],
            'annualFee' => $_REQUEST['annualFee'],
            'active_annualFee' => $_REQUEST['active_annualFee'],
            'monthlyFee' =>  $_REQUEST['monthlyFee'],
            'active_monthlyFee' =>  $_REQUEST['active_monthlyFee'],
            'balanceTransfers' =>   $_REQUEST['balanceTransfers'],
            'active_balanceTransfers' =>   $_REQUEST['active_balanceTransfers'],
            'balanceTransferFee'	=> $_REQUEST['balanceTransferFee'],
            'active_balanceTransferFee'	=> $_REQUEST['active_balanceTransferFee'],
            'balanceTransferIntroApr'	=> $_REQUEST['balanceTransferIntroApr'],
            'active_balanceTransferIntroApr'	=> $_REQUEST['active_balanceTransferIntroApr'],
            'balanceTransferIntroAprPeriod'	=> $_REQUEST['balanceTransferIntroAprPeriod'],
            'active_balanceTransferIntroAprPeriod'	=> $_REQUEST['active_balanceTransferIntroAprPeriod'],
            'creditNeeded' =>     	$_REQUEST['creditNeeded'],
            'active_creditNeeded' =>    $_REQUEST['active_creditNeeded'],
            'ratesAndFees' =>      $_REQUEST['ratesAndFees'],
            'rewards' =>         	$_REQUEST['rewards'],
            'cardBenefits' =>      $_REQUEST['cardBenefits'],
            'onlineServices' =>    $_REQUEST['onlineServices'],
            'footNotes' =>         $_REQUEST['footNotes'],
            'layout' =>         	$_REQUEST['layout'],
            'active' =>         	$_REQUEST['active'],
            'syndicate' =>         	$_REQUEST['syndicate'],
            'imagePath' =>         	$_REQUEST['imagePath'],
            'tPageText' =>         	$_REQUEST['tPageText'],
			'active_epd_pages' =>		$_REQUEST['active_epd_pages'],
			'active_show_epd_rates' =>		$_REQUEST['active_show_epd_rates'],
			'show_verify' =>		$_REQUEST['show_verify'],
			'secured' => $_REQUEST['secured']
		);


        /**if(QUnit_Messager::getErrorMessage() != '')
        {
			$this->closeWindow('Affiliate_CMS_Views_CardManager');
			$this->addContent('closewindow');
            return true;
        }	**/

        // save changes of user to db
        CMS_libs_Cards::addCard($params);



        //Map the new card to a CCX card
        $params = array(
        	'cms_card_id' => $_REQUEST['cardId'],
        	'ccx_card_id' => $_REQUEST['ccxId']
        );
        CMS_libs_Cards::mapToCcx($params);



        $temp = explode(".", $_REQUEST['cardLink']);
		if(is_array($temp)){
			$_REQUEST['cardLink'] = $temp[0];
		}

		$params = array(
            'cardDetailText' =>  $_REQUEST['cardDetailText'],
            'cardIntroDetail' => $_REQUEST['cardIntroDetail'],
            'cardMoreDetail' => $_REQUEST['cardMoreDetail'],
            'cardSeeDetails' => $_REQUEST['cardSeeDetails'],
			'categoryImage' => $_REQUEST['categoryImage'],
            'categoryAltText' => $_REQUEST['categoryAltText'],
            'cardIOImage' => $_REQUEST['cardIOImage'],
            'cardIOAltText' =>  $_REQUEST['cardIOAltText'],
            'cardButtonAltText' =>  $_REQUEST['cardButtonAltText'],
            'cardIOButtonAltText' =>  $_REQUEST['cardIOButtonAltText'],
            'cardIconSmall' =>     $_REQUEST['cardIconSmall'],
            'cardIconMid' =>      $_REQUEST['cardIconMid'],
            'cardIconLarge' =>         	$_REQUEST['cardIconLarge'],
            'specialsDescription' =>    $_REQUEST['specialsDescription'],
            'specialsAdditionalLink' => $_REQUEST['specialsAdditionalLink'],
            'cardLink' => $_REQUEST['cardLink'],
            'appLink' => $_REQUEST['appLink'],
            'cardListingString' =>  $_REQUEST['cardListingString'],
            'cardPageHeaderString' =>  $_REQUEST['cardPageHeaderString'],
            'fid' =>  $_REQUEST['fid'],
		);

		CMS_libs_Cards::addDefaultVersion($_REQUEST['cardId'] ,$params);


		$params = array();
        $meshArray = array(	'introApr',
							'regularApr',
							'introAprPeriod',
							'annualFee',
							'monthlyFee',
							'balanceTransfers',
							'balanceTransferFee',
							'balanceTransferIntroApr',
							'balanceTransferIntroAprPeriod',
							'creditNeeded',
							);
		foreach($meshArray as $col){
			$params[$col] = $_REQUEST['d_'.$col];
		}
        CMS_libs_Cards::updateCardData($_REQUEST['cardId'], $params);


       	CMS_libs_Amenities::assignAmenities($_REQUEST['cardId'], $_REQUEST['assignedAmenities']);

       	CMS_libs_Cards::assignSites($_REQUEST['cardId'], $_REQUEST['assignedSites']);

       	CMS_libs_Cards::assignExcludes($_REQUEST['cardId'], $_REQUEST['excluded']);

        _setSuccess("Card Successfully Created");

        return false;
    }

    //--------------------------------------------------------------------------

    function processDelete()
    {
		if(($EIDs = $this->returnEIDs()) == false)
            return false;

		$sqlEIDs = "('" . implode("','", $EIDs) . "')";

		//print'<pre>';print_r($sqlEIDs);print'</pre>';

		CMS_libs_Cards::deleteCards($sqlEIDs);
        return false;
    }

    //--------------------------------------------------------------------------

    function showTransactions($exportToCsv)
    {
        $temp_perm['view'] = $this->checkPermissions('view');
        $temp_perm['create'] = $this->checkPermissions('create');

		$rs = Affiliate_CMS_Bl_Pages::getAllDistinctPages();
		while(!$rs->EOF){
			$pageArray[$rs->fields['cardpageId']] = $rs->fields['pageName'];
			$rs->MoveNext();
		}

		$_POST['pageArray'] = $pageArray;

        $this->assign('a_action_permission', $temp_perm);

        $this->createWhereOrderBy($orderby, $where);


        $recs = $this->getRecords($orderby, $where);
        $this->initViews();

        $list_data = QUnit_Global::newobj('QCore_RecordSet');
        $list_data->setTemplateRS($recs);

        $this->assign('a_list_data', $list_data);
        $this->assign('a_curyear', date("Y"));

        $this->pageLimitsAssign();

        $this->addContent('cards_list');
    }

    //--------------------------------------------------------------------------

    function getRecords($orderby, $where)
    {

		if($_REQUEST['runQuery'] == 'false'){
			$_POST['runQuery'] = 'false';
			return;
		}
        //------------------------------------------------
        // init paging
        $sql = 'select count(*) as count from rt_cards ';
        $limitOffset = initPaging($this->getTotalNumberOfRecords($sql.$where));

        //------------------------------------------------
        // get records
        $sql = "select *, ".sqlShortDate('dateCreated')." as dateC, ".sqlShortDate('dateUpdated')." as dateU from rt_cards";
        $rs = QCore_Sql_DBUnit::selectLimit($sql.$where.$orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
        if (!$rs)
        {
            QUnit_Messager::setErrorMessage(L_G_DBERROR);
            return;
        }

        return $rs;
    }

    //--------------------------------------------------------------------------

    /** returns list of columns in list view */
    function getAvailableColumns()
    {
		return array(
            'cardId' =>         	array(L_G_CRM_CARDID, 'cardId'),
            'cardTitle' =>         	array(L_G_CRM_CARDTITLE, 'cardTitle'),
            'cardDescription' =>    array(L_G_CRM_CARDDESCR, 'cardDescription'),
            'merchant' =>         	array(L_G_CRM_MERCHANT, 'merchant'),
            'introApr' =>         	array(L_G_CRM_INTROAPR, 'introApr'),
            'introAprPeriod' =>     array(L_G_CRM_INTROAPRPERIOD, 'introAprPeriod'),
            'regularApr' => 		array("Regular APR", 'regularApr'),
			'annualFee' =>         	array(L_G_CRM_ANNUALFEE, 'annualFee'),
            'monthlyFee' =>         array(L_G_CRM_MONTHLYFEE, 'monthlyFee'),
            'balanceTransfers' =>   array(L_G_CRM_BALANCETRANSFERS, 'balanceTransfers'),
            'creditNeeded' =>     	array(L_G_CRM_CREDITNEEDED, 'creditNeeded'),
            'ratesAndFees' =>       array(L_G_CRM_RATESANDFEES, 'ratesAndFees'),
            'rewards' =>         	array(L_G_CRM_REWARDS, 'rewards'),
            'cardBenefits' =>       array(L_G_CRM_CARDBENEFITS, 'cardBenefits'),
            'onlineServices' =>     array(L_G_CRM_ONLINESERVICES, 'onlineServices'),
            'footNotes' =>         	array(L_G_CRM_FOOTNOTES, 'footNotes'),
            'layout' =>         	array(L_G_CRM_LAYOUT, 'layout'),
            'dateCreated' =>        array(L_G_CRM_DATEINSERTED, 'dateC'),
            'dateUpdated' =>        array(L_G_CRM_DATEUPDATED, 'dateU'),
            'active' =>         	array(L_G_CRM_ACTIVE, 'active'),
			'actions' =>           	array(L_G_ACTIONS, ''),
        );
    }

    //--------------------------------------------------------------------------

    function getListViewName()
    {
        return 'cards_list';
    }

    //--------------------------------------------------------------------------

    function initViews()
    {
        // create default view
        $viewColumns = array(
            'cardId',
            'cardTitle',
            //'merchant',
            'introApr',
            'introAprPeriod',
			'regularApr',
			'annualFee',
			'monthlyFee',
			'balanceTransfers',
			'creditNeeded',
			'active',
			'dateCreated',
			'dateUpdated',
			'actions'
        );

        $this->createDefaultView($viewColumns);

        $this->loadAvailableViews();

        $tplAvailableViews = array();
        foreach($this->availableViews as $objView)
        {
            $tplAvailableViews[$objView->dbid] = $objView->getName();
        }

        $this->assign('a_list_views', $this->tplAvailableViews);

        $this->applyView();
    }

    //--------------------------------------------------------------------------

    function createWhereOrderBy(&$orderby, &$where)
    {
		$_SESSION['search'] = $_REQUEST['search'];
		$_SESSION['cardId'] = $_REQUEST['cardId'];

		if($_REQUEST['cardpage'] != "")
			$_SESSION['cardpage'] = $_REQUEST['cardpage'];


        $orderby = '';
        $where = '';

        $a = array_keys($this->getAvailableColumns());

        if($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a))
        {
            $orderby = " order by ".$_REQUEST['sortby']." ".$_REQUEST['sortorder'];
        }
        else
        {
            $orderby = " order by rt_cards.cardTitle";
        }

		$where = " WHERE deleted != 1 AND subCat = 0 ";

		if($_SESSION['cardpage'] != '' && $_SESSION['cardpage'] != "_"){
       		$rs = Affiliate_CMS_Bl_Cards::getCardsByPage($_SESSION['cardpage'],-1);
       		while(!$rs->EOF){
       			$idArray[] = $rs->fields['cardId'];
       			$rs->MoveNext();
       		}
       		if(count($idArray) > 0)
       			$sqlIds = "('".implode("','", $idArray) ."')";
       		else
       			$sqlIds = "('')";
       		$where .= " AND ";
        	$where .= " cardId in ". $sqlIds;
		}

		if($_SESSION['cardId'] != ''){
       		$where .= " AND ";
        	$where .= " cardId = ". _q($_SESSION['cardId']);
        }

		if($_SESSION['search'] != ''){
       			$where .= " AND ";
        	$where .= " cardTitle LIKE '%". $_SESSION['search'] . "%'";
        }

        return true;
    }

    //--------------------------------------------------------------------------

    function printListRow($row)
    {
        $view = $this->getView();
        if($view == false || $view == null)
        {
            print '<td><font color="ff0000">no view given</font></td>';
            return false;
        }
		$arrowString = '&nbsp;<a href=index.php?md=Affiliate_CMS_Views_CardManager&action=up&id=' . $row['cardId']. '><img src="../templates/standard/images/sort_up.gif"></a>&nbsp;&nbsp; ' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_CMS_Views_CardManager&action=down&id=' . $row['cardId']. '><img src="../templates/standard/images/sort_down.gif"></a>';
		if($row['order'] == 1)
			$arrowString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_CMS_Views_CardManager&action=down&id=' . $row['cardId']. '><img src="../templates/standard/images/sort_down.gif"></a>';


		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="'.$row['id'].'"></td>';

        foreach($view->columns as $column)
        {
            switch($column)
            {

				case 'cardId': print '<td class=foo align=right nowrap>&nbsp;'.$row['cardId'].'&nbsp;</td>';
                        break;
				case 'cardTitle': print '<td align=right nowrap>&nbsp;'.$row['cardTitle'].'&nbsp;</td>';
                        break;
				case 'cardDescription': print '<td align=right>&nbsp;'.$row['cardDescription'].'&nbsp;</td>';
                        break;
				case 'merchant': print '<td align=right nowrap>&nbsp;'.$row['merchant'].'&nbsp;</td>';
                        break;
				case 'introApr': print '<td align=right nowrap>&nbsp;'.$row['introApr'].'&nbsp;</td>';
                        break;
				case 'introAprPeriod': print '<td align=right nowrap>&nbsp;'.$row['introAprPeriod'].'&nbsp;</td>';
                        break;
				case 'regularApr': print '<td align=right nowrap>&nbsp;'.$row['regularApr'].'&nbsp;</td>';
                        break;
				case 'annualFee': print '<td align=right nowrap>&nbsp;'.$row['annualFee'].'&nbsp;</td>';
                        break;
				case 'monthlyFee': print '<td align=right nowrap>&nbsp;'.$row['monthlyFee'].'&nbsp;</td>';
                        break;
				case 'balanceTransfers': print '<td align=right nowrap>&nbsp;'.$row['balanceTransfers'].'&nbsp;</td>';
                        break;
				case 'creditNeeded': print '<td align=right nowrap>&nbsp;'.$row['creditNeeded'].'&nbsp;</td>';
                        break;
				case 'ratesAndFees': print '<td align=right nowrap>&nbsp;'.$row['ratesAndFees'].'&nbsp;</td>';
                        break;
				case 'rewards': print '<td align=right nowrap>&nbsp;'.$row['rewards'].'&nbsp;</td>';
                        break;
				case 'cardBenefits': print '<td align=right nowrap>&nbsp;'.$row['cardBenefits'].'&nbsp;</td>';
                        break;
				case 'onlineServices': print '<td align=right nowrap>&nbsp;'.$row['onlineServices'].'&nbsp;</td>';
                        break;
				case 'footNotes': print '<td  align=right nowrap>&nbsp;'.$row['footNotes'].'&nbsp;</td>';
                        break;
				case 'layout': print '<td align=right nowrap>&nbsp;'.$row['layout'].'&nbsp;</td>';
                        break;
				case 'dateCreated': print '<td align=right nowrap>&nbsp;'.$row['dateC'].'&nbsp;</td>';
                        break;
                case 'dateUpdated': print '<td align=right nowrap>&nbsp;'.$row['dateU'].'&nbsp;</td>';
                        break;
				case 'active': $active = $row['active'] == 1?"ACTIVE":"NOT ACTIVE";
						print '<td align=right nowrap>&nbsp;'.$active.'&nbsp;</td>';
                        break;
                case 'actions':
?>
                        <td class=listresult>
                            <select name=action_select OnChange="performAction(this);">
                                <option value="-">------------------------</option>
                                <? if($this->checkPermissions('edit')) { ?>
                                     <option value="javascript:editCard('<?=$row['id']?>');"><?=L_G_EDIT?></option>
                                <? } ?>

                                <?if($this->checkPermissions('delete')) { ?>
                                     <option value="javascript:deleteCard('<?=$row['id']?>');"><?=L_G_DELETE?></option>
                                <? } ?>
				                <?if($row['active'] == 1) { ?>
                                     <option value="javascript:deactivateCard('<?=$row['id']?>');"><?=L_G_DEACTIVATE?></option>
                                <? }else if($row['active'] == 0) { ?>
                                     <option value="javascript:activateCard('<?=$row['id']?>');"><?=L_G_ACTIVATE?></option>
                                <? } ?>
                            </select>
                        </td>
<?
                        break;

                default:
                        print '<td class=listresult>&nbsp;<font color="#ff0000">'.L_G_UNKNOWN.' '.$column.'</font>&nbsp;</td>';
                        break;
            }
        }
    }
    //--------------------------------------------------------------------------

    function printMassAction()
    {
?>
      <td align=left>&nbsp;&nbsp;&nbsp;<?=L_G_SELECTED;?>&nbsp;
        <select name="massaction">
          <option value=""><?=L_G_CHOOSEACTION?></option>
		<?if($this->checkPermissions('delete')) { ?>
               <option value="delete"><?=L_G_DELETE?></option>
          <? } ?>
        </select>
        &nbsp;&nbsp;
        <input type=submit value="<?=L_G_SUBMITMASSACTION?>">
      </td>
<?
    }

    //--------------------------------------------------------------------------

    function prepareExportFile($orderby, $where)
    {

    }

    function returnEIDs()
    {
        if(isset($_POST['massaction']) && $_POST['massaction'] != '')
        {
            $eIDs = $_POST['itemschecked'];
        }
        else
        {
            $eIDs = array($_REQUEST['cardId']);
        }

        return $eIDs;
    }
}
