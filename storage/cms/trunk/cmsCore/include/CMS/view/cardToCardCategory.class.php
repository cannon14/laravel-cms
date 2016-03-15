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
csCore_Import::importClass('CMS_libs_CardCategories');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_DatabaseLogger');

class CMS_view_cardToCardCategory extends CMS_pages_cmsRestrictedPage {

	function process() {

		if (!empty($_REQUEST['sortableListsSubmitted'])) {

			$orderArray = CsCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'], 'assignedList');

			// Log new order to database
			$logger = new DatabaseLogger($this->auth->username);
			$data = array(
				'card_category_id' => $_REQUEST['card_category_id'],
				'new_order' => $orderArray
			);
			$logger->log($data, 'Committing new card category order');

			foreach ($orderArray as $item) {
				$s = "INSERT INTO card_ranks (card_rank, card_category_id, card_id, card_category_context_id) VALUES (" . _q($item['order']) . ", " . _q($_REQUEST['card_category_id']) . "," . _q($item['element']) . ", 1)";
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
		$sql = "SELECT MAX(rank) FROM rt_cardpagemap WHERE cardpageId = " . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$max = $rs->fields['MAX(rank)'];
		if ($max == '') {
			$max = 0;
		}
		$sql = "DELETE FROM rt_cardpagemap WHERE cardId=" . _q($_REQUEST['cardId']) . " AND cardpageId=" . _q($_REQUEST['cardpageId']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "INSERT INTO rt_cardpagemap (rank, cardpageId, cardId, pageInsert) VALUES (" . _q(($max + 1)) . ", " . _q($_REQUEST['cardpageId']) . "," . _q($_REQUEST['cardId']) . "," . _q(1) . ")";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
	}

	function processAddCard() { //mlucas - done
		$sql = "SELECT MAX(card_rank) FROM card_ranks WHERE card_category_id = " . _q($_REQUEST['card_category_id']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$max = $rs->fields['MAX(card_rank)'];
		if ($max == '') {
			$max = 0;
		}
		$sql = "DELETE FROM card_ranks WHERE card_id=" . _q($_REQUEST['card_id']) . " AND card_category_id=" . _q($_REQUEST['card_category_id']);
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "INSERT INTO card_ranks (card_rank, card_category_id, card_id, card_category_context_id) VALUES (" . _q(($max + 1)) . ", " . _q($_REQUEST['card_category_id']) . "," . _q($_REQUEST['card_id']) . ", 1)";
		//echo $sql ."<br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
	}

	function processRemoveCard() { //mlucas - done - can we update instead of deleting all and inserting?
		$sql = "SELECT * FROM card_ranks WHERE card_category_id=" . _q($_REQUEST['card_category_id']) . " AND card_id!= " . _q($_REQUEST['card_id']) . " ORDER BY card_rank";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "DELETE FROM card_ranks WHERE card_category_id=" . _q($_REQUEST['card_category_id']);
		_sqlQuery($sql, __LINE__, __FILE__);
		$count = 1;
		while (!$rs->EOF) {
			$sql = "INSERT INTO card_ranks (card_rank, card_category_id, card_id, card_category_context_id) VALUES (" . _q($count) . ", " . _q($rs->fields['card_category_id']) . "," . _q($rs->fields['card_id']) . ", 1)";
			_sqlQuery($sql, __LINE__, __FILE__);
			$count++;
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

	function updateOrder($sql) { //mlucas - done
		$deletesql = "DELETE from card_ranks where card_category_id = " . _q($_REQUEST['card_category_id']);

		// Log change to database
		$logger = new DatabaseLogger($this->auth->username);
		$data = array(
			'card_category_id' => $_REQUEST['card_category_id'],
			'raw_sql' => addslashes(str_replace("'", '"', $deletesql))
		);
		$logger->log($data, 'Deleting card category');


		$rs = _sqlQuery($deletesql, __LINE__, __FILE__, DEBUG_MODE);
		if ($sql != '') {
			foreach ($sql as $currentSql) {
				$rs = _sqlQuery($currentSql, __LINE__, __FILE__, DEBUG_MODE);
			}
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

		//$_POST['categoryName'] = $assigned->fields['categoryName'];

		$_POST['cardCategoryInfo'] = $this->getCardCategoryInfo($_REQUEST['card_category_id']);
		//echo "Category Name: " . $assigned->fields['categoryName'];

		$this->assignValue('sites', $allSites);
		$this->assignValue('imageRepository', $this->settings->getSetting('CMS_image_repository'));

		$this->addContent('assigncardsToCardCategories_list');
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
		$_POST['categoryName'] = $assigned->fields['categoryName'];
		$_POST['pageInfo'] = $this->getPageInfo($_REQUEST['cardpageId']);
		//echo "Category Name: " . $assigned->fields['categoryName'];
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

	function getAssignedCards() { // mlucas - done?


		//------------------------------------------------
		// get records
		$sql = "select * from
				card_ranks as r, rt_carddetails as cd, rt_cards as c
				where (c.cardId = cd.cardId)
				AND cd.cardDetailVersion = -1
				AND r.card_category_id = " . _q($_REQUEST['card_category_id']) . "
				AND (r.card_id=c.cardId)
				AND c.deleted != 1
				GROUP BY r.card_id ORDER BY r.card_rank";
		//echo "getAssignedRecords: ".$sql ."<br><br>";
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
		//echo "getExcludedCards: ".$sql ."<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		if (!$rs) {
			_setMEssage("QUERY Error", true, __LINE__, __FILE__);

			return;
		}

		return $rs;
	}

	function getCardCategoryInfo($id) {
		return CMS_libs_CardCategories::getCardCategoryById($id);
	}
	
	/**
	 * Gets the appropriate cardpage table name for a given SQL statement.
	 * @param int $siteId
	 */
	private function getCardPageTableName($siteId) {
		//If site id is equal to CCCOM_MOBILE, which is id 47, use this table.
		if ($siteId == 47) {
			return 'rt_cardpagemap_mobile ';
		} else { //use this table for all others
			return 'rt_cardpagemap ';
		}
	}

}