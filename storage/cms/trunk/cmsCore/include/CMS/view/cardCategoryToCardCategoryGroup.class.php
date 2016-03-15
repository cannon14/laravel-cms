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
csCore_Import::importClass('CsCore_UI_SLListsYui');
csCore_Import::importClass('CMS_libs_CardCategoryGroups');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');

class CMS_view_cardCategoryToCardCategoryGroup extends CMS_pages_cmsRestrictedPage {

	function process() {
		if (!empty($_REQUEST['action'])) {
			switch ($_REQUEST['action']) {
				case 'updateCardCategoryGroups':
					if ($this->processUpdateCardCategoryGroups())
						return;
					break;
			}
		}

		$this->showPage();
	}

	function processUpdateCardCategoryGroups() {
		$id = $_REQUEST['id'];

		$catList = explode(',', $_REQUEST['assignedCategories']);

		$sql = "SELECT card_category_id FROM card_category_group_to_category WHERE card_category_group_id = $id";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);

		if (!$rs) {
			_setMessage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}

		$currentAssigned = array();

		while (!$rs->EOF) {
			$currentAssigned[] = $rs->fields['card_category_id'];
			$rs->MoveNext();
		}

		$toDelete = array_diff($currentAssigned, $catList);

		if (count($toDelete) > 0) {
			$deleteIds = implode(',', $toDelete);

			$sql = "DELETE FROM card_category_group_to_category WHERE card_category_group_id = $id AND card_category_id IN ($deleteIds)";
			$rs = _sqlQuery($sql, __LINE__, __FILE__);
		}


		for ($i = 0; $i < count($catList); $i++) {
			$rank = $i + 1;

			//if cat already exists in group, update rank
			if (in_array($catList[$i], $currentAssigned)) {
				$sql = "UPDATE card_category_group_to_category SET card_category_group_rank = $rank where card_category_id = '$catList[$i]' and card_category_group_id = '$id'";
				$rs = _sqlQuery($sql, __LINE__, __FILE__);
			} else {
				$sql = "INSERT INTO card_category_group_to_category ( card_category_group_id, card_category_id, card_category_group_rank ) VALUES ( $id, $catList[$i], $rank )";

				$rs = _sqlQuery($sql, __LINE__, __FILE__);
			}
		}
	}

	function processRemoveCardCategories() {//mlucas - done - can we update instead of deleting all and inserting?
		$sql = "SELECT * FROM card_ranks WHERE card_category_id=" . _q($_REQUEST['card_category_id']) . " AND card_id!= " . _q($_REQUEST['card_id']) . " ORDER BY card_rank";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		$sql = "DELETE FROM card_ranks WHERE card_category_id=" . _q($_REQUEST['card_category_id']);
		_sqlQuery($sql, __LINE__, __FILE__);
		$count = 1;
		while (!$rs->EOF) {
			$sql = "INSERT INTO card_ranks (card_rank, card_category_id, card_id, card_category_context_id) VALUES (" . _q($count) . ", " . _q($rs->fields['card_category_id']) . "," . _q($rs->fields['card_id']) . ", 1)";
			_sqlQuery($sql, __LINE__, __FILE__);
			$count ++;
			$rs->MoveNext();
		}
	}

	//--------------------------------------------------------------------------

	function showPage() {
		$siteDAO = new CMS_libs_Sites();

		$assignedCardCategories = $this->getAssignedCardCategories($_REQUEST['id']);
		$unassignedCardCategories = $this->getUnassignedCardCategories($_REQUEST['id']);

		$this->assignValue('assignedCategories', $assignedCardCategories);
		$this->assignValue('unassignedCategories', $unassignedCardCategories);

		$_POST['cardCategoryGroupInfo'] = $this->getCardCategoryGroupInfo($_REQUEST['id']);

		$this->addContent('assignCardCategoriesToCardCategoryGroups_list');
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

	function getUnassignedCardCategories($categoryGroupId) {

		//------------------------------------------------
		// get records

		$sql = <<<SQL
				SELECT * 
				FROM card_categories as cc
				WHERE NOT EXISTS
				(
					SELECT 1
					FROM card_category_group_to_category AS ccgc
					WHERE ccgc.card_category_group_id = $categoryGroupId AND ccgc.card_category_id = cc.card_category_id
				)
				AND cc.deleted != 1
				ORDER BY cc.card_category_name	
SQL;

		//echo "getUnassignedRecords: ".$sql . "<br><br>";
		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		if (!$rs) {
			_setMessage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}
		$unassigned = array();
		while (!$rs->EOF) {
			$unassigned[] = array('id' => $rs->fields['card_category_id'], 'name' => $rs->fields['card_category_name']);
			$rs->MoveNext();
		}

		return $unassigned;
	}

	function getAssignedCardCategories($categoryGroupId) {// mlucas - done?
		//------------------------------------------------
		// get records
		$sql = "select * from 
				card_category_group_to_category cgtc
				JOIN card_categories cc ON (cgtc.card_category_id = cc.card_category_id) 		
				where ( cgtc.card_category_group_id = $categoryGroupId )
				AND cc.deleted != 1
				ORDER BY cgtc.card_category_group_rank";

		$rs = _sqlQuery($sql, __LINE__, __FILE__);
		if (!$rs) {
			_setMessage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}

		$assigned = array();

		while (!$rs->EOF) {
			$assigned[] = array('id' => $rs->fields['card_category_id'], 'name' => $rs->fields['card_category_name']);
			$rs->MoveNext();
		}

		return $assigned;
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
			_setMessage("QUERY Error", true, __LINE__, __FILE__);
			return;
		}

		return $rs;
	}

	function getCardCategoryGroupInfo($id) {
		return CMS_libs_CardCategoryGroups::getCardCategoryGroupById($id);
	}

}