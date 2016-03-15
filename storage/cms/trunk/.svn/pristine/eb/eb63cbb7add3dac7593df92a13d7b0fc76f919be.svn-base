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
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_libs_Cards');
csCore_Import::importClass('CMS_libs_Versions');

class CMS_view_sites extends CMS_pages_cmsList {

	//redefine where clause so version_name join works
	var $where = " WHERE rt_sites.deleted != 1";

	function process() {
		if (!empty($_REQUEST['commited'])) {
			switch ($_REQUEST['postaction']) {
				case 'update':

					$this->processUpdateSite();

					break;

				case 'create':
					if ($this->processCreateSite())
						return;
					break;
			}
		}
		if (!empty($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {

				case 'edit':
					$this->loadSiteInfo();
					if ($this->drawFormEditSite())
						return;
					break;
				case 'create':
					if ($this->drawFormCreateSite())
						return;
					break;
				case 'build':
					if ($this->processBuild())
						return;
					break;
				case 'export':
					if ($this->processExport())
						return;
					break;
				case 'publish':
					if ($this->processPublish())
						return;
					break;
				case 'export':
					if ($this->processExport())
						return;
					break;
				case 'delete':
					if ($this->processDelete())
						return;
					break;
				case 'up':
					if ($this->processUp())
						return;
					break;
				case 'down':
					if ($this->processDown())
						return;
					break;
				case 'activate':
					if ($this->processActivate($_REQUEST['active']))
						return;
					break;
				case 'managePages':
					$this->redirect("CMS_view_siteToPage&siteId=" . $_REQUEST['siteId']);
					return;
					break;
			}
		}
		$this->showData();
	}

	function getRequiredPermissions() {
		return array('CMS_sites');
	}

	function setSql() {
		$columns = implode(", ", array_keys($this->getColumns()));
		$this->sql = "SELECT " . $columns . " FROM rt_sites " .
			"LEFT JOIN versions as v ON rt_sites.version_id = v.version_id ";

		$search = $this->filter->getValue('searchSite');

		if ($search != '') {
			$this->where .= ' AND (siteId=' . _q($search) . ' OR siteName LIKE ' . _q('%' . $search . '%') . ')';
		}

		//echo $this->sql;
	}

	function setPaging() {
		$this->paging = 'select count(*) as count FROM rt_sites';
	}

	function setFilter() {

		$this->filter->setTitle("Site Filter");

		$this->filter->addItem(new csCore_UI_formText(array('name' => 'searchSite',
			'value' => isset($_REQUEST['searchSite']) ? $_REQUEST['searchSite'] : '',
			'label' => 'Search (by Name or ID): ')));
	}

	function getColumns() {
		// db Column name => array(Label, sortable)
		return array(
			"siteId" => array("Site ID", true),
			"siteName" => array("Site Name", true),
			"siteTitle" => array("Site Title", true),
			"version_name" => array("Version", true),
			"layout" => array("Layout File", true),
			"ftpSite" => array("FTP Site", true),
			"ftpPath" => array("FTP Path", true),
			"publishScript" => array("Publish Script", true),
			"publishPath" => array("Publish Path", true),
			"sourcePath" => array("Source Path", true),
			"hostName" => array("Host Name", true),
			"dateCreated" => array("Date Created", true),
			"publishPath" => array("Publish Path", true),
			"sourcePath" => array("Source Path", true),
		);
	}

	function getKey() {
		return "siteId";
	}

	function setSelectActions() {

		$label = "Edit Site";
		$action = "edit";
		$vars = array("siteId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Delete Site";
		$action = "delete";
		$vars = array("siteId" => $this->getKey());
		$confirm = true;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);

		$label = "Manage Pages";
		$action = "managePages";
		$vars = array("siteId" => $this->getKey());
		$confirm = false;
		$this->selectActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
	}

	function setTextActions() {
		$label = "Create New Site";
		$action = "create";
		$vars = array();
		$confirm = true;
		$this->textActions[] = new csCore_UI_action($label, $action, $vars, $confirm);
	}

	function processDelete() {
		if (($EIDs = $this->returnIds()) == false)
			return false;

		$sqlEIDs = "('" . implode("','", $EIDs) . "')";

		CMS_libs_Sites::deleteSites($sqlEIDs);

		return false;
	}

	function loadSiteInfo() {
		$id = preg_replace('/[\'\"]/', '', $_REQUEST[$this->getKey()]);
		$rs = CMS_libs_Sites::getSite($id, -1);

		if (!$rs || $rs->EOF) {
			_setMessage("Query Failed", true);
			return false;
		}

		$_POST['order'] = $rs->fields['order'];
		$_POST['siteId'] = $rs->fields['siteId'];
		$_POST['siteName'] = $rs->fields['siteName'];
		$_POST['siteTitle'] = $rs->fields['siteTitle'];
		$_POST['siteDescription'] = $rs->fields['siteDescription'];
		$_POST['language'] = $rs->fields['language'];
		$_POST['layout'] = $rs->fields['layout'];
		$_POST['publishPath'] = $rs->fields['publishPath'];
		$_POST['sourcePath'] = $rs->fields['sourcePath'];
		$_POST['corePath'] = $rs->fields['corePath'];
		$_POST['hostname'] = $rs->fields['hostname'];
		$_POST['dateCreated'] = $rs->fields['dateCreated'];
		$_POST['dateUpdated'] = $rs->fields['dateUpdated'];
		$_POST['active'] = $rs->fields['active'];
		$_POST['ftpSite'] = $rs->fields['ftpSite'];
		$_POST['ftpPath'] = $rs->fields['ftpPath'];
		$_POST['applyLogo'] = $rs->fields['applyLogo'];
		$_POST['publishScript'] = $rs->fields['publishScript'];
		$_POST['postBuildScript'] = $rs->fields['postBuildScript'];
		$_POST['dbname'] = $rs->fields['dbname'];
		$_POST['dblocation'] = $rs->fields['dblocation'];
		$_POST['dbun'] = $rs->fields['dbun'];
		$_POST['dbpw'] = $rs->fields['dbpw'];
		$_POST['sitemap'] = $rs->fields['sitemap'];
		$_POST['publishurl'] = $rs->fields['publishurl'];
		$_POST['pagetype'] = $rs->fields['pagetype'];
		$_POST['individualcards'] = $rs->fields['individualcards'];
		$_POST['individualcarddir'] = $rs->fields['individualcarddir'];
		$_POST['alternativecardpages'] = $rs->fields['alternativecardpages'];
		$_POST['alternativecardpagesdir'] = $rs->fields['alternativecardpagesdir'];
		$_POST['individualmerchantservices'] = $rs->fields['individualmerchantservices'];
		$_POST['individualmerchantservicesdir'] = $rs->fields['individualmerchantservicesdir'];
		$_POST['createSeoDoc'] = $rs->fields['createSeoDoc'];
		$_POST['landingPageDir'] = $rs->fields['landingPageDir'];
		$_POST['ccbuildPublish'] = $rs->fields['ccbuildPublish'];
		$_POST['sitemaplink'] = $rs->fields['sitemaplink'];
		$_POST['articleSiteMapFile'] = $rs->fields['articleSiteMapFile'];
		$_POST['googleArticleFile'] = $rs->fields['googleArticleFile'];
		$_POST['yahooArticleFile'] = $rs->fields['yahooArticleFile'];
		$_POST['yahooArticleCategoryFile'] = $rs->fields['yahooArticleCategoryFile'];
		$_POST['version_id'] = $rs->fields['version_id'];

		$_POST['version_name'] = CMS_libs_Versions::getVersionName($rs->fields['version_id']);
	}

	function processUpdateSite() {

		if ($_REQUEST['active'] != 1)
			$_REQUEST['active'] = 0;

		$_REQUEST['siteTitle'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteTitle']);
		$_REQUEST['siteName'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteName']);
		$_REQUEST['language'] = preg_replace('/[\'\"]/', '', $_REQUEST['language']);
		$_REQUEST['layout'] = preg_replace('/[\'\"]/', '', $_REQUEST['layout']);
		$_REQUEST['publishPath'] = preg_replace('/[\'\"]/', '', $_REQUEST['publishPath']);
		$_REQUEST['hostname'] = preg_replace('/[\'\"]/', '', $_REQUEST['hostname']);
		$_REQUEST['siteDescription'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteDescription']);
		$_REQUEST['applyLogo'] = preg_replace('/[\'\"]/', '', isset($_REQUEST['applyLogo']) ? $_REQUEST['applyLogo'] : '');
		$_REQUEST['ftpSite'] = preg_replace('/[\'\"]/', '', $_REQUEST['ftpSite']);
		$_REQUEST['ftpPath'] = preg_replace('/[\'\"]/', '', $_REQUEST['ftpPath']);

		$params = array(
			'siteName' => $_REQUEST['siteName'],
			'siteDescription' => $_REQUEST['siteDescription'],
			'language' => $_REQUEST['language'],
			'layout' => $_REQUEST['layout'],
			'publishPath' => $_REQUEST['publishPath'],
			'sourcePath' => $_REQUEST['sourcePath'],
			'corePath' => $_REQUEST['corePath'],
			'active' => $_REQUEST['active'],
			'siteTitle' => $_REQUEST['siteTitle'],
			'hostname' => $_REQUEST['hostname'],
			'ftpSite' => $_REQUEST['ftpSite'],
			'ftpPath' => $_REQUEST['ftpPath'],
			'applyLogo' => $_REQUEST['applyLogo'],
			'publishScript' => $_REQUEST['publishScript'],
			'postBuildScript' => $_REQUEST['postBuildScript'],
			'dbname' => $_REQUEST['dbname'],
			'dblocation' => $_REQUEST['dblocation'],
			'dbun' => $_REQUEST['dbun'],
			'dbpw' => $_REQUEST['dbpw'],
			'sitemap' => isset($_REQUEST['sitemap']) ? $_REQUEST['sitemap'] : 0,
			'publishurl' => $_REQUEST['publishurl'],
			'pagetype' => $_REQUEST['pagetype'],
			'individualcards' => $_REQUEST['individualcards'],
			'individualcarddir' => $_REQUEST['individualcarddir'],
			'alternativecardpages' => $_REQUEST['alternativecardpages'],
			'alternativecardpagesdir' => $_REQUEST['alternativecardpagesdir'],
			'individualmerchantservices' => $_REQUEST['individualmerchantservices'],
			'individualmerchantservicesdir' => $_REQUEST['individualmerchantservicesdir'],
			'createSeoDoc' => isset($_REQUEST['createSeoDoc']) ? $_REQUEST['createSeoDoc'] : 0,
			'landingPageDir' => $_REQUEST['landingPageDir'],
			'ccbuildPublish' => isset($_REQUEST['ccbuildPublish']) ? $_REQUEST['ccbuildPublish'] : '',
			'sitemaplink' => $_REQUEST['sitemaplink'],
			'articleSiteMapFile' => $_REQUEST['articleSiteMapFile'],
			'googleArticleFile' => $_REQUEST['googleArticleFile'],
			'yahooArticleFile' => $_REQUEST['yahooArticleFile'],
			'yahooArticleCategoryFile' => $_REQUEST['yahooArticleCategoryFile'],
			'version_id' => $_REQUEST['version_id'],
		);

		CMS_libs_Sites::updateSite($_REQUEST[$this->getKey()], $params);

		if (!is_array($_REQUEST['recentlyAssignedCards'])) {
			$_REQUEST['recentlyAssignedCards'] = array();
		}
		if (!is_array($_REQUEST['unassignedCards'])) {
			$_REQUEST['unassignedCards'] = array();
		}
		CMS_libs_Sites::assignCards($_REQUEST['siteId'], $_REQUEST['recentlyAssignedCards']);
		CMS_libs_Sites::removeCards($_REQUEST['siteId'], $_REQUEST['unassignedCards']);

		if (!is_array($_REQUEST['excluded'])) {
			$_REQUEST['excluded'] = array();
		}
		if (!is_array($_REQUEST['nonExcluded'])) {
			$_REQUEST['nonExcluded'] = array();
		}
		CMS_libs_Sites::assignExcludes($_REQUEST['siteId'], $_REQUEST['excluded']);
		CMS_libs_Sites::removeExcludes($_REQUEST['siteId'], $_REQUEST['nonExcluded']);

		_setMessage("Site Successfully Updated");

		return false;
	}

	//***************************************************************
	//***************************************************************


	function processBuild() {
		$id = $_REQUEST['eid'];
		$constr = "crm_layouts_" . $_REQUEST['layout'];
		$build = new $constr($id);

		if (!$build->_preBuildSanityCheck()) {
			QUnit_Messager::setErrorMessage("Build Aborted");
			return false;
		}

		$build->_buildSite();
	}

	function processPublish() {
		$ftp = new Affiliate_CMS_Bl_FTP("68.178.211.39");
		if ($ftp->connect("pmizer", "R00t2004")) {
			$ftp->upload("/home/patrickm/foo", true);
			$ftp->disconnect();
		}
		echo $ftp->consoleOut();
	}

	function processExport() {
		$id = $_REQUEST['eid'];
		$constr = "crm_layouts_" . $_REQUEST['layout'];
		$build = new $constr($id);


		$xmlBuilder = new Affiliate_CMS_Bl_XMLBuild($id, $build->categories);
		$xmlBuilder->exportToXML();

		//$sql = "SELECT g.userid FROM wd_g_users as g, wd_pa_affiliatescampaigns as ac, wd_pa_campaigns as c WHERE " .
		//" (c.wrapper = 1) AND (ac.campaignid = c.campaignid) AND (ac.affiliateid = g.userid)";
		//$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		//while(!$rs->EOF){
		//	$xmlBuilder->exportToXML($rs->fields['userid']);
		//}
		// Hack for now
		$userarray = array("123456");
		foreach ($userarray as $userid) {
			$xmlBuilder = new Affiliate_CMS_Bl_XMLBuild($id, $build->categories);
			$xmlBuilder->exportToXML($userid);
		}
	}

	function processActivate($value) {
		$id = $_REQUEST['eid'];
		$sql = "UPDATE rt_sites set active = " . _q($value) . " where siteId=" . _q($id);
		$rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);
		return false;
	}

	function drawFormEditSite() {

		$this->tpl->versions = CMS_libs_Versions::getAllVersions();

		$fiveDaysAgo = date('Y') . '-' . date('m') . '-' . (date('d') - 5);
		$recentlyAssignedCards = CMS_libs_Sites::getCardsBySiteIdAndDate($_POST['siteId'], $fiveDaysAgo);
		$this->assignValue('recentlyAssignedCards', $recentlyAssignedCards);

		$assignedCards = CMS_libs_Sites::getCardsBySiteId($_POST['siteId']);
		$this->assignValue('assignedCards', $assignedCards);

		$unassignedCards = CMS_libs_Sites::getUnAssignedCardsBySiteId($_POST['siteId']);
		$this->assignValue('unassignedCards', $unassignedCards);

		$excluded = CMS_libs_Sites::getExcludedCards($_POST['siteId']);
		$this->assignValue('excluded', $excluded);

		$nonExcluded = CMS_libs_Sites::getNonExcludedCards($_POST['siteId']);
		$this->assignValue('nonExcluded', $nonExcluded);

		$this->addContent('site_edit');
		return true;
	}

	function drawFormCreateSite() {

		$this->tpl->versions = CMS_libs_Versions::getAllVersions();

		$cards = CMS_libs_Cards::getAllCards();
		$this->assignValue('unassignedCards', $cards);
		$this->assignValue('nonExcluded', $cards);

		$this->addContent('site_create');
		return true;
	}

	//--------------------------------------------------------------------------        



	function processCreateSite() {

		if ($_REQUEST['active'] != 1) {
			$_REQUEST['active'] = 0;
		}

		$_REQUEST['siteTitle'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteTitle']);
		$_REQUEST['siteName'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteName']);
		$_REQUEST['language'] = preg_replace('/[\'\"]/', '', $_REQUEST['language']);
		$_REQUEST['layout'] = preg_replace('/[\'\"]/', '', $_REQUEST['layout']);
		$_REQUEST['publishPath'] = preg_replace('/[\'\"]/', '', $_REQUEST['publishPath']);
		$_REQUEST['hostname'] = preg_replace('/[\'\"]/', '', $_REQUEST['hostname']);
		$_REQUEST['siteDescription'] = preg_replace('/[\'\"]/', '', $_REQUEST['siteDescription']);
		$_REQUEST['applyLogo'] = preg_replace('/[\'\"]/', '', $_REQUEST['applyLogo']);
		$_REQUEST['ftpSite'] = preg_replace('/[\'\"]/', '', $_REQUEST['ftpSite']);
		$_REQUEST['ftpPath'] = preg_replace('/[\'\"]/', '', $_REQUEST['ftpPath']);


		//checkCorrectness($_REQUEST['siteName'], $_REQUEST['siteName'], L_G_SITENAME, CHECK_EMPTYALLOWED);	
		//checkCorrectness($_REQUEST['siteTitle'], $_REQUEST['siteTitle'], L_G_SITETITLE, CHECK_EMPTYALLOWED);	
		//checkCorrectness($_REQUEST['layout'], $_REQUEST['layout'], L_G_LAYOUT, CHECK_EMPTYALLOWED);	
		//checkCorrectness($_REQUEST['publishPath'], $_REQUEST['publishPath'], L_G_SITETITLE, CHECK_EMPTYALLOWED);		
		//checkCorrectness($_REQUEST['hostname'], $_REQUEST['hostname'], L_G_HOSTNAME, CHECK_EMPTYALLOWED);	
		//checkCorrectness($_REQUEST['applyLogo'], $_REQUEST['applyLogo'], L_G_APPLYLOGO, CHECK_EMPTYALLOWED);	
		//checkCorrectness($_REQUEST['ftpSite'], $_REQUEST['ftpSite'], L_G_FTPSITE, CHECK_EMPTYALLOWED);	

		$params = array(
			'siteTitle' => $_REQUEST['siteTitle'],
			'siteName' => $_REQUEST['siteName'],
			'language' => $_REQUEST['language'],
			'layout' => $_REQUEST['layout'],
			'publishPath' => $_REQUEST['publishPath'],
			'sourcePath' => $_REQUEST['sourcePath'],
			'corePath' => $_REQUEST['corePath'],
			'hostname' => $_REQUEST['hostname'],
			'active' => $_REQUEST['active'],
			'siteDescription' => $_REQUEST['siteDescription'],
			'applyLogo' => $_REQUEST['applyLogo'],
			'ftpSite' => $_REQUEST['ftpSite'],
			'ftpPath' => $_REQUEST['ftpPath'],
			'publishScript' => $_REQUEST['publishScript'],
			'postBuildScript' => $_REQUEST['postBuildScript'],
			'dbname' => $_REQUEST['dbname'],
			'dblocation' => $_REQUEST['dblocation'],
			'dbun' => $_REQUEST['dbun'],
			'dbpw' => $_REQUEST['dbpw'],
			'sitemap' => $_REQUEST['sitemap'],
			'publishurl' => $_REQUEST['publishurl'],
			'pagetype' => $_REQUEST['pagetype'],
			'individualcards' => $_REQUEST['individualcards'],
			'individualcarddir' => $_REQUEST['individualcarddir'],
			'alternativecardpages' => $_REQUEST['alternativecardpages'],
			'alternativecardpagesdir' => $_REQUEST['alternativecardpagesdir'],
			'individualmerchantservices' => $_REQUEST['individualmerchantservices'],
			'individualmerchantservicesdir' => $_REQUEST['individualmerchantservicesdir'],
			'createSeoDoc' => $_REQUEST['createSeoDoc'],
			'landingPageDir' => $_REQUEST['landingPageDir'],
			'ccbuildPublish' => $_REQUEST['ccbuildPublish'],
			'sitemaplink' => $_REQUEST['sitemaplink'],
			'articleSiteMapFile' => $_REQUEST['articleSiteMapFile'],
			'googleArticleFile' => $_REQUEST['googleArticleFile'],
			'yahooArticleFile' => $_REQUEST['yahooArticleFile'],
			'yahooArticleCategoryFile' => $_REQUEST['yahooArticleCategoryFile'],
			'version_id' => $_REQUEST['version_id'],
		);


		// save changes of user to db
		$siteId = CMS_libs_Sites::addSite($params);

		CMS_libs_Sites::assignCards($siteId, $_REQUEST['assignedCards']);
		CMS_libs_Sites::assignExcludes($siteId, $_REQUEST['excluded']);

		_setMEssage("Site Successfully Created");

		return false;
	}

	/**
	  function processDelete()
	  {
	  if(($EIDs = $this->returnEIDs()) == false)
	  return false;

	  $sqlEIDs = "('" . implode("','", $EIDs) . "')";

	  Affiliate_CMS_Bl_Sites::deleteSites($sqlEIDs);

	  return false;
	  }
	 * */
	//--------------------------------------------------------------------------

	function showTransactions($exportToCsv) {
		$temp_perm['view'] = $this->checkPermissions('view');
		$temp_perm['create'] = $this->checkPermissions('create');

		$this->assign('a_action_permission', $temp_perm);

		$this->createWhereOrderBy($orderby, $where);


		//$this->campCategory = Affiliate_CMS_Views_CampCategoriesManager::getCampCategoriesAsArray();
		if ($exportToCsv) {
			// prepare export file first
			$this->prepareExportFile($orderby, $where);
		}

		$recs = $this->getRecords($orderby, $where);
		$this->initViews();

		$list_data = QUnit_Global::newobj('QCore_RecordSet');
		$list_data->setTemplateRS($recs);

		$this->assign('a_list_data', $list_data);
		$this->assign('a_curyear', date("Y"));

		$this->pageLimitsAssign();

		$this->addContent('sites_list');
	}

	//--------------------------------------------------------------------------

	function getRecords($orderby, $where) {

		if ($_REQUEST['runQuery'] == 'false') {
			$_POST['runQuery'] = 'false';
			return;
		}
		//------------------------------------------------
		// init paging
		$sql = 'select count(*) as count from rt_sites ';
		$limitOffset = initPaging($this->getTotalNumberOfRecords($sql . $where));

		//------------------------------------------------
		// get records
		$sql = "select * from rt_sites";
		//echo "SQL: ".$sql.$where.$orderby;
		$rs = QCore_Sql_DBUnit::selectLimit($sql . $where . $orderby, $limitOffset, $_REQUEST['numrows'], __FILE__, __LINE__);
		if (!$rs) {
			QUnit_Messager::setErrorMessage(L_G_DBERROR);
			return;
		}

		return $rs;
	}

	//--------------------------------------------------------------------------

	/** returns list of columns in list view */
	function getAvailableColumns() {
		return array(
			//'order' =>         array(L_G_ORDER, 'affiliateid'),
			//'siteId' =>		array(L_G_SITEID, 'siteId'),
			'siteName' => array(L_G_SITENAME, 'siteName'),
			'siteTitle' => array(L_G_SITETITLE, 'siteTitle'),
			'export' => array("Export", ""),
			//'siteDescription' =>         array(L_G_SITEDESCRIPTION, 'siteDescription'),
			'applyLogo' => array(L_G_APPLYLOGO, 'applyLogo'),
			//'version_id' =>         array(L_G_VERSION, 'version_id'),
			'layout' => array(L_G_LAYOUT, 'endexpensedate'),
			'ftpSite' => array(L_G_FTPSITE, 'ftpSite'),
			'publishPath' => array(L_G_PUBLISHPATH, 'totalexpense'),
			'hostname' => array("Dev URL", 'bannerid'),
			'dateCreated' => array(L_G_DATEINSERTED, 'campcategoryid'),
			'dateLastBuilt' => array(L_G_DATELASTBUILT, 'dateLastBuilt'),
			'dateUpdated' => array(L_G_DATEUPDATED, 'channel'),
			'active' => array(L_G_ACTIVE, 'active'),
			'actions' => array(L_G_ACTIONS, ''),
		);
	}

	//--------------------------------------------------------------------------

	function getListViewName() {
		return 'sites_list';
	}

	//--------------------------------------------------------------------------

	function initViews() {
		$this->createDefaultView(array_keys($this->getAvailableColumns()));
		$this->loadAvailableViews();

		$tplAvailableViews = array();
		foreach ($this->availableViews as $objView) {
			$tplAvailableViews[$objView->dbid] = $objView->getName();
		}

		$this->assign('a_list_views', $this->tplAvailableViews);

		$this->applyView();
	}

	//--------------------------------------------------------------------------

	function createWhereOrderBy(&$orderby, &$where) {

		$_SESSION['search'] = $_REQUEST['search'];
		$orderby = '';
		$where = '';

		$a = array_keys($this->getAvailableColumns());

		if ($_REQUEST['sortby'] != '' && in_array($_REQUEST['sortby'], $a)) {
			$orderby = " order by " . $_REQUEST['sortby'] . " " . $_REQUEST['sortorder'];
		} else {
			$orderby = " order by siteName ASC";
		}

		$where = " WHERE deleted != 1 ";

		if ($_REQUEST['search'] != '') {
			$where .= " AND ";
			$where .= " siteName LIKE '%" . $_REQUEST['search'] . "%'";
		}

		return true;
	}

	//--------------------------------------------------------------------------

	function printListRow($row) {
		$view = $this->getView();
		if ($view == false || $view == null) {
			print '<td><font color="ff0000">no view given</font></td>';
			return false;
		}
		$arrowString = '&nbsp;<a href=index.php?md=Affiliate_CMS_Views_SiteManager&action=up&order=' . $row['order'] . '&id=' . $row['siteId'] . '><img src="../templates/standard/images/sort_up.gif"></a>&nbsp;&nbsp; ' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_CMS_Views_SiteManager&action=down&order=' . $row['order'] . '&id=' . $row['siteId'] . '><img src="../templates/standard/images/sort_down.gif"></a>';
		if ($row['order'] == 1) {
			$arrowString = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $row['order'] . '&nbsp;&nbsp;<a href=index.php?md=Affiliate_CMS_Views_SiteManager&action=down&order=' . $row['order'] . '&id=' . $row['siteId'] . '><img src="../templates/standard/images/sort_down.gif"></a>';
		}

		print '<td class="listresult"><input type=checkbox id=itemschecked name="itemschecked[]" value="' . $row['siteId'] . '"></td>';

		foreach ($view->columns as $column) {
			switch ($column) {
				case 'order': print '<td class=listresult align=right nowrap>' . $arrowString . '</td>';
					break;
				case 'dateCreated': print '<td class=listresult align=right nowrap>&nbsp;' . $row['dateCreated'] . '&nbsp;</td>';
					break;
				case 'dateLastBuilt': print '<td class=listresult align=right nowrap>&nbsp;' . $row['dateLastBuilt'] . '&nbsp;</td>';
					break;
				case 'ftpSite': print '<td class=listresult align=right nowrap>&nbsp;' . $row['ftpSite'] . '&nbsp;</td>';
					break;
				case 'applyLogo': print '<td class=listresult align=right nowrap>&nbsp;' . $row['applyLogo'] . '&nbsp;</td>';
					break;
				case 'dateUpdated': print '<td class=listresult align=right nowrap>&nbsp;' . $row['dateUpdated'] . '&nbsp;</td>';
					break;
				case 'siteId': print '<td class=listresult align=right nowrap>&nbsp;' . $row['siteId'] . '&nbsp;</td>';
					break;
				case 'version_id': print '<td class=listresult align=right nowrap>&nbsp;' . $row['version_id'] . '&nbsp;</td>';
					break;
				case 'siteName': print '<td class=listresult align=right nowrap>&nbsp;' . $row['siteName'] . '&nbsp;</td>';
					break;
				case 'siteTitle': print '<td class=listresult align=right nowrap>&nbsp;' . $row['siteTitle'] . '&nbsp;</td>';
					break;
				case 'siteDescription': print '<td class=listresult align=right nowrap>&nbsp;' . $row['siteDescription'] . '&nbsp;</td>';
					break;
				case 'layout': print '<td class=listresult align=right nowrap>&nbsp;' . $row['layout'] . '&nbsp;</td>';
					break;
				case 'publishPath': print '<td class=listresult align=right nowrap>&nbsp;' . $row['publishPath'] . '&nbsp;</td>';
					break;
				case 'hostname': print '<td class=listresult align=right nowrap>&nbsp;<a href="' . $row['hostname'] . '" target="_BLANK">' . $row['hostname'] . '</a>&nbsp;</td>';
					break;
				case 'export': print '<td class=listresult align=right nowrap>&nbsp;<a href="javascript:exportSite(\'' . $row['siteId'] . '\',\'' . $row['layout'] . '\');"><img src="/affiliate/cms/templates/standard/images/rss2.gif"</a>&nbsp;</td>';
					break;

				case 'active': if ($row['active'] == 1)
						$active = "ACTIVE";
					else
						$active = "NOT ACTIVE";
					print '<td class=listresult align=right nowrap>&nbsp;' . $active . '&nbsp;</td>';
					break;
				case 'actions':
					?>                
					<td class=listresult>
						<select name=action_select OnChange="performAction(this);">
							<option value="-">----------------------</option>

							<?php if ($this->checkPermissions('edit')) { ?>
								<option value="javascript:editSite('<?= $row['siteId'] ?>');"><?= L_G_EDIT ?></a>
								<?php } ?>

								<?php if ($this->checkPermissions('delete')) { ?>
								<option value="javascript:deleteSite('<?= $row['siteId'] ?>');"><?= L_G_DELETE ?></a>
								<?php } ?>
								<?php if ($row['active'] == 1) { ?>
								<option value="javascript:deactivateSite('<?= $row['siteId'] ?>');"><?= L_G_DEACTIVATE ?></a>
								<?php } else if ($row['active'] == 0) { ?>
								<option value="javascript:activateSite('<?= $row['siteId'] ?>');"><?= L_G_ACTIVATE ?></a>
								<?php } ?>
								<?php if ($row['layout'] != "") { ?>
								<option value="javascript:exportSite('<?= $row['siteId'] ?>','<?= $row['layout'] ?>');">Export to XML</a>
								<option value="javascript:buildSite('<?= $row['siteId'] ?>','<?= $row['layout'] ?>');">Build Site (Staging)</a>
								<option value="javascript:publishSite('<?= $row['siteId'] ?>','<?= $row['ftpSite'] ?>');">Publish Site (FTP)</a>
								<!--<option value="javascript:publishSite('<?= $row['siteId'] ?>','<?= $row['ftpSite'] ?>');">Publish Site (RSYNC)</a>!-->

								<?php } ?>
						</select>
					</td>
					<?php
					break;

				default:
					print '<td class=listresult>&nbsp;<font color="#ff0000">' . L_G_UNKNOWN . ' ' . $column . '</font>&nbsp;</td>';
					break;
			}
		}
	}

	//--------------------------------------------------------------------------

	function printMassAction() {
		?>
		<td align=left>&nbsp;&nbsp;&nbsp;<?= L_G_SELECTED; ?>&nbsp;
			<select name="massaction">
				<option value=""><?= L_G_CHOOSEACTION ?></option>
				<?php if ($this->checkPermissions('delete')) { ?>
					<option value="delete"><?= L_G_DELETE ?></a>
					<?php } ?>
			</select>
			&nbsp;&nbsp;
			<input type=submit value="<?= L_G_SUBMITMASSACTION ?>">
		</td>
		<?php
	}

	function returnEIDs() {
		if ($_POST['massaction'] != '') {
			$eIDs = $_POST['itemschecked'];
		} else {
			$eIDs = array($_REQUEST['eid']);
		}

		return $eIDs;
	}

}
?>