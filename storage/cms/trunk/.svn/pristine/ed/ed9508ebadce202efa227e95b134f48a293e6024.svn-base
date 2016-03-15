<?php

/**
 * 
 * CreditCards.com
 * July 10, 2007
 *  
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_View
 */
csCore_Import::importClass('csCore_UI_SLLists');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_Specials');

class CMS_view_specialsPage extends CMS_pages_cmsRestrictedPage {

	function process() {
		if (isset($_REQUEST['sortableListsSubmitted'])) {
			$this->updateOrder($_REQUEST['cardpageId']);
		} else {
			switch ($_REQUEST['action']) {
				case 'addPage':
					if ($this->processAddPage($_REQUEST['cardpageId'], $_REQUEST['pageId']))
						return;
					break;
				case 'removePage':
					if ($this->processRemovePage($_REQUEST['cardpageId'], $_REQUEST['pageId']))
						return;
					break;
				default:
					break;
			}
		}
		$this->showPage();
	}

	function processAddPage($specialsPageId, $pageId) {
		CMS_libs_Specials::addSpecialsPageToPage($specialsPageId, $pageId);
	}

	function processRemovePage($specialsPageId, $pageId) {
		$assignedIds = CMS_libs_Specials::getPageIdsById($specialsPageId);
		CMS_libs_Specials::removePagesById($specialsPageId);

		while ($assignedIds && !$assignedIds->EOF) {
			if ($assignedIds->fields['pageid'] != $pageId)
				CMS_libs_Specials::addSpecialsPageToPage($specialsPageId, $assignedIds->fields['pageid']);
			$assignedIds->MoveNext();
		}
	}

	function updateOrder($specialsPageId) {
		$orderArray = csCore_UI_SLLists::getOrderArray($_REQUEST['assignedListOrder'], 'assignedList');
		CMS_libs_Specials::removePagesById($specialsPageId);
		foreach ($orderArray as $item)
			CMS_libs_Specials::addSpecialsPageToPage($specialsPageId, $item['element']);
	}

	function showPage() {
		$this->assignValue('assigned', CMS_libs_Specials::getSpecialsPagesById($_REQUEST['cardpageId']));
		$this->assignValue('unassigned', CMS_libs_Specials::getSpecialsPagesUnassignedById($_REQUEST['cardpageId']));
		$this->addContent('assignspecials_list');
	}

}