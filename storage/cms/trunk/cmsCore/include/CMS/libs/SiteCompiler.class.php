<?php

/**
 *
 * ClickSuccess, L.P.
 * March 30, 2006
 *
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * <br>
 * Jason Huie
 * <jasonh@clicksuccess.com>
 *
 * @package CMS_Lib
 *
 */
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_libs_Pages');
csCore_Import::importClass('CMS_libs_Cards');
csCore_Import::importClass('CMS_libs_MerchantServices');
csCore_Import::importClass('CMS_libs_Specials');
csCore_Import::importClass('CMS_libs_Profiles');
csCore_Import::importClass('CMS_libs_SubPages');
//csCore_Import::importClass('CMS_libs_Articles');
csCore_Import::importClass('CMS_libs_siteComponents');
csCore_Import::importClass('CMS_libs_PageComponents');
csCore_Import::importClass('CMS_libs_SiteCatalyst');
csCore_Import::importClass('CMS_libs_SiteCatalystPages');
csCore_Import::importClass('CMS_libs_SiteCatalystIndividualCards');
csCore_Import::importClass('CMS_libs_SiteCatalystMerchantService');
csCore_Import::importClass('CMS_libs_Redirect');

class CMS_libs_SiteCompiler {

	var $distinctCards = array();
	var $cards = array();
	var $orphanedCards = array();
	var $merchantServices = array();
	var $cardPages = array();
	var $merchantServicePages = array();
	var $merchantServiceApplicationPages = array();
	var $specialsPages = array();
	var $profilePages = array();
	var $profileIndex;
	var $indexPages = array();
	var $site = array();
	var $subPages = array();
	var $components = array();
	//var $articleCategories = array();
	//var $articles = array();
	//var $articleComponents = array();
	var $news = array();
	var $redirects = array();

	function _debugStamp($descriptor) {
		static $ts = null;

		/* set true to enable time stamp debugging */
		if (false) {
			if ($ts === null)
				$ts = time();
			echo sprintf('%s%3.0f</p>', $descriptor, (time() - $ts));
			$ts = time();
		}
	}

	/**
	 * Constructor -- compile an entire site
	 * @author Patrick Mizer/Jason Huie
	 * @version 1.3
	 * @param int Site ID
	 */
	function CMS_libs_SiteCompiler($id) {
		$rs = CMS_libs_Sites::getSite($id);
		$this->site = new site($rs->fields);

		if ($this->site->get('siteId') != $id) {
			_setMessage("Site could not be found!", true, __LINE__, __FILE__);
		} else {
			$this->_debugStamp("[START] - CMS_libs_SiteCompiler - [_compilePages] - ");
			$this->_compilePages();
			$this->_debugStamp("[_compileSubPages] - ");
			$this->_compileSubPages();
			$this->_debugStamp("[_compilePageComponents] - ");
			$this->_compilePageComponents();
			$this->_debugStamp("[_compileCards()] - ");
			$this->_compileCards();
			$this->_debugStamp("[ _compileMerchantServices] - ");
			$this->_compileMerchantServices();
			$this->_debugStamp("[_compileMerchantServiceApplications] - ");
			$this->_compileMerchantServiceApplications();
			$this->_debugStamp("[_compileSpecials] - ");
			$this->_compileSpecials();
			$this->_debugStamp("[_compileProfile] - ");
			$this->_compileProfiles();
			$this->_debugStamp("[_compileRedirects] - ");
			//$this->_compileArticleCategories();
			//$this->_compileArticles();
			//$this->_compileArticleComponents();
			$this->_compileRedirects();
			$this->_debugStamp("[_compileSite] - ");
			$this->_compileSite();
			$this->_debugStamp("[_END_] - CMS_libs_SiteCompiler - ");
		}
	}

	/**
	 * Get the compiled site
	 * @author Patrick Mizer
	 * @version 1.0
	 * @deprecated
	 */
	function getCompiledSite() {
		return $this->site;
	}

	function _compilePages() {
		$rs = CMS_libs_Pages::getPagesBySite($this->site->get('siteId'));

		while ($rs && !$rs->EOF) {
			//create relative root path to page from pageLink
			$linkArray = explode('/', $rs->fields['pageLink']);
			array_pop($linkArray);
			$rs->fields['rootPath'] = '';

			foreach ($linkArray as $dir) {
				$rs->fields['rootPath'] .= '../';
			}

			if ($rs->fields['contentType'] == 'card' ||
				$rs->fields['contentType'] == 'merchant service' ||
				$rs->fields['contentType'] == 'specials' ||
				$rs->fields['contentType'] == 'altspecials' ||
				$rs->fields['contentType'] == 'merchant service application'
			) {
				switch ($rs->fields['pageType']) {
					case 'TYPE';
						$siteCatalystRs = CMS_libs_SiteCatalystPages::getPageVarValues($rs->fields['id']);
						break;
					case 'BANK';
						$siteCatalystRs = CMS_libs_SiteCatalystPages::getPageVarValues($rs->fields['id']);
						break;
					case 'CREDIT';
						$siteCatalystRs = CMS_libs_SiteCatalystPages::getPageVarValues($rs->fields['id']);
						break;
					default:
						// do nothing, the above 3 are the only ones we want to handle.  - mz
						break;
				}

				if (!empty($siteCatalystRs)) {
					while (!$siteCatalystRs->EOF) {
						$rs->fields[SITECATALYST_VAR_IDENTIFIER][$siteCatalystRs->fields['var_name']] = $siteCatalystRs->fields['var_value'];

						$siteCatalystRs->MoveNext();
					}
				}
			}

			if ($rs->fields['contentType'] == 'card') {
				$this->cardPages[$rs->fields['cardpageId']] = new page($rs->fields);
			} else if ($rs->fields['contentType'] == 'merchant service') {
				$this->merchantServicePages[$rs->fields['cardpageId']] = new page($rs->fields);
			} else if ($rs->fields['contentType'] == 'merchant service application') {
				$this->merchantServiceApplicationPages[$rs->fields['cardpageId']] = new page($rs->fields);
			} else if ($rs->fields['contentType'] == 'specials' || $rs->fields['contentType'] == 'altspecials') {
				$this->specialsPages[$rs->fields['cardpageId']] = new page($rs->fields);
			} else if ($rs->fields['contentType'] == 'profile') {
				$this->profilePages[$rs->fields['cardpageId']] = new page($rs->fields);
				//  echo "compiling profile: " . $rs->fields['cardpageId'] . "<br/>";
			} else if ($rs->fields['contentType'] == 'index') {
				$this->indexPages[] = new page($rs->fields);
			}

			$rs->MoveNext();
		}
	}

	function _compileSubPages() {
		foreach ($this->cardPages as $page) {
			$rs = CMS_libs_SubPages::getSubPagesByPage($page->get('cardpageId'), $this->site->get('siteId'));
			while ($rs && !$rs->EOF) {
				$this->subPages[$page->get('cardpageId')][] = new page($rs->fields);
				$rs->MoveNext();
			}
		}

		foreach ($this->merchantServicePages as $page) {

			$rs = CMS_libs_SubPages::getSubPagesByPage($page->get('cardpageId'), $this->site->get('siteId'));
			while ($rs && !$rs->EOF) {
				$this->subPages[$page->get('cardpageId')][] = new page($rs->fields);
				$rs->MoveNext();
			}
		}
	}

	function _compilePageComponents() {
		$rs = CMS_libs_PageComponents::getComponentsBySite($this->site->get('siteId'), $pageType = 'cardpage');
		while ($rs && !$rs->EOF) {
			$this->components[$rs->fields['pageid']][$rs->fields['itemid']] = new pageComponent($rs->fields);
			$rs->MoveNext();
		}
	}

	function _compileCards() {
		$rs = CMS_libs_Cards::getCardsBySite($this->site->get('siteId'));
		while ($rs && !$rs->EOF) {
			$siteCatalystRs = CMS_libs_SiteCatalystIndividualCards::getPageVarValues($rs->fields['id']);

			while (!$siteCatalystRs->EOF) {
				$rs->fields[SITECATALYST_VAR_IDENTIFIER][$siteCatalystRs->fields['var_name']] = $siteCatalystRs->fields['var_value'];

				$siteCatalystRs->MoveNext();
			}

            // add card categories to result set
            $cardCategories = CMS_libs_Cards::getCategoryListByCardId($rs->fields['cardId']);
            $rs->fields['card_categories'] = $cardCategories->fields['card_categories'];

            $this->cards[$rs->fields('cardpageId')][$rs->fields['cardId']] = new card($rs->fields);

            $rs->MoveNext();
		}

		$rs = CMS_libs_Cards::getOrphanedCardsBySite($this->site->get('siteId'));
		while ($rs && !$rs->EOF) {
			//echo "adding card: " . $rs->fields['cardId'] . "<br/>";
			$this->orphanedCards[$rs->fields['cardId']] = new card($rs->fields);
			$rs->MoveNext();
		}
	}

	function _compileMerchantServices() {
		foreach ($this->merchantServicePages as $page) {
			$rs = CMS_libs_MerchantServices::getMerchantServicesByPage($page->get('cardpageId'), $this->site->get('siteId'));
			while ($rs && !$rs->EOF) {
				//get merchant services for page
				// first, get the site catalyst variable data
				$siteCatalystRs = CMS_libs_SiteCatalystMerchantService::getPageVarValues($rs->fields['merchant_service_detail_id']);

				while (!$siteCatalystRs->EOF) {
					$rs->fields[SITECATALYST_VAR_IDENTIFIER][$siteCatalystRs->fields['var_name']] = $siteCatalystRs->fields['var_value'];

					$siteCatalystRs->MoveNext();
				}

				$this->merchantServices[$page->get('cardpageId')][] = new merchantService($rs->fields);
				$rs->MoveNext();
			}
			//get merchant services for each subpage
			if (is_array($this->subPages[$page->get('cardpageId')])) {
				foreach ($this->subPages[$page->get('cardpageId')] as $subPage) {
					//check that page is not already added
					if (!array_key_exists($subPage->get('cardpageId'), $this->cardPages) && !array_key_exists($subPage->get('cardpageId'), $this->subPages)) {
						$rs2 = CMS_libs_MerchantServices::getMerchantServicesByPage($subPage->get('cardpageId'), $this->site->get('siteId'));
						while ($rs2 && !$rs2->EOF) {

							$siteCatalystRs = CMS_libs_SiteCatalystMerchantService::getPageVarValues($rs2->fields['merchant_service_detail_id']);

							while (!$siteCatalystRs->EOF) {
								$rs2->fields[SITECATALYST_VAR_IDENTIFIER][$siteCatalystRs->fields['var_name']] = $siteCatalystRs->fields['var_value'];

								$siteCatalystRs->MoveNext();
							}

							$this->merchantServices[$subPage->get('cardpageId')][] = new merchantService($rs2->fields);
							$rs2->MoveNext();
						}
					} else {
						echo "Skipping: " . $subPage->get('pageName') . "<hr>";
					}
				}
			}
		}
	}

	function _compileMerchantServiceApplications() {
		foreach ($this->merchantServiceApplicationPages as $page) {
			$rs = CMS_libs_MerchantServices::getMerchantServicesByPage($page->get('cardpageId'), $this->site->get('siteId'));
			while ($rs && !$rs->EOF) {
				//get merchant services for page
				// first, get the site catalyst variable data
				$siteCatalystRs = CMS_libs_SiteCatalystMerchantService::getPageVarValues($rs->fields['merchant_service_detail_id']);

				while (!$siteCatalystRs->EOF) {
					$rs->fields[SITECATALYST_VAR_IDENTIFIER][$siteCatalystRs->fields['var_name']] = $siteCatalystRs->fields['var_value'];

					$siteCatalystRs->MoveNext();
				}

				$this->merchantServices[$page->get('cardpageId')][] = new merchantService($rs->fields);
				$rs->MoveNext();
			}

			//get merchant services for each subpage
			if (is_array($this->subPages[$page->get('cardpageId')])) {
				foreach ($this->subPages[$page->get('cardpageId')] as $subPage) {
					//check that page is not already added
					if (!array_key_exists($subPage->get('cardpageId'), $this->cardPages) && !array_key_exists($subPage->get('cardpageId'), $this->subPages)) {
						$rs2 = CMS_libs_MerchantServices::getMerchantServicesByPage($subPage->get('cardpageId'), $this->site->get('siteId'));
						while ($rs2 && !$rs2->EOF) {

							$siteCatalystRs = CMS_libs_SiteCatalystMerchantService::getPageVarValues($rs2->fields['merchant_service_detail_id']);

							while (!$siteCatalystRs->EOF) {
								$rs2->fields[SITECATALYST_VAR_IDENTIFIER][$siteCatalystRs->fields['var_name']] = $siteCatalystRs->fields['var_value'];

								$siteCatalystRs->MoveNext();
							}

							$this->merchantServices[$subPage->get('cardpageId')][] = new merchantService($rs2->fields);
							$rs2->MoveNext();
						}
					} else {
						echo "Skipping: " . $subPage->get('pageName') . "<hr>";
					}
				}
			}
		}
	}

	function _compileSpecials() {
		foreach ($this->specialsPages as $page) {

			$rs = CMS_libs_Specials::getManuallyAddedSpecialsCardsByIdAndSite($page->get('cardpageId'), $this->site->get('siteId'));


			while ($rs && !$rs->EOF) {
				$this->cards[$page->get('cardpageId')][] = new card($rs->fields);
				$rs->MoveNext();
			}
		}
	}

	function _compileProfiles() {
		foreach ($this->profilePages as $page) {
			$page->profile_data = CMS_libs_Profiles::getProfileByIdAndSite($page->get('cardpageId'), $this->site->get('siteId'));

			$page->cardCategory1 = CMS_libs_Profiles::getCardCategoryDetails($page->profile_data->fields('card_category_1'));
			$page->cardCategory2 = CMS_libs_Profiles::getCardCategoryDetails($page->profile_data->fields('card_category_2'));
			$page->cardCategory3 = CMS_libs_Profiles::getCardCategoryDetails($page->profile_data->fields('card_category_3'));

			$page->tagCategory1 = CMS_libs_Profiles::getCardCategoryDetails($page->profile_data->fields('tag_category_1'));
			$page->tagCategory2 = CMS_libs_Profiles::getCardCategoryDetails($page->profile_data->fields('tag_category_2'));
			$page->tagCategory3 = CMS_libs_Profiles::getCardCategoryDetails($page->profile_data->fields('tag_category_3'));

			//Now using tag categories to display popular picks, instead of pages
//        	$page->popularCards = CMS_libs_Profiles::getPopularCardsByCategoryAndSite(
//        							$page->profile_data->fields('card_category_1'),
//        							$page->profile_data->fields('card_category_2'),
//        							$page->profile_data->fields('card_category_3'),
//        							$this->site->get('siteId')
//        							);

			$page->popularCards = CMS_libs_Profiles::getPopularCardsByTags(
					$page->profile_data->fields('tag_category_1'), $page->profile_data->fields('tag_category_2'), $page->profile_data->fields('tag_category_3')
			);

			//Get top card in #1 category, if cat is empty try #2, then #3
			$rs = CMS_libs_Profiles::getTopCardByProfileIdAndSite($page->profile_data->fields('card_category_1'), $this->site->get('siteId'));
			if ($rs->EOF)
				$rs = CMS_libs_Profiles::getTopCardByProfileIdAndSite($page->profile_data->fields('card_category_2'), $this->site->get('siteId'));
			if ($rs->EOF)
				$rs = CMS_libs_Profiles::getTopCardByProfileIdAndSite($page->profile_data->fields('card_category_3'), $this->site->get('siteId'));

			$page->top_card_data = $rs;
			$page->top_card_data->card = new card($rs->fields);

			//echo "dumping: <br/>";
			//echo var_dump($rs);
		}

		if (sizeof($this->profilePages) > 0) {
			//Build index page
			$this->site->profiles_index_data = CMS_libs_Profiles::getProfilesDataForIndexPage();
		} else {
			$this->site->profiles_index_data = null;
		}
	}

	function _compileRedirects() {
		//first compile the statically defined redirects
		$this->redirects = CMS_libs_Redirect::getBySite($this->site->get('siteId'));
	}

	function _compileSite() {
		foreach ($this->cardPages as $index => $page) {

			if (!isset($this->cards[$page->get('cardpageId')])) {
				$this->cards[$page->get('cardpageId')] = array();
			}
			$this->cardPages[$index]->addCards($this->cards[$page->get('cardpageId')]);

			$subPageArray = array();
			if (isset($this->subPages[$page->get('cardpageId')]) && is_array($this->subPages[$page->get('cardpageId')]))
				foreach ($this->subPages[$page->get('cardpageId')] as $page2) {
					$page2->addCards($this->cards[$page2->get('cardpageId')]);
					$subPageArray[] = $page2;
				}

			if (!isset($this->components[$page->get('cardpageId')])) {
				$this->components[$page->get('cardpageId')] = array();
			}
			$this->cardPages[$index]->addComponents($this->components[$page->get('cardpageId')]);

			$this->cardPages[$index]->addSubPages($subPageArray);

			$subPageArray = array();
		}

		foreach ($this->merchantServicePages as $index => $page) {
			$this->merchantServicePages[$index]->addMerchantServices($this->merchantServices[$page->get('cardpageId')]);

			if (is_array($this->subPages[$page->get('cardpageId')])) {
				foreach ($this->subPages[$page->get('cardpageId')] as $page2) {
					$page2->addMerchantServices($this->merchantServices[$page2->get('cardpageId')]);
					$subPageArray[] = $page2;
				}
			}

			$this->merchantServicePages[$index]->addComponents($this->components[$page->get('cardpageId')]);
			$this->merchantServicePages[$index]->addSubPages($subPageArray);
			$subPageArray = array();
		}

		foreach ($this->merchantServiceApplicationPages as $index => $page) {
			$this->merchantServiceApplicationPages[$index]->addMerchantServices($this->merchantServices[$page->get('cardpageId')]);

			if (is_array($this->subPages[$page->get('cardpageId')])) {
				foreach ($this->subPages[$page->get('cardpageId')] as $page2) {
					$page2->addMerchantServices($this->merchantServiceApplicationPages[$page2->get('cardpageId')]);
					$subPageArray[] = $page2;
				}
			}

			$this->merchantServiceApplicationPages[$index]->addComponents($this->components[$page->get('cardpageId')]);
			$this->merchantServiceApplicationPages[$index]->addSubPages($subPageArray);
			$subPageArray = array();
		}



		foreach ($this->specialsPages as $index => $page) {
			$this->specialsPages[$index]->addCards($this->cards[$page->get('cardpageId')]);

			if (!isset($this->components[$page->get('cardpageId')])) {
				$this->components[$page->get('cardpageId')] = array();
			}

			$this->specialsPages[$index]->addComponents($this->components[$page->get('cardpageId')]);
		}

		foreach ($this->profilePages as $index => $page) {
			$this->profilePages[$index]->addComponents($this->components[$page->get('cardpageId')]);
		}

		$this->site->addCardPages($this->cardPages);
		$this->site->addOrphanedCards($this->orphanedCards);
		$this->site->addMerchantServicePages($this->merchantServicePages);
		$this->site->addMerchantServiceApplicationPages($this->merchantServiceApplicationPages);
		$this->site->addSpecialsPages($this->specialsPages);
		$this->site->addProfilePages($this->profilePages);
		$this->site->addIndexPages($this->indexPages);
		$this->site->addRedirects($this->redirects);
	}

	function displaySiteStructure() {


		$level1 = "&nbsp;";
		$level2 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		$level3 = $level2 . $level2;
		$pages = $this->site->getCardPages();

		$message = "<br><b><u>" . $level1 . addslashes($this->site->get('siteName')) . "</b></u><br>";
		foreach ($pages as $page) {
			$message .= "<i><b>" . $level2 . addslashes($page->get('pageName')) . "</i></b><br>";
			$cards = $page->getCards();
			$subPages = $page->getSubPages();
			foreach ($cards as $card) {
				$message .= $level3 . addslashes($card->get('cardTitle')) . "<br>";
			}
			foreach ($subPages as $subPage) {
				$message .= "<i><b>" . $level2 . addslashes($subPage->get('pageName')) . "</i></b><br>";
				$subPageCards = $subPage->getCards();
				foreach ($subPageCards as $subPageCard) {
					$message .= $level3 . addslashes($subPageCard->get('cardTitle')) . "<br>";
				}
			}
		}
		//_setMessage($message);
	}

}
