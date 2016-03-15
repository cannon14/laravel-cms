<?php

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

class CMS_view_cardToPage extends CMS_pages_cmsRestrictedPage {

	const TABLE = 'rt_cardpagemap';
	function process() {

		if (!empty($_REQUEST['sortableListsSubmitted'])) {

			$orderArray = CsCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'], 'assignedList');
			foreach ($orderArray as $item) {
				$s = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId) VALUES (" . _q($item['order']) . ", " . _q($_REQUEST['cardpageId']) . "," . _q($item['element']) . ")";
				//echo $s ."<br>";
				$sql[] = $s;
			}
			$this->updateOrder($sql);
		}

		if (!empty($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {
				case 'addPage':
					if ($this->processAddPage()) {
						return;
					}
					break;
				case 'addCard':
					if ($this->processAddCard()) {
						return;
					}
					break;
				case 'addSubCat':
					if ($this->processAddSubCat()) {
						return;
					}
					break;
				case 'removeSubCat':
					if ($this->processRemoveSubCat()) {
						return;
					}
					break;
				case 'removeCard':
					if ($this->processRemoveCard()) {
						return;
					}
					break;
				case 'showVersion':
					if ($this->showExclude()) {
						return;
					}
					break;
				case 'excludeCard':
					if ($this->processExcludeCard()) {
						return;
					}
					break;
			}
		}

		$this->showPage();
	}

	function processAddPage() {
		
		$sql = "SELECT MAX(rank) FROM ".self::TABLE." WHERE cardpageId = " . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$max = $rs->fields['MAX(rank)'];
		if ($max == '')
			$max = 0;
		$sql = "DELETE FROM ".self::TABLE." WHERE cardId=" . _q($_REQUEST['cardId']) . " AND cardpageId=" . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "INSERT INTO ".self::TABLE." (rank, cardpageId, cardId, pageInsert) VALUES (" . _q(($max + 1)) . ", " . _q($_REQUEST['cardpageId']) . "," . _q($_REQUEST['cardId']) . "," . _q(1) . ")";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
	}

	function processAddCard() {
		
		$sql = "SELECT MAX(rank) FROM ".self::TABLE." WHERE cardpageId = " . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$max = $rs->fields['MAX(rank)'];
		if ($max == '')
			$max = 0;
		$sql = "DELETE FROM ".self::TABLE." WHERE cardId=" . _q($_REQUEST['cardId']) . " AND cardpageId=" . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "INSERT INTO ".self::TABLE." (rank, cardpageId, cardId) VALUES (" . _q(($max + 1)) . ", " . _q($_REQUEST['cardpageId']) . "," . _q($_REQUEST['cardId']) . ")";
		//echo $sql ."<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
	}

	function processRemoveCard() {
		
		$sql = "SELECT * FROM ".self::TABLE." WHERE cardpageId=" . _q($_REQUEST['cardpageId']) . " AND cardId!= " . _q($_REQUEST['cardId']) . " ORDER BY rank";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "DELETE FROM ".self::TABLE." WHERE cardpageId=" . _q($_REQUEST['cardpageId']);
		_sqlQuery($sql, __LINE__, __FILE__);
		$count = 1;
		while (!$rs->EOF) {
			$sql = "INSERT INTO ".self::TABLE." (rank, cardpageId, cardId) VALUES (" . _q($count) . ", " . _q($rs->fields['cardpageId']) . "," . _q($rs->fields['cardId']) . ")";
			_sqlQuery($sql, __LINE__, __FILE__);
			$count ++;
			$rs->MoveNext();
		}
	}

	function processExcludeCard() {
		$sql = "SELECT * FROM cs_pagecardexclusionmap" .
			" WHERE siteid=" . $_REQUEST['siteId'] .
			" AND pageid=" . $_REQUEST['cardpageId'] .
			" AND cardid=" . $_REQUEST['cardId'];
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		//echo $sql.'<br><br>';

		if (!$rs->fields) {
			$sql = "INSERT INTO cs_pagecardexclusionmap (siteid, pageid, cardid) " .
				"VALUES (" . _q($_REQUEST['siteId']) . ", " . _q($_REQUEST['cardpageId']) . "," . _q($_REQUEST['cardId']) . ")";
			//echo $sql.'<br><br>';
			_sqlQuery($sql, __LINE__, __FILE__);
		} else {
			$sql = "DELETE FROM cs_pagecardexclusionmap" .
				" WHERE siteid=" . $_REQUEST['siteId'] .
				" AND pageid=" . $_REQUEST['cardpageId'] .
				" AND cardid=" . $_REQUEST['cardId'];
			_sqlQuery($sql, __LINE__, __FILE__);
		}

		return $this->showExclude();
	}

	function updateOrder($sql) {
	
		$deletesql = "DELETE from ".self::TABLE." where cardpageId = " . _q($_REQUEST['cardpageId']);

		$rs = _sqlQuery($deletesql, __LINE__, __FILE__, DEBUG_MODE);
		if ($sql != '') {
			foreach ($sql as $currentSql)
				$rs = _sqlQuery($currentSql, __LINE__, __FILE__, DEBUG_MODE);
		}
	}

	//--------------------------------------------------------------------------

	function showPage() {
		$siteDAO = new CMS_libs_Sites();

		$assignedCards = $this->getAssignedCards();
		$unassignedCards = $this->getUnassignedCards();
		$allSites = $siteDAO->getAllSites();

		$_POST['rs_assignedCards'] = $assignedCards;
		$_POST['rs_unassignedCards'] = $unassignedCards;

		$_POST['pageInfo'] = $this->getPageInfo($_REQUEST['cardpageId']);

		$this->assignValue('sites', $allSites);
		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));

		$this->addContent('assigncards_list');
	}

	function showExclude() {
		$siteDAO = new CMS_libs_Sites();
		$excludedArray = array();

		$assignedCards = $this->getAssignedCards();
		$unassignedCards = $this->getUnassignedCards();
		$excludedCards = $this->getExcludedCards($_REQUEST['siteId'], $_REQUEST['cardpageId']);
		$allSites = $siteDAO->getAllSites();

		$_POST['rs_assignedCards'] = $assignedCards;
		$_POST['rs_unassignedCards'] = $unassignedCards;
		$_POST['pageInfo'] = $this->getPageInfo($_REQUEST['cardpageId']);


		//put excluded card Ids into array
		while ($excludedCards && !$excludedCards->EOF) {
			$excludedArray[] = $excludedCards->fields['cardid'];
			$excludedCards->MoveNext();
		}

		$this->assignValue('excludedArray', $excludedArray);
		$this->assignValue('sites', $allSites);
		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));

		$this->addContent('exclude_cards_list');

		return true;
	}

	function getUnassignedCards() {

		//------------------------------------------------
		// get records
		$rs = $this->getAssignedCards();
		while (!$rs->EOF) {
			$assigned[] = $rs->fields['cardId'];
			$rs->MoveNext();
		}
		if (count($assigned) > 0) {
			$sqlIds = "('" . implode("','", $assigned) . "')";
		} else {
			$sqlIds = "('')";
		}
		$sql = "select * from rt_cards as c WHERE c.cardId not in " . $sqlIds . " and c.deleted != 1 ORDER BY c.cardTitle";

		//echo "getUnassignedRecords: ".$sql . "<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		if (!$rs) {
			_setMEssage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}

		return $rs;
	}

	function getAssignedCards() {
		//------------------------------------------------
		// get records
		$sql = "select * from 
				rt_cardpages as p, ".self::TABLE." as m, rt_carddetails as cd, rt_cards as c 		
				where (c.cardId = cd.cardId) 		
				AND cd.cardDetailVersion = -1 		
				AND m.cardpageId = " . _q($_REQUEST['cardpageId']) . "		
				AND (m.cardpageId=p.cardpageId) 		
				AND (m.cardId=c.cardId) 		
				AND c.deleted != 1 	
				GROUP BY m.cardId ORDER BY m.rank";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		if (!$rs) {
			_setMEssage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}

		return $rs;
	}

	function getExcludedCards($siteId, $pageId) {
		//------------------------------------------------
		// get records
		$sql = "select * from 
				cs_pagecardexclusionmap	WHERE siteid = " . $siteId .
			" AND (pageid = " . $pageId . " or pageid=-1)";
		echo "getExcludedCards: " . $sql . "<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		if (!$rs) {
			_setMEssage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}

		return $rs;
	}

	function getPageInfo($id) {
		return CMS_libs_Pages::getPage($id, -1);
	}

}
