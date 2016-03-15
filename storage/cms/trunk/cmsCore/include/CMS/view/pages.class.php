<?php

/**
 * 
 * ClickSuccess, L.P.
 * March 24, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
csCore_Import::importClass('CMS_pages_cmsList');
csCore_Import::importClass('CMS_libs_Pages');
csCore_Import::importClass('CMS_libs_Versions');
csCore_Import::importClass('FCKeditor_FCKeditor');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_libs_SiteComponents');

class CMS_view_pages extends CMS_pages_cmsList {

	/**
	 * Parses incoming variables and executes proper methods
	 * @author Patrick Mizer
	 * @version 1.0
	 */
	function process() {
		if ($_REQUEST['version_active'] != 1)
			$_REQUEST['version_active'] = 0;

		if (!empty($_POST['commited'])) {
			$_POST['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
			$_POST['postaction'] = isset($_REQUEST['postaction']) ? $_REQUEST['postaction'] : '';

			if (!isset($_POST['massaction']))
				$_POST['massaction'] = '';
			switch ($_POST['massaction']) {
				case 'delete':
					if ($this->processDelete())
						return;
					break;
			}


			switch ($_POST['postaction']) {

				case 'update':
					if ($this->processUpdatePage())
						return;

					break;
				case 'createVersion':
					if ($this->processCreateVersion())
						return;
					break;

				case 'create':
					if ($this->processCreatePage())
						return;
					break;
			}
		}
		else if (!empty($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {

				case 'edit':
					$this->loadPageInfo();
					$this->loadDetailInfo();
					if ($this->drawFormEditPage())
						return;
					break;
				case 'create':
					if ($this->drawFormCreatePage())
						return;
					break;
				case 'delete':
					if ($this->processDelete())
						return;
					break;
				case 'activate':
					if ($this->processActivate($_REQUEST['active']))
						return;
					break;
				case 'editVersion':
					if ($this->processSwitchVersion($_REQUEST['version_id'], $_REQUEST['data_from_version']))
						;
					$this->drawFormEditPage();
					return;
					break;
				case 'createVersion':
					if ($this->DrawFormCreateVersion($_REQUEST['eid']))
						;
					return;
					break;
				case 'manageCards':
					$this->redirect("CMS_view_cardToPage&cardpageId=" . $_REQUEST['cardpageId']);
					return;
					break;
				case 'manageMerchantServices':
					$this->redirect("CMS_view_merchantServiceToPage&cardpageId=" . $_REQUEST['cardpageId']);
					return;
					break;
				case 'manageSpecialsCategories':
					$this->redirect("CMS_view_specialsPage&cardpageId=" . $_REQUEST['cardpageId']);
					return;
					break;
				case 'manageProfile':
					$this->redirect("CMS_view_profilePage&cardpageId=" . $_REQUEST['cardpageId']);
					return;
					break;
			}
		}

		$this->showData();
	}

	function getRequiredPermissions() {
		return array('CMS_pages');
	}

	function setSql() {
		$columns = implode(", ", array_keys($this->getColumns()));
		$this->sql = "SELECT " . $columns . " FROM rt_cardpages ";

		$search = $this->filter->getValue('searchPage');

		if ($search != '') {
			$this->where .= ' AND (cardpageId=' . _q($search) . ' OR pageName LIKE ' . _q('%' . $search . '%') . ')';
		}
	}

	function setPaging() {
		$this->paging = 'select count(*) as count FROM rt_cardpages';
	}

	function setFilter() {

		$this->filter->setTitle("Page Filter");

		$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchPage',
			'value' => isset($_REQUEST['searchPage']) ? $_REQUEST['searchPage'] : '',
			'label' => 'Search (by Name or ID): ')));
	}

	function getColumns() {
		// db Column name => array(Label, sortable)
		return array(
			"cardpageId" => array("Page ID", true),
			"pageName" => array("Page Name", true),
			"contentType" => array("Content Type", true),
			"dateCreated" => array("Date Created", true)
		);
	}

	function getKey() {
		return "cardpageId";
	}

	function setSelectActions() {

		$label = "Edit Page";
		$action = "edit";
		$vars = array("cardpageId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Delete Page";
		$action = "delete";
		$vars = array("cardpageId" => $this->getKey());
		$confirm = true;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Manage Cards";
		$action = "manageCards";
		$vars = array("cardpageId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Manage Merchant Services";
		$action = "manageMerchantServices";
		$vars = array("cardpageId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Manage Specials Categories";
		$action = "manageSpecialsCategories";
		$vars = array("cardpageId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Manage Profile";
		$action = "manageProfile";
		$vars = array("cardpageId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
	}

	function setTextActions() {
		$label = "Create New Page";
		$action = "create";
		$vars = array();
		$confirm = true;
		$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
	}

	function processDelete() {
		if (($EIDs = $this->returnIds()) == false)
			return false;

		$sqlEIDs = "('" . implode("','", $EIDs) . "')";

		CMS_libs_Pages::deletePages($sqlEIDs);

		return false;
	}

	function loadPageInfo() {
		$id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);
		$rs = CMS_libs_Pages::getPageById($id);
		//print '<pre>';print_r($rs->fields);print'</pre>';
		$_POST['cardpageId'] = $rs->fields['cardpageId'];
		$_POST['pageName'] = $rs->fields['pageName'];
		$_POST['contentType'] = $rs->fields['contentType'];
		$_POST['pageType'] = $rs->fields['pageType'];
		$_POST['rollup'] = $rs->fields['rollup'];
		$_POST['schumerType'] = $rs->fields['schumerType'];
		$_POST['useChameleon'] = $rs->fields[CHAMELEON_SQL];
		$_POST['active'] = $rs->fields['active'];
		$_POST['active_introApr'] = $rs->fields['active_introApr'];
		$_POST['active_introAprPeriod'] = $rs->fields['active_introAprPeriod'];
		$_POST['active_regularApr'] = $rs->fields['active_regularApr'];
		$_POST['active_annualFee'] = $rs->fields['active_annualFee'];
		$_POST['active_monthlyFee'] = $rs->fields['active_monthlyFee'];
		$_POST['active_balanceTransfers'] = $rs->fields['active_balanceTransfers'];
		$_POST['active_balanceTransferFee'] = $rs->fields['active_balanceTransferFee'];
		$_POST['active_balanceTransferIntroApr'] = $rs->fields['active_balanceTransferIntroApr'];
		$_POST['active_balanceTransferIntroAprPeriod'] = $rs->fields['active_balanceTransferIntroAprPeriod'];
		$_POST['active_creditNeeded'] = $rs->fields['active_creditNeeded'];
		$_POST['active_transactionFeeSignature'] = $rs->fields['active_transactionFeeSignature'];
		$_POST['active_transactionFeePin'] = $rs->fields['active_transactionFeePin'];
		$_POST['active_loadFee'] = $rs->fields['active_loadFee'];
		$_POST['active_activationFee'] = $rs->fields['active_activationFee'];
		$_POST['active_atmFee'] = $rs->fields['active_atmFee'];
		$_POST['active_prepaidText'] = $rs->fields['active_prepaidText'];
	}

	function loadDetailInfo($versionId = -1, $dataVersion = 0) {
		$id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);

		if ($dataVersion == 0)
			$dataVersion = $versionId;

		$rs = CMS_libs_Pages::getPageDetailsByIdAndVersion($id, $dataVersion);

		//The version does not exist yet so load default version data
		if ($rs->EOF) {
			$rs = CMS_libs_Pages::getPageDetailsByIdAndVersion($id, -1);
			$rs->fields['version_active'] = 0;
		}

		if (!$rs || $rs->EOF) {
			_setMessage("SQL Query Error! ", true, __LINE__, __FILE__);
			return false;
		}

		$_POST['pageDescription'] = htmlspecialchars($rs->fields['pageDescription']);
		$_POST['dateInserted'] = htmlspecialchars($rs->fields['dateCreated']);
		$_POST['pageIntroDescription'] = htmlspecialchars($rs->fields['pageIntroDescription']);
		$_POST['pageMeta'] = htmlspecialchars($rs->fields['pageMeta']);
		$_POST['pageTitle'] = htmlspecialchars($rs->fields['pageTitle']);
		$_POST['pageHeaderImage'] = htmlspecialchars($rs->fields['pageHeaderImage']);
		$_POST['pageLearnMore'] = htmlspecialchars($rs->fields['pageLearnMore']);
		$_POST['pageSpecialOfferImageAltText'] = htmlspecialchars($rs->fields['pageSpecialOfferImageAltText']);
		$_POST['pageSpecialOfferImage'] = htmlspecialchars($rs->fields['pageSpecialOfferImage']);
		$_POST['pageSpecialOfferLink'] = htmlspecialchars($rs->fields['pageSpecialOfferLink']);
		$_POST['pageHeaderImageAltText'] = htmlspecialchars($rs->fields['pageHeaderImageAltText']);
		$_POST['pageSmallImage'] = htmlspecialchars($rs->fields['pageSmallImage']);
		$_POST['pageSmallImageAltText'] = htmlspecialchars($rs->fields['pageSmallImageAltText']);
		$_POST['pageDetailVersion'] = htmlspecialchars($rs->fields['pageDetailVersion']);
		$_POST['pageDetailLabel'] = htmlspecialchars($rs->fields['pageDetailLabel']);
		$_POST['fid'] = htmlspecialchars($rs->fields['fid']);
		$_POST['pageLink'] = htmlspecialchars($rs->fields['pageLink']);
		$_POST['pageHeaderString'] = htmlspecialchars($rs->fields['pageHeaderString']);
		$_POST['primaryNavString'] = htmlspecialchars($rs->fields['primaryNavString']);
		$_POST['secondaryNavString'] = htmlspecialchars($rs->fields['secondaryNavString']);
		$_POST['navBarString'] = htmlspecialchars($rs->fields['navBarString']);
		$_POST['landingPage'] = htmlspecialchars($rs->fields['landingPage']);
		$_POST['landingPageFid'] = htmlspecialchars($rs->fields['landingPageFid']);
		$_POST['landingPageHeaderString'] = htmlspecialchars($rs->fields['landingPageHeaderString']);
		$_POST['landingPageImage'] = htmlspecialchars($rs->fields['landingPageImage']);
		$_POST['subPageNav'] = htmlspecialchars($rs->fields['subPageNav']);
		$_POST['flagTopPick'] = htmlspecialchars($rs->fields['flagTopPick']);
		$_POST['flagAdditionalOffer'] = htmlspecialchars($rs->fields['flagAdditionalOffer']);
		$_POST['enableSort'] = htmlspecialchars($rs->fields['enableSort']);
		$_POST['sitemapLink'] = htmlspecialchars($rs->fields['sitemapLink']);
		$_POST['topPickAltText'] = htmlspecialchars($rs->fields['topPickAltText']);
		$_POST['pageDisclaimer'] = htmlspecialchars($rs->fields['pageDisclaimer']);
		$_POST['pageSeeAlso'] = htmlspecialchars($rs->fields['pageSeeAlso']);
		$_POST['siteMapDescription'] = htmlspecialchars($rs->fields['siteMapDescription']);
		$_POST['siteMapTitle'] = htmlspecialchars($rs->fields['siteMapTitle']);
		$_POST['itemsOnFirstPage'] = htmlspecialchars($rs->fields['itemsOnFirstPage']);
		$_POST['showMainCatOnFirstPage'] = htmlspecialchars($rs->fields['showMainCatOnFirstPage']);
		$_POST['itemsPerPage'] = htmlspecialchars($rs->fields['itemsPerPage']);
		$_POST['version_active'] = htmlspecialchars($rs->fields['version_active']);
		//$_POST['prevSubPages'] = $rs->fields['subPages'];
	}

	//***************************************************************
	//***************************************************************

	function processSwitchVersion($version, $dataVersion = 0) {
		$this->loadPageInfo();
		$this->loadDetailInfo($version, $dataVersion);
	}

	function processActivate($value) {
		$id = $_REQUEST[$this->getKey()];
		$sql = "UPDATE rt_cardpages set active = " . _q($value) . " where cardpageId=" . _q($id);
		//echo $sql;
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return false;
	}

	function drawFormCreateVersion($cardpageId) {
		$rs = CMS_libs_Pages:: getUnusedVersions($cardpageId);
		$_POST['pageDetailVersion'] = "<SELECT name='version'>\n";
		while (!$rs->EOF) {
			$_POST['pageDetailVersion'] .= "<option value='" . $rs->fields['siteId'] . "'>" . $rs->fields['siteTitle'] . "</option>\n";
			$rs->MoveNext();
		}
		$_POST['pageDetailVersion'] .= "</SELECT>\n";

		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('pageLearnMore');
		$oFCKeditor->Value = $_POST['pageLearnMore'];
		$oFCKeditor->BasePath = $sBasePath;
		$_POST['editorObject'] = $oFCKeditor;

		$oFCKeditor2 = new FCKeditor_FCKeditor('pageDisclaimer');
		$oFCKeditor2->Value = $_POST['pageDisclaimer'];
		$oFCKeditor2->BasePath = $sBasePath;
		$_POST['editorObject2'] = $oFCKeditor2;

		$oFCKeditor3 = new FCKeditor_FCKeditor('pageSeeAlso');
		$oFCKeditor3->Value = $_POST['pageSeeAlso'];
		$oFCKeditor3->BasePath = $sBasePath;
		$_POST['editorObject3'] = $oFCKeditor3;

		$this->loadPageInfo();

		$_POST['action'] = "createVersion";
		$this->addContent('page_create');


		return true;
	}

	function drawFormEditPage() {
		$pageDAO = new CMS_libs_Pages();

		$_POST['cardpageId'] = $_REQUEST['cardpageId'];


		$rs = CMS_libs_Versions::getVersionsOfPage($_REQUEST['cardpageId']);
		//var_dump($rs);
		$_POST['version_name'] = $rs->fields['version_name'];
		$_POST['selectExisitngVersion'] = "<SELECT name='version_id' id='version_id' OnChange=\"changeVersion(" . $_REQUEST['cardpageId'] . ", 0);\">\n";
		while (!$rs->EOF) {
			//echo $rs->fields['version_name'] . $rs->fields['status'] . "<br/>";
			$selected = "";
			if (isset($_REQUEST['version_id']) && $rs->fields['version_id'] == $_REQUEST['version_id']) {
				$selected = "selected";
				$_POST['version_name'] = $rs->fields['version_name'];
			}
			if ($rs->fields['version_id'] > -2)
				$_POST['selectExisitngVersion'] .= "<option " . $selected .
					" value=\"" . $rs->fields['version_id'] . "\" " .
					" onselect=\"javascript:editVersion(" . $rs->fields['version_id'] .
					", " . $_REQUEST['cardpageId'] . ")\">" .
					( $rs->fields['status'] == "1" ? '* ' : '' ) .
					$rs->fields['version_name'] . "</option>\n";
			$rs->MoveNext();
		}


		$_POST['selectExisitngVersion'] .= "</select>\n";


		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('pageLearnMore');
		$oFCKeditor->Value = $_POST['pageLearnMore'];
		$oFCKeditor->BasePath = $sBasePath;
		$_POST['editorObject'] = $oFCKeditor;

		$oFCKeditor2 = new FCKeditor_FCKeditor('pageDisclaimer');
		$oFCKeditor2->Value = $_POST['pageDisclaimer'];
		$oFCKeditor2->BasePath = $sBasePath;
		$_POST['editorObject2'] = $oFCKeditor2;

		$oFCKeditor3 = new FCKeditor_FCKeditor('pageSeeAlso');
		$oFCKeditor3->Value = $_POST['pageSeeAlso'];
		$oFCKeditor3->BasePath = $sBasePath;
		$_POST['editorObject3'] = $oFCKeditor3;

		$_POST['action'] = "update";
		$_POST['postaction'] = "update";

		if (!isset($_REQUEST['version_id']))
			$_REQUEST['version_id'] = -1;

		$_POST['pages'] = $pageDAO->getAllDistinctPages();

		$rs = CMS_libs_Sites::getSite($_REQUEST['version_id']);
		$site = new site($rs->fields);

		$this->addContent('page_edit');
		return true;
	}

	/**
	 * Prepares and loads variables into the template.
	 * @author Jason Huie
	 * @version 1.3
	 */
	function drawFormCreatePage() {
		$sBasePath = "../cmsCore/include/FCKeditor/";

		$oFCKeditor = new FCKeditor_FCKeditor('pageLearnMore');
		$oFCKeditor->Value = isset($_POST['pageLearnMore']) ? $_POST['pageLearnMore'] : '';
		$oFCKeditor->BasePath = $sBasePath;
		$_POST['editorObject'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('pageDisclaimer');
		$oFCKeditor->Value = isset($_POST['pageDisclaimer']) ? $_POST['pageDisclaimer'] : '';
		$oFCKeditor->BasePath = $sBasePath;
		$_POST['editorObject2'] = $oFCKeditor;

		$oFCKeditor = new FCKeditor_FCKeditor('pageSeeAlso');
		$oFCKeditor->Value = isset($_POST['pageSeeAlso']) ? $_POST['pageSeeAlso'] : '';
		$oFCKeditor->BasePath = $sBasePath;
		$_POST['editorObject3'] = $oFCKeditor;

		$_POST['action'] = "create";
		$_POST['postaction'] = "create";
		$this->addContent('page_create');
		return true;
	}

	//--------------------------------------------------------------------------        

	function processUpdatePage() {

		if ($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		if (!$_REQUEST['itemsOnFirstPage'] || trim(strtolower($_REQUEST['itemsOnFirstPage'])) == 'all')
			$_REQUEST['itemsOnFirstPage'] = 99999;
		if (!$_REQUEST['itemsPerPage'] || trim(strtolower($_REQUEST['itemsPerPage'])) == 'all')
			$_REQUEST['itemsPerPage'] = 99999;

		$params = array(
			'pageName' => $_REQUEST['pageName'],
			'active' => $_REQUEST['active'],
			'pageType' => $_REQUEST['pageType'],
			'rollup' => $_REQUEST['rollup'],
			'contentType' => $_REQUEST['contentType'],
			'active_introApr' => isset($_REQUEST['active_introApr']) ? 1 : 0,
			'active_introAprPeriod' => isset($_REQUEST['active_introAprPeriod']) ? 1 : 0,
			'active_regularApr' => isset($_REQUEST['active_regularApr']) ? 1 : 0,
			'active_annualFee' => isset($_REQUEST['active_annualFee']) ? 1 : 0,
			'active_monthlyFee' => isset($_REQUEST['active_monthlyFee']) ? 1 : 0,
			'active_balanceTransfers' => isset($_REQUEST['active_balanceTransfers']) ? 1 : 0,
			'active_balanceTransferFee' => isset($_REQUEST['active_balanceTransferFee']) ? 1 : 0,
			'active_balanceTransferIntroApr' => isset($_REQUEST['active_balanceTransferIntroApr']) ? 1 : 0,
			'active_balanceTransferIntroAprPeriod' => isset($_REQUEST['active_balanceTransferIntroAprPeriod']) ? 1 : 0,
			'active_creditNeeded' => isset($_REQUEST['active_creditNeeded']) ? 1 : 0,
			'active_transactionFeeSignature' => isset($_REQUEST['active_transactionFeeSignature']) ? 1 : 0,
			'active_transactionFeePin' => isset($_REQUEST['active_transactionFeePin']) ? 1 : 0,
			'active_loadFee' => isset($_REQUEST['active_loadFee']) ? 1 : 0,
			'active_activationFee' => isset($_REQUEST['active_activationFee']) ? 1 : 0,
			'active_atmFee' => isset($_REQUEST['active_atmFee']) ? 1 : 0,
			'active_prepaidText' => isset($_REQUEST['active_prepaidText']) ? 1 : 0,
			'schumerType' => $_REQUEST['schumerType'],
			CHAMELEON_SQL => isset($_REQUEST['useChameleon']) ? 1 : 0
		);

		// save changes of user to db
		CMS_libs_Pages::updatePage($_REQUEST[$this->getKey()], $params);

		$rs = CMS_libs_Pages::getVersionByPageAndId($_REQUEST[$this->getKey()], $_REQUEST['version_id']);
		if ($rs->EOF) {
			//No version exists, create a new one
			$this->createNewVersion();
		} else {
			//Update existing version
			$label = "";
			$label = CMS_libs_Versions::getVersionName($_REQUEST['version_id']);
			//echo $label;
			$temp = explode(".", $_REQUEST['pageLink']);
			if (is_array($temp)) {
				$_REQUEST['pageLink'] = $temp[0];
			}

			$params = array(
				'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
				'pageDescription' => $_REQUEST['pageDescription'],
				'pageMeta' => $_REQUEST['pageMeta'],
				'pageTitle' => $_REQUEST['pageTitle'],
				'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
				'pageLearnMore' => isset($_REQUEST['pageLearnMore']) ? $_REQUEST['pageLearnMore'] : '',
				'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
				'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
				'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],
				'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
				'pageSmallImage' => $_REQUEST['pageSmallImage'],
				'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
				'pageDetailVersion' => $_REQUEST['version_id'],
				'pageDetailLabel' => $label,
				'fid' => $_REQUEST['fid'],
				'pageLink' => $_REQUEST['pageLink'],
				'pageHeaderString' => $_REQUEST['pageHeaderString'],
				'primaryNavString' => $_REQUEST['primaryNavString'],
				'secondaryNavString' => $_REQUEST['secondaryNavString'],
				'navBarString' => $_REQUEST['navBarString'],
				'landingPage' => isset($_REQUEST['landingPage']) ? $_REQUEST['landingPage'] : 0,
				'landingPageFid' => $_REQUEST['landingPageFid'],
				'landingPageHeaderString' => $_REQUEST['landingPageHeaderString'],
				'landingPageImage' => $_REQUEST['landingPageImage'],
				'subPageNav' => $_REQUEST['subPageNav'],
				'flagTopPick' => $_REQUEST['flagTopPick'],
				'flagAdditionalOffer' => $_REQUEST['flagAdditionalOffer'],
				'enableSort' => isset($_REQUEST['enableSort']) ? $_REQUEST['enableSort'] : 0,
				'sitemapLink' => $_REQUEST['sitemapLink'],
				'topPickAltText' => $_REQUEST['topPickAltText'],
				'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
				'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
				'siteMapTitle' => $_REQUEST['siteMapTitle'],
				'siteMapDescription' => $_REQUEST['siteMapDescription'],
				'itemsOnFirstPage' => $_REQUEST['itemsOnFirstPage'],
				'showMainCatOnFirstPage' => isset($_REQUEST['showMainCatOnFirstPage']) ? $_REQUEST['showMainCatOnFirstPage'] : 0,
				'itemsPerPage' => $_REQUEST['itemsPerPage'],
				'active' => $_REQUEST['version_active'],
			);

			//print'<pre>';print_r($params);print'</pre>';

			CMS_libs_Pages::updateVersion($_REQUEST[$this->getKey()], $params);
			_setMessage("Page Successfully Updated");
		}

		return false;
	}

	function createNewVersion() {

		$label = CMS_libs_Versions::getVersionName($_REQUEST['version_id']);

		$params = array(
			'cardPageId' => $_REQUEST[$this->getKey()],
			'pageDescription' => $_REQUEST['pageDescription'],
			'pageDetailVersion' => $_REQUEST['version_id'],
			'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
			'pageDescription' => $_REQUEST['pageDescription'],
			'pageMeta' => $_REQUEST['pageMeta'],
			'pageTitle' => $_REQUEST['pageTitle'],
			'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
			'pageLearnMore' => $_REQUEST['pageLearnMore'],
			'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
			'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
			'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],
			'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
			'pageSmallImage' => $_REQUEST['pageSmallImage'],
			'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
			'fid' => $_REQUEST['fid'],
			'pageLink' => $_REQUEST['pageLink'],
			'pageHeaderString' => $_REQUEST['pageHeaderString'],
			'primaryNavString' => $_REQUEST['primaryNavString'],
			'secondaryNavString' => $_REQUEST['secondaryNavString'],
			'navBarString' => $_REQUEST['navBarString'],
			'landingPage' => $_REQUEST['landingPage'],
			'landingPageFid' => $_REQUEST['landingPageFid'],
			'landingPageImage' => $_REQUEST['landingPageImage'],
			'landingPageHeaderString' => $_REQUEST['landingPageHeaderString'],
			'subPageNav' => $_REQUEST['subPageNav'],
			'flagTopPick' => $_REQUEST['flagTopPick'],
			'flagAdditionalOffer' => $_REQUEST['flagAdditionalOffer'],
			'topPickAltText' => $_REQUEST['topPickAltText'],
			'enableSort' => $_REQUEST['enableSort'],
			'sitemapLink' => $_REQUEST['sitemapLink'],
			'pageDetailLabel' => $label,
			'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
			'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
			'siteMapTitle' => $_REQUEST['siteMapTitle'],
			'siteMapDescription' => $_REQUEST['siteMapDescription'],
			'itemsOnFirstPage' => $_REQUEST['itemsOnFirstPage'],
			'showMainCatOnFirstPage' => $_REQUEST['showMainCatOnFirstPage'],
			'itemsPerPage' => $_REQUEST['itemsPerPage'],
			'active' => $_REQUEST['version_active'],
		);

		CMS_libs_Pages::addVersion($params);
	}

	function processCreatePage() {
		if ($_REQUEST['active'] != 1) {
			$_REQUEST['active'] = 0;
		}

		if (!$_REQUEST['itemsOnFirstPage'] || trim(strtolower($_REQUEST['itemsOnFirstPage'])) == 'all') {
			$_REQUEST['itemsOnFirstPage'] = 99999;
		}
		if (!$_REQUEST['itemsPerPage'] || trim(strtolower($_REQUEST['itemsPerPage'])) == 'all') {
			$_REQUEST['itemsPerPage'] = 99999;
		}
		if ($_REQUEST['showMainCatOnFirstPage'] != 1) {
			$_REQUEST['showMainCatOnFirstPage'] = 0;
		}

		$params = array(
			'pageName' => $_REQUEST['pageName'],
			'active' => $_REQUEST['active'],
			'type' => $_REQUEST['type'],
			'pageType' => $_REQUEST['pageType'],
			'rollup' => $_REQUEST['rollup'],
			'contentType' => $_REQUEST['contentType'],
			'active_introApr' => $_REQUEST['active_introApr'],
			'active_introAprPeriod' => $_REQUEST['active_introAprPeriod'],
			'active_regularApr' => $_REQUEST['active_regularApr'],
			'active_annualFee' => $_REQUEST['active_annualFee'],
			'active_monthlyFee' => $_REQUEST['active_monthlyFee'],
			'active_balanceTransfers' => $_REQUEST['active_balanceTransfers'],
			'active_balanceTransferFee' => $_REQUEST['active_balanceTransferFee'],
			'active_balanceTransferIntroApr' => $_REQUEST['active_balanceTransferIntroApr'],
			'active_balanceTransferIntroAprPeriod' => $_REQUEST['active_balanceTransferIntroAprPeriod'],
			'active_creditNeeded' => $_REQUEST['active_creditNeeded'],
			'active_transactionFeeSignature' => $_REQUEST['active_transactionFeeSignature'],
			'active_transactionFeePin' => $_REQUEST['active_transactionFeePin'],
			'active_loadFee' => $_REQUEST['active_loadFee'],
			'active_activationFee' => $_REQUEST['active_activationFee'],
			'active_atmFee' => $_REQUEST['active_atmFee'],
			'active_prepaidText' => $_REQUEST['active_prepaidText'],
			'schumerType' => $_REQUEST['schumerType'],
			CHAMELEON_SQL => $_REQUEST['useChameleon'] ? 1 : 0
		);

		$pageid = CMS_libs_Pages::addPage($params);

		$temp = explode(".", $_REQUEST['pageLink']);

		if (is_array($temp)) {
			$_REQUEST['pageLink'] = $temp[0];
		}

		$params = array(
			'cardPageId' => $pageid,
			'pageDescription' => $_REQUEST['pageDescription'],
			'pageDetailVersion' => $_REQUEST['version_id'],
			'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
			'pageDescription' => $_REQUEST['pageDescription'],
			'pageMeta' => $_REQUEST['pageMeta'],
			'pageTitle' => $_REQUEST['pageTitle'],
			'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
			'pageLearnMore' => $_REQUEST['pageLearnMore'],
			'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
			'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
			'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],
			'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
			'pageSmallImage' => $_REQUEST['pageSmallImage'],
			'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
			'fid' => $_REQUEST['fid'],
			'pageLink' => $_REQUEST['pageLink'],
			'pageHeaderString' => $_REQUEST['pageHeaderString'],
			'primaryNavString' => $_REQUEST['primaryNavString'],
			'secondaryNavString' => $_REQUEST['secondaryNavString'],
			'navBarString' => $_REQUEST['navBarString'],
			'landingPage' => $_REQUEST['landingPage'],
			'landingPageFid' => $_REQUEST['landingPageFid'],
			'landingPageImage' => $_REQUEST['landingPageImage'],
			'landingPageHeaderString' => $_REQUEST['landingPageHeaderString'],
			'subPageNav' => $_REQUEST['subPageNav'],
			'flagTopPick' => $_REQUEST['flagTopPick'],
			'flagAdditionalOffer' => $_REQUEST['flagAdditionalOffer'],
			'topPickAltText' => $_REQUEST['topPickAltText'],
			'enableSort' => $_REQUEST['enableSort'],
			'sitemapLink' => $_REQUEST['sitemapLink'],
			'pageDetailLabel' => "Default",
			'pageDetailVersion' => -1,
			'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
			'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
			'siteMapTitle' => $_REQUEST['siteMapTitle'],
			'siteMapDescription' => $_REQUEST['siteMapDescription'],
			'itemsOnFirstPage' => $_REQUEST['itemsOnFirstPage'],
			'showMainCatOnFirstPage' => $_REQUEST['showMainCatOnFirstPage'],
			'itemsPerPage' => $_REQUEST['itemsPerPage'],
			'active' => 1,
		);

		CMS_libs_Pages::addVersion($params);

		_setMessage("Page Successfully Created");

		return false;
	}

	function processCreateVersion() {
		$label = CMS_libs_Versions::getVersionName($_REQUEST['version_id']);

		$temp = explode(".", $_REQUEST['pageLink']);
		if (is_array($temp)) {
			$_REQUEST['pageLink'] = $temp[0];
		}

		$params = array(
			'cardPageId' => $_REQUEST[$this->getKey()],
			'pageDetailVersion' => $_REQUEST['version_id'],
			'pageIntroDescription' => $_REQUEST['pageIntroDescription'],
			'pageDescription' => $_REQUEST['pageDescription'],
			'pageMeta' => $_REQUEST['pageMeta'],
			'pageTitle' => $_REQUEST['pageTitle'],
			'pageHeaderImage' => $_REQUEST['pageHeaderImage'],
			'pageLearnMore' => $_REQUEST['pageLearnMore'],
			'pageSpecialOfferImageAltText' => $_REQUEST['pageSpecialOfferImageAltText'],
			'pageSpecialOfferImage' => $_REQUEST['pageSpecialOfferImage'],
			'pageSpecialOfferLink' => $_REQUEST['pageSpecialOfferLink'],
			'pageHeaderImageAltText' => $_REQUEST['pageHeaderImageAltText'],
			'pageSmallImage' => $_REQUEST['pageSmallImage'],
			'pageSmallImageAltText' => $_REQUEST['pageSmallImageAltText'],
			'pageDetailLabel' => $label,
			'fid' => $_REQUEST['fid'],
			'pageLink' => $_REQUEST['pageLink'],
			'pageHeaderString' => $_REQUEST['pageHeaderString'],
			'primaryNavString' => $_REQUEST['primaryNavString'],
			'secondaryNavString' => $_REQUEST['secondaryNavString'],
			'navBarString' => $_REQUEST['navBarString'],
			'subPageNav' => $_REQUEST['subPageNav'],
			'flagTopPick' => $_REQUEST['flagTopPick'],
			'flagAdditionalOffer' => $_REQUEST['flagAdditionalOffer'],
			'enableSort' => $_REQUEST['enableSort'],
			'sitemapLink' => $_REQUEST['sitemapLink'],
			'topPickAltText' => $_REQUEST['topPickAltText'],
			'pageDisclaimer' => $_REQUEST['pageDisclaimer'],
			'pageSeeAlso' => $_REQUEST['pageSeeAlso'],
			'siteMapTitle' => $_REQUEST['siteMapTitle'],
			'siteMapDescription' => $_REQUEST['siteMapDescription'],
			'itemsOnFirstPage' => $_REQUEST['itemsOnFirstPage'],
			'showMainCatOnFirstPage' => $_REQUEST['showMainCatOnFirstPage'],
			'itemsPerPage' => $_REQUEST['itemsPerPage'],
			'active' => $_REQUEST['version_active'],
		);

		CMS_libs_Pages::addVersion($params);

		_setMessage("Version Successfully Created");

		return false;
	}

}

?>