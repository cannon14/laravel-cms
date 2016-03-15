<?php

/**
 * 
 * ClickSuccess, L.P.
 * March 29, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */
csCore_Import::importClass('csCore_UI_SLLists');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_SubPages');

class CMS_view_siteToPage extends CMS_pages_cmsRestrictedPage {

	function process() {

		if (!empty($_REQUEST['sortableListsSubmitted'])) {

			$orderArray = csCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'], 'assignedList');
			foreach ($orderArray as $item) {
				$sql[] = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q($item['order']) . ", " . _q($_REQUEST['siteId']) . "," . _q($item['element']) . ")";
			}
			$this->updateOrder($sql);
		}

		if (!empty($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {
				case 'assignAll':
					if ($this->assignAll())
						return;
					break;
				case 'removeAll':
					if ($this->removeAll())
						return;
					break;
				case 'addPage':
					if ($this->processAddPage())
						return;
					break;
				case 'removePage':
					if ($this->processRemovePage())
						return;
					break;
				case 'addSubPage':
					if ($this->processAddSubPage())
						return;
					break;
				case 'hidePage':
					if ($this->processHide())
						return;
					break;
			}
		}

		$this->showPage();
	}

	function processAddPage() {
		$sql = "SELECT MAX(rank) FROM rt_pagecategorymap WHERE categoryId = " . _q($_REQUEST['siteId']);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$max = $rs->fields['MAX(rank)'];
		if ($max == '')
			$max = 0;
		$sql = "DELETE FROM rt_pagecategorymap WHERE cardpageId=" . _q($_REQUEST['pageID']) . " AND categoryId=" . _q($_REQUEST['siteId']);

		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$sql = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q(($max + 1)) . ", " . _q($_REQUEST['siteId']) . "," . _q($_REQUEST['pageID']) . ")";
		//echo $sql ."<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
	}

	function processRemovePage() {
		$sql = "SELECT * FROM rt_pagecategorymap WHERE categoryId=" . _q($_REQUEST['siteId']) . " AND cardpageId != " . _q($_REQUEST['cardpageId']) . " ORDER BY rank";
		//echo $sql ."<br><br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$sql = "DELETE FROM rt_pagecategorymap WHERE categoryId=" . _q($_REQUEST['siteId']);

		_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$count = 1;
		while (!$rs->EOF) {
			$sql = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q($count) . ", " . _q($_REQUEST['siteId']) . "," . _q($rs->fields['cardpageId']) . ")";
			//echo $sql ."<br><br><br>";
			_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			$count ++;
			$rs->MoveNext();
		}
	}

	function processHide() {
		$subPageDAO = new CMS_libs_SubPages();

		$siteId = $_REQUEST['siteId'];
		$masterPageId = $_REQUEST['pageId'];
		$subPageId = $_REQUEST['subpageId'];

		$subPageDAO->hidePage($siteId, $masterPageId, $subPageId);
	}

	function processAddSubPage() {
		$subPageDAO = new CMS_libs_SubPages();

		$siteId = $_REQUEST['siteId'];
		$masterPageId = $_REQUEST['pageId'];
		$subPageId = $_REQUEST['subpageId'];
		$counter = 0;

		$table = 'rt_pagesubpagemap';
		//If site id is equal to CCCOM_MOBILE, which is id 47, use this table.
		if ($siteId == 47) {
			$table = 'rt_pagesubpagemap_mobile ';
		}

		if ($_REQUEST['process']) {

			$sql = 'DELETE FROM ' . $table .
				' WHERE masterpageid=' . $masterPageId . ' AND siteid = ' . $siteId;

			$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

			if (is_array($_REQUEST['subpageId'])) {
				foreach ($_REQUEST['subpageId'] as $id) {

					$sql = 'INSERT INTO ' . $table .
						' (siteid, masterpageid, subpageid, rank)' .
						' VALUES (' . _q($siteId) . ',' . _q($masterPageId) . ',' . _q($id) . ',' . $counter++ . ')';

					$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
				}
			}
			$this->showPage();
		} else {

			$assignedSubPages = $subPageDAO->getAssignedSubPagesBySiteAndMaster($siteId, $masterPageId);
			$unassignedSubPages = $subPageDAO->getUnassignedSubPagesBySiteAndMaster($siteId, $masterPageId);

			$this->assignValue('siteId', $siteId);
			$this->assignValue('pageId', $masterPageId);
			$this->assignValue('assignedSubPages', $assignedSubPages);
			$this->assignValue('unassignedSubPages', $unassignedSubPages);

			$this->addcontent('addSubGroup');
		}

		return true;
	}

	function removeAll() {
		$sql = "DELETE from rt_pagecategorymap where categoryId = " . _q($_REQUEST['siteId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		return false;
	}

	function assignAll() {
		$sql = "DELETE from rt_pagecategorymap where categoryId = " . _q($_REQUEST['siteId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		$sql = "SELECT cardpageId from rt_cardpages where deleted != 1";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);

		$count = 1;
		while (!$rs->EOF) {
			$sql = "INSERT INTO rt_pagecategorymap (rank, categoryId, cardpageId) VALUES (" . _q($count) . ", " . _q($_REQUEST['siteId']) . "," . _q($rs->fields['categoryId']) . ")";
			_sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
			$rs->MoveNext();
		}
		return false;
	}

	function updateOrder($sql) {
		// added this check to reduce severity of bugs that pass empty $sql
		// to this function.  - mz
		if (!empty($sql)) {
			$deletesql = "DELETE from rt_pagecategorymap where categoryId = " . _q($_REQUEST['siteId']);

			$rs = _sqlQuery($deletesql, __LINE__, __FILE__, DEBUG_MODE);
			if ($sql != '') {
				foreach ($sql as $currentSql) {
					//echo $currentSql . "<br>";
					$rs = _sqlQuery($currentSql, __LINE__, __FILE__, DEBUG_MODE);
				}
			}
		}
	}

	//--------------------------------------------------------------------------

	function showPage() {
		$assigned = $this->getAssignedRecords();
		$assigned2 = $this->getAssignedRecords();
		$_POST['rs_assigned'] = $assigned;
		$unassigned = $this->getUnassignedRecords();
		$_POST['rs_unassigned'] = $unassigned;

		//make array of pages=>subpages[]
		while ($assigned2 && !$assigned2->EOF) {
			$subPages = CMS_libs_SubPages::getSubPagesByPage($assigned2->fields['cardpageId'], $_REQUEST['siteId']);
			while ($subPages && !$subPages->EOF) {
				if ($subPages->fields['cardpageId'] != '') {
					$subCats[$assigned2->fields['cardpageId']][] = clone $subPages;
				}
				$subPages->MoveNext();
			}
			$assigned2->MoveNext();
		}

		$_POST['categoryName'] = $assigned->fields['categoryName'];
		$this->assignValue('rs_assignedSubCats', $subCats);

		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));
		$this->addContent('assigncategories_list');
	}

	function getUnassignedRecords() {
		//------------------------------------------------
		// get records
		$rs = $this->getAssignedRecords();
		while (!$rs->EOF) {
			$assigned[] = $rs->fields['cardpageId'];
			$rs->MoveNext();
		}
		if (count($assigned) > 0) {
			$sqlIds = "('" . implode("','", $assigned) . "')";
		} else
			$sqlIds = "('')";
		$sql = "select * from rt_cardpages as c where c.type =0 AND !(c.cardpageId in " . $sqlIds . ") and c.deleted != 1 order by c.pageName";
		//echo "SQL: ".$sql;
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs) {
			_setMessage("SQL QUERY ERROR!", true, __LINE__, __FILE__);
			return;
		}

		return $rs;
	}

	function getAssignedRecords() {

		//------------------------------------------------
		// get records
		$sql = "select * from rt_pagedetails as d, rt_cardpages as s, rt_pagecategorymap as m, rt_sites as c where s.type = 0 AND (d.deleted != 1 AND s.deleted != 1) AND d.pageDetailVersion = -1 AND (d.cardpageId = s.cardpageId) AND m.categoryId =" . _q($_REQUEST['siteId']) . " and (m.cardpageId=s.cardpageId) and (m.categoryId=c.siteId) and s.deleted != 1 ORDER BY m.rank ASC";
		$rs = _sqlQuery($sql, __LINE__, __FILE__, DEBUG_MODE);
		if (!$rs) {
			_setMessage("SQL QUERY ERROR!", true, __LINE__, __FILE__);
			return;
		}

		return $rs;
	}

}