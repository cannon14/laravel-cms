<?php

/**
 * CreditCards.com
 * 3/15/2007
 *
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 *
 * @package CMS_Lib
 */
csCore_Import::importClass('CMS_libs_siteComponents');
csCore_Import::importClass('CMS_libs_SiteManipulator');
csCore_Import::importClass('CMS_libs_MergeFilter');
csCore_Import::importClass('CMS_libs_MerchantServiceMergeFilter');
csCore_Import::importClass('CMS_libs_Pagination');
//csCore_Import::importClass('CMS_libs_Articles');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('csCore_Util_shExecuter');
csCore_Import::importClass('CMS_libs_CardPlacementSnapshot');
csCore_Import::importClass('CMS_libs_Merchants');
csCore_Import::importClass('CMS_libs_PageIdGenerator');
csCore_Import::importClass('CMS_libs_PublishHistory');
csCore_Import::importClass('CMS_libs_ApiClient');

define("BUILD_SUB_PAGES", false);


class CMS_libs_SitePublisher extends CMS_libs_SiteManipulator {

    var $sourceDir;
    var $destDir;
    var $sitemap = array();
    var $publishDate;
    var $googleSeo;
    var $uniquePages = array();
    var $catListHandle;
    var $merchListHandle;
    var $specialsListHandle;
    var $indCardListHandle;
    var $indMerchListHandle;
    var $auth;
    var $_historyWriter;
    var $siteAIDMap = array('cccom' => 1017, 'cccomsp' => 3017, 'cccomuk' => 2017);
    var $pageCIDMap = array('card' => 10000, 'no-credit-history.php' => 1424, 'barclays.php' => 1396, 'orchard-bank.php' => 1397, 'low-interest.php' => 1002, 'low-interest-page-2.php' => 1002, 'balance-transfer.php' => 1005, 'balance-transfer-page-2.php' => 1005, 'instant-approval.php' => 1010, 'instant-approval-page-2.php' => 1010, 'reward.php' => 1015, 'reward-page-2.php' => 1015, 'reward-page-3.php' => 1015, 'points-rewards.php' => 1326, 'retail-rewards.php' => 1327, 'gas-cards.php' => 1328, 'travel-rewards.php' => 1329, 'home-improvement-rewards.php' => 1331, 'cash-back.php' => 1020, 'cash-back-page-2.php' => 1020, 'airline-miles.php' => 1025, 'business.php' => 1030, 'college-students.php' => 1035, 'prepaid.php' => 1040, 'bad-credit.php' => 1045, 'good-credit.php' => 1294, 'good-credit-page-2.php' => 1294, 'excellent-credit.php' => 1295, 'excellent-credit-page-2.php' => 1295, 'excellent-credit-page-3.php' => 1295, 'fair-credit.php' => 1293, 'Advanta.php' => 1050, 'American-Express.php' => 1055, 'Bank-of-America.php' => 1060, 'bankone.php' => 1065, 'Capital-One.php' => 1067, 'Chase.php' => 1070, 'Citi.php' => 1075, 'Discover.php' => 1080, 'first-premier.php' => 1085, 'First-National.php' => 1087, 'Household-Bank.php' => 1090, 'GE Money.php' => 1093, 'Visa.php' => 1095, 'HSBC-Bank.php' => 10007, 'orchard-bank.php' => 1397, 'Mastercard.php' => 1096, 'intereses-bajos.php' => 1002, 'periodo-sin-interes.php' => 1398, 'traslado-de-saldos.php' => 1005, 'aprobacion-instantanea.php' => 1010, 'recompensa.php' => 1015, 'evolucion-de-dinero.php' => 1020, 'viajes.php' => 1025, 'prepaid.php' => 1040, 'credito-excelente.php' => 1295, 'buen-credito.php' => 1294, 'credito-regular.php' => 1293, 'visa.php' => 1095, 'mastercard.php' => 1096, 'bank-of-america.php' => 1060, 'chase.php' => 1070, 'citi.php' => 1075);

    function _debugStamp($descriptor) {
        static $ts = NULL;

        /* set true to enable time stamp debugging */
        if (FALSE) {
            if ($ts === NULL) {
                $ts = time();
            }
            echo sprintf('%s%3.0f</p>', $descriptor, (time() - $ts));
            $ts = time();
        }
    }

    /**
     * Initiates the publishing of an entire site
     * @author  Jason Huie
     * @version 2.0
     */
    function build() {

        // FA 0026148 - Including Kvikkendierty style benchmarking
        $this->_debugStamp("[START] - CMS_libs_SitePublisher build() - ");

        csCore_Import::importLang(($this->site->get('language') . '.inc.php'));

        $defaultSourcePath = $this->settings->getSetting('CMS_source');
        $defaultPublishPath = $this->settings->getSetting('CMS_publish');

        $this->sourceDir = $defaultSourcePath . $this->site->get('sourcePath');
        $this->destDir = $defaultPublishPath . $this->site->get('publishPath');

        if ($this->site->get('createSeoDoc')) { // create SEO document
            $siteAid = $this->_getSiteAid($this->site->get('layout'));

            //create our document for google SEO
            $this->_debugStamp("(((google SEO)))");
            $this->googleSeo = & csCore_Import::instanciateObject('CMS_layouts_seolayouts_google_' . $this->site->get('layout') . 'GoogleSeoLayout');
            $this->googleSeo->writeHeader();
            $this->googleSeo->writeStaticData();

            //create our document for yahoo SEO (articles)
            $this->_debugStamp("(((yahoo SEO)))");
            $this->yahooArticlesSeo = & csCore_Import::instanciateObject('CMS_layouts_seolayouts_yahoo_YahooSeoLayout');
            $this->yahooArticlesSeo->setSite($this->site->get('layout'));
            //$this->yahooArticlesSeo->writeHeader();
            $this->yahooArticlesSeo->writeStaticData();

            //create our document for yahoo SEO (article categories)
            $this->_debugStamp("(((yahoo SEO articles)))");
            $this->yahooArticleCategoriesSeo = & csCore_Import::instanciateObject('CMS_layouts_seolayouts_yahoo_YahooSeoLayout');
            $this->yahooArticleCategoriesSeo->setSite($this->site->get('layout'));
            //$this->yahooArticleCategoriesSeo->writeHeader();
            $this->yahooArticleCategoriesSeo->writeStaticData();

            //create our document for yahoo SEO (card category pages)
            $this->_debugStamp("(((yahoo SEO cats)))");
            $this->yahooCategoriesSeo = & csCore_Import::instanciateObject('CMS_layouts_seolayouts_yahoo_YahooSeoLayout');
            $this->yahooCategoriesSeo->setSite($this->site->get('layout'));
            $this->yahooCategoriesSeo->setAID($siteAid);

            // cid get changed/set for each card category page and so is done in card cat page loop
            $this->_debugStamp("(((yahoo SEO cat static)))");
            $this->yahooCategoriesSeo->writeHeader();
            $this->yahooCategoriesSeo->writeStaticData();

            //create our document for yahoo SEO (card pages)
            $this->_debugStamp("(((yahoo SEO cards)))");
            $pageCid = $this->_getPageCid('card');

            $this->yahooCardsSeo = & csCore_Import::instanciateObject('CMS_layouts_seolayouts_yahoo_YahooSeoLayout');
            $this->yahooCardsSeo->setSite($this->site->get('layout'));
            $this->yahooCardsSeo->setAID($siteAid);
            $this->yahooCardsSeo->setCID($pageCid); // cid is constant for card pages
            $this->yahooCardsSeo->writeHeader();
            $this->yahooCardsSeo->writeStaticData();

            //create our document for yahoo SearchMonkey
            $this->_debugStamp("(((yahoo searchmunkey)))");
            $this->yahooSearchMonkeySeo = & csCore_Import::instanciateObject('CMS_layouts_seolayouts_yahoo_' . $this->site->get('layout') . 'YahooSearchMonkeySeoLayout');
            $this->yahooSearchMonkeySeo->writeHeader();
            $this->yahooSearchMonkeySeo->writeStaticData();
        }

        //$_REQUEST['fullPublish']?$this->publishDate='0':$this->publishDate=$this->site->get('dateLastBuilt');
        //We need to start the sitemap here because each section will write to the sitemap after it builds the page
        //This is because there are at least 2 styles of printing in the sitemap so every page type needs to define its style
        if ($this->site->get('sitemap')) {
            $this->_debugStamp("(((sitemap intro)))");
            $this->map = & csCore_Import::instanciateObject('CMS_layouts_genericpagelayouts_' . $this->site->get('layout') . 'GenericPageLayout');
            $this->map->writeHeader(new generic(array('title' => $this->site->get('siteName') . ' - ' . LANG_SITE_MAP)));
            $this->map->writeSubHeader($this->site->get('layout') . '/sitemap_sub_header', LANG_SEARCH_CREDIT_CARDS);
        }

        if (!$this->_preBuildSanityCheck()) {
            _setMessage("Pre build sanity check failed.  Build aborted.", TRUE);
            return FALSE;
        }

        if ($this->site->get('corePath') != '') {
            $this->_moveStaticContent($this->site->get('corePath'), $this->destDir);
        }

        $this->_debugStamp("(((buildIndexPage)))");
        $this->_buildIndexPage();
        $this->_debugStamp("(((_moveStaticContent)))");
        $this->_moveStaticContent($this->sourceDir, $this->destDir);
        $this->_debugStamp("(((_moveCardImages)))");
        $this->_moveCardImages();
        $this->_debugStamp("(((_buildRedirects)))");
        $this->_buildRedirects();

        $this->_debugStamp("(((sitesearch URLS)))");
        $this->catListHandle = fopen($this->destDir . '/sitesearch/urls/cards/categoryList.txt', 'w');
        $this->merchListHandle = fopen($this->destDir . '/sitesearch/urls/merchant_services/merchList.txt', 'w');
        $this->specialsListHandle = fopen($this->destDir . '/sitesearch/urls/cards/specialsList.txt', 'w');
        $this->indCardListHandle = fopen($this->destDir . '/sitesearch/urls/cards/indCardList.txt', 'w');
        $this->indMerchListHandle = fopen($this->destDir . '/sitesearch/urls/merchant_services/indMerchList.txt', 'w');

        /* FA0020984 - Custom AMEX Pages
          Moved _buildLandingPages() up in the process because another function
          has side effects causing the words "site map" to appear in the title. */

        $this->_debugStamp("(((_buildLandingPages)))");
        if ($this->site->get('landingPageDir')) {
            $this->_buildLandingPages();
        }
        /* for cccomus "skinny" pages (tabular layout) 
          This has to go before _buildCardPages, because the _buildCardPages some how resets the
          damn page titles to be the site map titles. I have no idea how, or where, so I'm giving up and
          just putting this first. */

        $this->_debugStamp("(((action_of_somesort)))");
        if ($this->site->get('alternativecardpages')) {
            $this->_buildAlternativeCardPages();
        }

        $this->_debugStamp("(((CMS_libs_PublishHistory)))");
        $this->_historyWriter = new CMS_libs_PublishHistory($this->site->get('siteId'), 0);

        $this->_debugStamp("(((_buildCardPages)))");
        $this->_buildCardPages();
        $this->_debugStamp("(((_buildMerchantServicePages)))");
        $this->_buildMerchantServicePages();
        $this->_debugStamp("(((_buildMerchantServiceApplicationPages)))");
        $this->_buildMerchantServiceApplicationPages();
        $this->_debugStamp("(((_buildSpecialsPages)))");
        $this->_buildSpecialsPages();
        //This has been unofficially retired.
        //$this->_debugStamp("(((_buildProfilePages)))");
        //$this->_buildProfilePages();
        $this->_debugStamp("(((_moveLandingPageFiles)))");
        $this->_moveLandingPageFiles();
        $this->_debugStamp("(((_moveOldArtciles)))");
        $this->_moveOldArtciles();

        $this->_debugStamp("(((_historyWriter->save)))");
        $this->_historyWriter->save();

        $this->_debugStamp("(((_buildIndividualCardPages)))");
        if ($this->site->get('individualcards')) {
            $this->_buildIndividualCardPages();
        }

        $this->_debugStamp("(((_buildIndividualMerchantServicesPages)))");
        if ($this->site->get('individualmerchantservices')) {
            $this->_buildIndividualMerchantServicesPages();
        }

        $this->_debugStamp("(((POST-BUILD)))");
        if ($this->site->get('postBuildScript')) {
            $executer = new csCore_Util_shExecuter($this->site->get('postBuildScript'));
            $executer->execute();
            print '<center><div class="postBuild">
         			<h1>POST-BUILD OUTPUT</h1>' . $executer->getOutput() . '
                </div></center><br>';
        }

        //Here we end the sitemap and write it to file
        $this->_debugStamp("(((_addArticlesToSiteMap)))");
        if ($this->site->get('sitemap')) {
            $this->_addArticlesToSiteMap();

            $this->map->writeSubFooter($this->site->get('layout') . '/sitemap_sub_footer');
            // for the site map, push site catalyst variables to it's footer tpl.  All
            // site maps (UK, SP, CA, etc) should get these same variable values.  None of
            // the sister sites should have these page variables, this code relies on the fact
            // that none of those sites implement a site map.  - mz
            // $this->map->writeFooter(new generic(array('title'=>$this->site->get('siteName').' - Site Map')));
            $siteCatalystData = $this->_getSiteMapPageVariables();
            $this->map->writeFooterWithSiteCatalystData(new generic(array('title' => $this->site->get('siteName') . ' - Site Map')), $siteCatalystData);

            $this->map->writeBufferedOutput($this->destDir . "/" . $this->site->get('sitemaplink') . "." . $this->site->get('pagetype'));

            if ($this->site->get('createSeoDoc')) {
                $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $this->site->get('sitemaplink') . '.' . $this->site->get('pagetype'), 'daily', '0.5');
            }
        }

        $this->_debugStamp("(((createSeoDoc)))");
        if ($this->site->get('createSeoDoc')) {
            //close our SEO pages
            $this->_addArticlesToGoogleXML();
            $this->googleSeo->writeFooter();
            $this->googleSeo->writeBufferedOutput($this->destDir . "/" . GOOGLE_XML_FILENAME);

            $this->_addArticlesToYahooTxt();
            $this->yahooArticlesSeo->writeFooter();
            $this->yahooArticlesSeo->writeBufferedOutput($this->destDir . '/' . YAHOO_ARTICLE_FILENAME);

            $this->_addArticleCategoriesToYahooTxt();
            $this->yahooArticleCategoriesSeo->writeFooter();
            $this->yahooArticleCategoriesSeo->writeBufferedOutput($this->destDir . '/' . YAHOO_ARTICLE_CATEGORY_FILENAME);

            $this->yahooCategoriesSeo->writeFooter();
            $this->yahooCategoriesSeo->writeBufferedOutput($this->destDir . '/' . YAHOO_CATEGORY_FILENAME);

            $this->yahooCardsSeo->writeFooter();
            $this->yahooCardsSeo->writeBufferedOutput($this->destDir . '/' . YAHOO_CARD_FILENAME);

            $this->yahooSearchMonkeySeo->writeFooter();
            $this->yahooSearchMonkeySeo->writeBufferedOutput($this->destDir . '/' . YAHOO_SEARCHMONKEY_FILENAME);
        }

        fclose($this->catListHandle);
        fclose($this->merchListHandle);
        fclose($this->specialsListHandle);
        fclose($this->indCardListHandle);
        fclose($this->indMerchListHandle);

        //record actions
        $this->auth = & csCore_import::instanciateSingleton('csCore_Authentication_authentication');
        CMS_libs_Sites::setPublishedDate($this->site->get('siteId'));
        CMS_libs_History::write($this->auth->username, "Published Site to CCBuild: " . $this->site->get('siteName'));
        CMS_libs_CardPlacementSnapshot::recordState($this->site->get('siteId'));
        CMS_libs_History::write($this->auth->username, "Recorded State: " . $this->site->get('siteName'));

        $this->_debugStamp("[_END_] - CMS_libs_SitePublisher build() - ");
    }

    /**
     * Builds cardpages
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildCardPages() {
        $siteMapCategory = LANG_SEARCH_CREDIT_CARDS;
        $merger = new CMS_libs_MergeFilter();
        $pages = $this->site->getCardPages();
        $sitemapPages = array();

        foreach ($pages as $page) {

            if ($page->get('sitemapLink')) {
                $this->sitemap[$page->get('cardpageId')] = array();
            }
            $pageNumber = 1;

            $overallRank = 1;
            $counter = 1;

            $contents = array();
            //$subPages = $page->getSubPages();
            $cards = $page->getCards();
            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
            $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	        $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
            $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'), $prevNextLinks, $canonicalTag);
            $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page) : NULL;
            if ($pageNumber == 1) {
                $bufferedPage->writeSubHeader($page, '', $subPageNav, 'true', TRUE);
            }
            else {
                $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);
            }

            $topcard = '';

            foreach ($cards as $card) {

                if ($card->get('active') == 1) {
                    if ($page->get('sitemapLink')) {
                        $sitemapPages[$page->get('cardpageId')][$card->get('cardId')] = $card->get('cardTitle') . '::' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink');
                    }

                    $cardData = array();
                    foreach ($card->cardDetail as $header => $detail) {
                        $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                    }
                    //add cardpage
                    if (!$bufferedPage) {
                        $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                        $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                    $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'), $prevNextLinks, $canonicalTag);
                        $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page) : NULL;
                        $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);
                    }
                    $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties, $pageNumber);
                    $this->_historyWriter->addPublishState($page->get('fid'), $overallRank, $page->get('cardpageId'), $overallRank, $pageNumber, $card->get('cardId'));


                    // pagination
                    // added code to aid in rendering correct card count on first page
                    // vs. subsequent pages.  - mz 1/3/08
                    if ($pageNumber == 1) {
                        if ($topcard == '') {
                            $topcard = $card->get('cardLink');
                        }

                        // if only the main category should show on the 1st page, then we check 2 things:
                        // 1) if the number of cards designated to show on the 1st page has come, or
                        // 2) if the number of assigned cards to the main category has already come.  - mz 1/8/08
                        if ($page->properties['showMainCatOnFirstPage'] == 1 && ($counter % $page->properties['itemsOnFirstPage'] == 0 || $counter >= count($cards))) {
                            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, NULL);
                            $bufferedPage->writeFooter($page, $pageNumber);
                            $contents[] = $bufferedPage;
                            $pageNumber++;
                            $bufferedPage = NULL;
                        }
                        // otherwise we keep going till the # of cards designated for the 1st
                        // page expires.  - mz 1/8/08
                        else if ($counter % $page->properties['itemsOnFirstPage'] == 0) {
                            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, NULL);
                            $bufferedPage->writeFooter($page, $pageNumber);
                            $contents[] = $bufferedPage;
                            $pageNumber++;
                            $bufferedPage = NULL;
                        }
                    }
                    else if ($counter % $page->properties['itemsPerPage'] == 0) {
                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                        $bufferedPage->writeFooter($page, $pageNumber);
                        $contents[] = $bufferedPage;
                        $pageNumber++;
                        $bufferedPage = NULL;
                    }
                    $counter++;
                    $overallRank++;
                }
            }

            //sub-pages
            if(BUILD_SUB_PAGES) {
                foreach ($subPages as $subPage) {
                    if (!$subPage->get('hide') && $subPage->getActiveCardCount() > 0) {
                        if (!$bufferedPage) {
                            $bufferedPage = &csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                            $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                        $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                            $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'), $prevNextLinks, $canonicalTag);
                        }
                        $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page, $subPage) : NULL;
                        $bufferedPage->writeSubHeader($subPage, '', $subPageNav, FALSE);
                        $merger = new CMS_libs_MergeFilter();
                        $cards = $subPage->getCards();

                        $subpageRank = 1;

                        foreach ($cards as $card) {
                            if ($card->get('active') == 1) {
                                if ($page->get('sitemapLink')) {
                                    $sitemapPages[$page->get('cardpageId')][$card->get('cardId')] = $card->get('cardTitle') . '::' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink');

                                }
                                //add card page
                                if (!$bufferedPage) {
                                    $bufferedPage = &csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                                    $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                                $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                                    $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'), $prevNextLinks, $canonicalTag);
                                    $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page, $subPage) : NULL;
                                    $bufferedPage->writeSubHeader($subPage, $pageNav, $subPageNav, TRUE);
                                }

                                $cardData = array();
                                foreach ($card->cardDetail as $header => $detail) {
                                    $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                                }

                                $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties);
                                $this->_historyWriter->addPublishState($page->get('fid'), $overallRank, $subPage->get('cardpageId'), $subpageRank, $pageNumber, $card->get('cardId'));

                                //pagination
                                if ($pageNumber == 1) {
                                    if ($topcard == '') {
                                        $topcard = $card->get('cardLink');
                                    }

                                    // if only the main category should show on the 1st page, then we check 2 things:
                                    // 1) if the number of cards designated to show on the 1st page has come, or
                                    // 2) if the # of actual cards assigned to the 1st page has already come.  - mz 1/8/08
                                    if ($page->properties['showMainCatOnFirstPage'] == 1 && ($counter % $page->properties['itemsOnFirstPage'] == 0 || $counter >= count($cards))) {
                                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                        $bufferedPage->writeFooter($page, $pageNumber);
                                        $contents[] = $bufferedPage;
                                        $pageNumber++;
                                        $bufferedPage = NULL;
                                        $counter = 0;
                                    }
                                    // otherwise we keep going till the # of cards designated for the 1st
                                    // page expires.  - mz 1/8/08
                                    else {
                                        if ($counter % $page->properties['itemsOnFirstPage'] == 0) {
                                            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                            $bufferedPage->writeFooter($page, $pageNumber);
                                            $contents[] = $bufferedPage;
                                            $pageNumber++;
                                            $bufferedPage = NULL;
                                            $counter = 0;
                                        }
                                    }
                                }
                                else {
                                    if ($counter % $page->properties['itemsPerPage'] == 0) {
                                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                        $bufferedPage->writeFooter($page, $pageNumber);
                                        $contents[] = $bufferedPage;
                                        $pageNumber++;
                                        $bufferedPage = NULL;
                                    }
                                }
                                $counter++;
                                $subpageRank++;
                                $overallRank++;
                            }
                        }
                    }
                }
            }//BUILD SUB PAGES.


            //save page
            if ($bufferedPage) {
                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, NULL);
                $bufferedPage->writeFooter($page, $pageNumber);
                $contents[] = $bufferedPage;
            }

            //publish pages
            for ($x = 0; $x < sizeof($contents); $x++) {

                $filename = $x == 0 ? $page->get('pageLink') . "." . $this->site->get('pagetype') : $page->get('pageLink') . "-page-" . ($x + 1) . "." . $this->site->get('pagetype');

	            if ($filename == '.php') {
		            continue;
	            }

                $contents[$x]->writeBufferedOutput($this->destDir . "/" . $filename);
                fwrite($this->catListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

                if ($this->site->get('createSeoDoc') && $page->get('sitemapLink') && !in_array($this->site->get('publishurl') . '/' . $filename, $this->uniquePages)) {
                    $this->uniquePages[] = $this->site->get('publishurl') . '/' . $filename;
                    $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $filename, 'weekly', '0.5');

                    $pageCID = $this->_getPageCID($filename);

                    //Only add category pages to the yahoo feed if they contain at least one active card
                    $pageHasCards = 0;
                    $pageCards = $page->getCards();
                    foreach ($pageCards as $card) {
                        if ($card->get('active') == 1) {
                            $this->yahooCategoriesSeo->writeEntryMeta($this->site->get('publishurl') . '/' . $filename, $page->getTitle(), $page->getPageMeta(), NULL, $pageCID);
                            break;
                        }
                    }
                    //if ($pageHasCards)

                    if ($x == 0) // only creating searchmonkey for first page
                    {
                        $this->yahooSearchMonkeySeo->writeCategoryEntry($this->site->get('publishurl') . '/' . $filename, $page, $topcard);
                    }
                }
            }
        }

        //write to sitemap
        if ($this->site->get('sitemap')) {
            $this->_buildSiteMap($siteMapCategory, $sitemapPages, 'sitemap_listing');
        }
    }

    /**
     * Builds Merchant Account Pages
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildMerchantServicePages() {
        $pages = $this->site->getMerchantServicePages();

        if (sizeof($pages) > 0) {
            $siteMapCategory = LANG_SEARCH_MERCHANT_ACCOUNTS;
            $merger = new CMS_libs_MerchantServiceMergeFilter();
            $this->sitemap[$siteMapCategory] = array();
        }

        foreach ($pages as $page) {
            //       $articles = $page->getArticles();
            $sitemapPages[$page->get('cardpageId')] = array();
            $pageNumber = 1;
            $counter = 1;
            $contents = array();
            $subPages = $page->getSubPages();
            $services = $page->getMerchantServices();
            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
            $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	        $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);

            $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));
            $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page) : NULL;

            $pageNumber == 1 ? $bufferedPage->writeSubHeader($page, '', $subPageNav) : $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);

            foreach ($services as $service) {
                $sitemapPages[$page->get('cardpageId')][$service->get('merchant_service_id')] = $service->get('merchant_service_name') . '::' . $this->site->get('individualmerchantservicesdir') . '/' . $service->get('merchant_service_link');
                foreach ($service->merchantServiceDetail as $header => $detail) {
                    $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));

                    //tack on trailing zero if looks like: $0.3
                    $serviceData[$header] = preg_replace('/(\$[0-9]+\.[0-9])([\*]*)$/', '${1}0$2', $serviceData[$header]);

                    //tack on trailing zero to % rates if looks like: as low as 1.6%
                    $serviceData[$header] = preg_replace('/(.*[0-9]+[\.][0-9])%([\*]*)$/', '${1}0%$2', $serviceData[$header]);
                }
                //  $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));
                //add merchant service page
                if (!$bufferedPage) {
                    $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
                    $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                    $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));

                    $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page) : NULL;

                    $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);
                }

                $bufferedPage->writeMerchantService($page, $service, $serviceData, $counter, $this->site->properties);

                //pagination
                if ($counter % $page->properties['itemsPerPage'] == 0) {
                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                    $bufferedPage->writeFooter($page);
                    $contents[] = $bufferedPage;
                    $pageNumber++;
                    $bufferedPage = NULL;
                }
                $counter++;
            }

            //sub-pages       
            foreach ($subPages as $subPage) {

                if (!$bufferedPage) {
                    $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                    $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));
                }

                $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page, $subPage) : NULL;

                $bufferedPage->writeSubHeader($subPage, '', $subPageNav, FALSE);

                $merger = new CMS_libs_MerchantServiceMergeFilter();
                $services = $subPage->getMerchantServices();

                foreach ($services as $service) {
                    $sitemapPages[$page->get('cardpageId')][$service->get('merchant_service_id')] = $service->get('merchant_service_name') . '::' . $this->site->get('individualmerchantservicesdir') . '/' . $service->get('merchant_service_link');
                    //add card page
                    if (!$bufferedPage) {
                        $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
                        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));

                        $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page, $subPage) : NULL;

                        $bufferedPage->writeSubHeader($subPage, $pageNav, $subPageNav, TRUE);
                    }

                    foreach ($service->merchantServiceDetail as $header => $detail) {
                        $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));

                        //tack on trailing zero if looks like: $0.3
                        $serviceData[$header] = preg_replace('/(\$[0-9]+\.[0-9])([\*]*)$/', '${1}0$2', $serviceData[$header]);

                        //tack on trailing zero to % rates if looks like: as low as 1.6%
                        $serviceData[$header] = preg_replace('/(.*[0-9]+[\.][0-9])%([\*]*)$/', '${1}0%$2', $serviceData[$header]);
                    }

                    $bufferedPage->writeMerchantService($page, $service, $serviceData, $counter, $this->site->properties);

                    //pagination
                    if ($counter % $page->properties['itemsPerPage'] == 0) {
                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                        $bufferedPage->writeFooter($page);
                        $contents[] = $bufferedPage;
                        $pageNumber++;
                        $bufferedPage = NULL;
                    }
                    $counter++;
                }
            }

            //save page
            if ($bufferedPage) {
                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                $bufferedPage->writeFooter($page);
                $contents[] = $bufferedPage;
            }

            //publish pages
            for ($x = 0; $x < sizeof($contents); $x++) {
                if ($page->get('pageLink') == 'index') {
                    $filename = '';
                }
                else {
                    $filename = $x == 0 ? $page->get('pageLink') . "." . $this->site->get('pagetype') : $this->destDir . "/" . $page->get('pageLink') . "-page-" . ($x + 1) . "." . $this->site->get('pagetype');
                }

	            if ($filename == '.php') {
		            continue;
	            }

                $contents[$x]->writeBufferedOutput($this->destDir . "/" . $filename);

                fwrite($this->merchListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

                if ($this->site->get('createSeoDoc') && $page->get('sitemapLink') && !in_array($this->site->get('publishurl') . '/' . $filename, $this->uniquePages)) {
                    $this->uniquePages[] = $this->site->get('publishurl') . '/' . $filename;
                    $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $filename, 'weekly', '0.5');
                    $this->yahooCategoriesSeo->writeEntryMeta($this->site->get('publishurl') . '/' . $filename, $page->getTitle(), $page->getPageMeta(), NULL, $pageCID);
                }
            }
        }

        //write to sitemap
        if ($this->site->get('sitemap') && sizeof($pages) > 0) {
            $this->_buildSiteMap($siteMapCategory, $sitemapPages, 'sitemap_listing');
        }
    }

    /**
     * Builds Merchant Service Application Pages
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildMerchantServiceApplicationPages() {
        $pages = $this->site->getMerchantServiceApplicationPages();

        if (sizeof($pages) > 0) {
            $siteMapCategory = LANG_SEARCH_MERCHANT_ACCOUNT_APPLICATIONS;
            $merger = new CMS_libs_MerchantServiceMergeFilter();
            $this->sitemap[$siteMapCategory] = array();
        }

        foreach ($pages as $page) {
            $sitemapPages[$page->get('cardpageId')] = array();

            $pageNumber = 1;
            $counter = 1;
            $contents = array();
            $subPages = $page->getSubPages();
            $services = $page->getMerchantServices();
            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');

            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);

            $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));
            $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page) : NULL;

            $pageNumber == 1 ? $bufferedPage->writeSubHeader($page, '', $subPageNav) : $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);

            foreach ($services as $service) {
                $sitemapPages[$page->get('cardpageId')][$service->get('merchant_service_id')] = $service->get('merchant_service_name') . '::';
                foreach ($service->merchantServiceDetail as $header => $detail) {
                    $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));

                    //tack on trailing zero if looks like: $0.3
                    $serviceData[$header] = preg_replace('/(\$[0-9]+\.[0-9])([\*]*)$/', '${1}0$2', $serviceData[$header]);

                    //tack on trailing zero to % rates if looks like: as low as 1.6%
                    $serviceData[$header] = preg_replace('/(.*[0-9]+[\.][0-9])%([\*]*)$/', '${1}0%$2', $serviceData[$header]);
                }
                //  $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));
                //add merchant service page
                if (!$bufferedPage) {
                    $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                    $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));

                    $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page) : NULL;

                    $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);
                }

                $bufferedPage->writeMerchantServiceApplication($page, $service, $serviceData, $counter, $this->site->properties);

                //pagination
                if ($counter % $page->properties['itemsPerPage'] == 0) {
                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                    $bufferedPage->writeFooter($page);
                    $contents[] = $bufferedPage;
                    $pageNumber++;
                    $bufferedPage = NULL;
                }
                $counter++;
            }

            //sub-pages
            foreach ($subPages as $subPage) {

                if (!$bufferedPage) {
                    $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                    $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));
                }

                $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page, $subPage) : NULL;

                $bufferedPage->writeSubHeader($subPage, '', $subPageNav, FALSE);

                $merger = new CMS_libs_MerchantServiceMergeFilter();
                $services = $subPage->getMerchantServices();

                foreach ($services as $service) {
                    $sitemapPages[$page->get('cardpageId')][$service->get('merchant_service_id')] = $service->get('merchant_service_name') . '::' . $this->site->get('individualmerchantservicesdir') . '/' . $service->get('merchant_service_link');
                    //add card page
                    if (!$bufferedPage) {
                        $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_merchantservicepagelayouts_' . $this->site->get('layout') . 'MerchantServicePageLayout');
                        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));

                        $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getMspSubPageNavBar($page, $subPage) : NULL;

                        $bufferedPage->writeSubHeader($subPage, $pageNav, $subPageNav, TRUE);
                    }

                    foreach ($service->merchantServiceDetail as $header => $detail) {
                        $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));

                        //tack on trailing zero if looks like: $0.3
                        $serviceData[$header] = preg_replace('/(\$[0-9]+\.[0-9])([\*]*)$/', '${1}0$2', $serviceData[$header]);

                        //tack on trailing zero to % rates if looks like: as low as 1.6%
                        $serviceData[$header] = preg_replace('/(.*[0-9]+[\.][0-9])%([\*]*)$/', '${1}0%$2', $serviceData[$header]);
                    }

                    $bufferedPage->writeMerchantServiceApplication($page, $service, $serviceData, $counter, $this->site->properties);

                    //pagination
                    if ($counter % $page->properties['itemsPerPage'] == 0) {
                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                        $bufferedPage->writeFooter($page);
                        $contents[] = $bufferedPage;
                        $pageNumber++;
                        $bufferedPage = NULL;
                    }
                    $counter++;
                }
            }

            //save page
            if ($bufferedPage) {
                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                $bufferedPage->writeFooter($page);
                $contents[] = $bufferedPage;
            }

            //publish pages
            for ($x = 0; $x < sizeof($contents); $x++) {
                if ($page->get('pageLink') == 'index') {
                    $filename = '';
                }
                else {
                    $filename = $x == 0 ? $page->get('pageLink') . "." . $this->site->get('pagetype') : $this->destDir . "/" . $page->get('pageLink') . "-page-" . ($x + 1) . "." . $this->site->get('pagetype');
                }

	            if ($filename == '.php') {
		            continue;
	            }

                $contents[$x]->writeBufferedOutput($this->destDir . "/" . $filename);

                fwrite($this->merchListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

                if ($this->site->get('createSeoDoc') && $page->get('sitemapLink') && !in_array($this->site->get('publishurl') . '/' . $filename, $this->uniquePages)) {
                    $this->uniquePages[] = $this->site->get('publishurl') . '/' . $filename;
                    $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $filename, 'weekly', '0.5');
                    $this->yahooCategoriesSeo->writeEntryMeta($this->site->get('publishurl') . '/' . $filename, $page->getTitle(), $page->getPageMeta(), NULL, $pageCID);
                }
            }
        }

        //write to sitemap
        if ($this->site->get('sitemap') && sizeof($pages) > 0) {
            $this->_buildSiteMap($siteMapCategory, $sitemapPages, 'sitemap_listing');
        }
    }

    /**
     * Builds Special Pages
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildSpecialsPages() {
        $siteMapCategory = LANG_CREDIT_CARD_SPECIALS;
        $merger = new CMS_libs_MergeFilter();
        $pages = $this->site->getSpecialsPages();
        if (sizeof($pages) == 0) {
            return;
        } //short circuit if there are no specials pages
        $sitemapPages = array();

        foreach ($pages as $page) {
            $this->sitemap[$page->get('cardpageId')] = array();
            $pageNumber = 1;
            $counter = 1;
            $contents = array();
            $cards = $page->getCards();
            $layoutname = $page->get('contentType') == 'altspecials' ? 'AltSpecialsPageLayout' : 'SpecialsPageLayout';
            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . $layoutname);
            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);

            $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));
            $pageNumber == 1 ? $bufferedPage->writeSubHeader($page, '', '', 'true', FALSE) : $bufferedPage->writeSubHeader($page, $pageNav);
            foreach ($cards as $card) {
                if ($page->get('sitemapLink')) {
                    $sitemapPages[$page->get('cardpageId')][$card->get('cardId')] = $card->get('cardTitle') . '::' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink');
                }

                $cardData = array();
                foreach ($card->cardDetail as $header => $detail) {
                    $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                }

                //add cardpage
                if (!$bufferedPage) {
                    $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                    $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'));
                    $bufferedPage->writeSubHeader($page, $pageNav);
                }
                $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties);
                $this->_historyWriter->addPublishState($page->get('fid'), $counter, $page->get('cardpageId'), $counter, $pageNumber, $card->get('cardId'));

                //pagination
                if ($counter % $page->properties['itemsPerPage'] == 0) {
                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                    $bufferedPage->writeFooter($page);
                    $contents[] = $bufferedPage;
                    $pageNumber++;
                    $bufferedPage = NULL;
                }
                $counter++;
            }

            //save page
            if ($bufferedPage) {
                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, NULL);
                $bufferedPage->writeFooter($page);
                $contents[] = $bufferedPage;
            }

            //publish pages
            for ($x = 0; $x < sizeof($contents); $x++) {
                if ($page->get('pageLink') == 'index') {
                    $filename = '';
                }
                else {
                    $filename = $x == 0 ? $page->get('pageLink') . "." . $this->site->get('pagetype') : $page->get('pageLink') . "-page-" . ($x + 1) . "." . $this->site->get('pagetype');
                }

	            if ($filename == '.php') {
		            continue;
	            }

                $contents[$x]->writeBufferedOutput($this->destDir . "/" . $filename);


                fwrite($this->specialsListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

                if ($this->site->get('createSeoDoc') && $page->get('sitemapLink') && !in_array($this->site->get('publishurl') . '/' . $filename, $this->uniquePages)) {
                    $this->uniquePages[] = $this->site->get('publishurl') . '/' . $filename;
                    $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $filename, 'weekly', '0.5');
                }
            }
        }

        //write to sitemap
        if ($this->site->get('sitemap') && $page->get('sitemapLink')) {
            $this->_buildSiteMap($siteMapCategory, $sitemapPages, 'sitemap_listing');
        }
    }

    /**
     * Builds Profile Pages
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildProfilePages() {
        $rs = $this->site->profiles_index_data;
        if ($rs != NULL) {

            $merger = new CMS_libs_MergeFilter();
            $pages = $this->site->getProfilePages();
            $profilesData = array();

            //If there is at least one profile, create profile index page
            if (!$rs->EOF) {

                while (!$rs->EOF) {
                    $profilesData[$rs->fields['profile_id']] = $rs->fields;
                    //Strip off first 22 letters of url (credit-cards-profiles) to get page link
                    $profilesData[$rs->fields['profile_id']]['lowerName'] = preg_replace('/credit-card-profiles\//', '', $rs->fields['pageLink']);
                    $rs->MoveNext();
                }

                //Create profile index page
                $bufferedpage = & csCore_Import::instanciateObject('CMS_layouts_profilepagelayouts_' . $this->site->get('layout') . 'ProfilePageLayout');
                $page = new page();
                $page->set('fid', '1382');
                $page->set('pageTitle', 'Shop Credit Cards by Profile');
                $page->set('pageMeta', '<META name="description" content="Our credit card experts have created various credit card profiles to help you choose the card that\'s right for you, along with valuable tips and tools.">
					<META name="keywords" content="search credit card profiles, credit card profile, credit cards">');
                $bufferedpage->writeHeader($page);
                $bufferedpage->writeIndexBody($profilesData);
                $bufferedpage->writeFooter($page);
                $bufferedpage->writeBufferedOutput($this->destDir . "/credit-card-profiles/index.php");
            }

            foreach ($pages as $page) {

                $bufferedpage = & csCore_Import::instanciateObject('CMS_layouts_profilepagelayouts_' . $this->site->get('layout') . 'ProfilePageLayout');

                $cardData = array();
                foreach ($page->top_card_data->card->cardDetail as $header => $detail) {
                    $cardData[$header] = $merger->translate($detail, $page->top_card_data->fields['cardId']);
                }

                //build a card object here so we can do consistent things in the template...
                $card = new card($page->top_card_data->fields);

                $bufferedpage->writeHeader($page);
                $bufferedpage->writeBody($page, $cardData, $this->site->properties, $profilesData, $card);
                $bufferedpage->writeFooter($page);

                $filename = $page->get('pageLink') . "." . $this->site->get('pagetype');
                $bufferedpage->writeBufferedOutput($this->destDir . "/" . $filename);


                //$profilesData[$page->get('cardpageId')] =& $page->profile_data->fields;
                //Get lowercase name for links and images from pageLink
                // $profilesData[$page->get('cardpageId')]['lowerName'] = substr($page->get('pageLink'), 22);
            }
        }
    }

    /**
     * Builds individual card pages if the site requires it
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildIndividualCardPages() {
        @mkdir($this->destDir . "/" . $this->site->get('individualcarddir'));
        $merger = new CMS_libs_MergeFilter();
        $pages = $this->site->getCardPages();

        $cards = array();

        //collect all cards
        foreach ($pages as $page) {
            $subPages = $page->getSubPages();
            $newcards = $page->getCards();
            $cards = array_merge($cards, $newcards);
            foreach ($subPages as $subPage) {
                $cards = array_merge($cards, $subPage->getCards());
                $newcards = array_merge($newcards, $subPage->getCards());
            }
            // collect page info for cards on page - for SearchMonkey
            foreach ($newcards as $newcard) {
                $newcard_id = $newcard->get('cardId');
                if (!isset($cardCatMap[$newcard_id]) && $page->get('pageType') != 'BANK') {
                    $cardCatMap[$newcard_id] = array('url' => $page->get('pageLink') . '.php', 'name' => $page->get('pageName'));
                }
            }
        }
        $orphanedCards = array();
        $orphanedCards = $this->site->getOrphanedCards();
        $allCards = array_merge($cards, $orphanedCards);

        //write all individual pages
        foreach ($allCards as $card) {
            $page = CMS_libs_Pages::getPageByIdAndSite($card->get('merchantcardpage'), $this->site->get('siteId'));
            $cardpage = new page($page->fields);

            if ($card->get('active') == 1) {
                $cardData = array();
                foreach ($card->cardDetail as $header => $detail) {
                    $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                }

                //define("SPECIALTY_CARDS", array('22089566'));
                /*if(in_array($card->get('cardId'), array("22105049"))) {
                    $test = 'CMS_layouts_individualcardlayouts_' . $this->site->get('layout') . 'SpecialtyCardLayout';
                    $buffindpage = & csCore_Import::instanciateObject('CMS_layouts_individualcardlayouts_' . $this->site->get('layout') . 'SpecialtyCardLayout');
                    $buffindpage->writeHeader($card, "1", $this->site->get('pagetype'));
                    $buffindpage->writeBody($card, $cardData, $cardpage);
                    $buffindpage->writeFooter($card);
                }
                else */ if ($card->get('active_epd_pages') == 1) {
                    $extendedRs = CMS_libs_Cards::getExtendedCard($card->get('cardId'), $this->site->get('siteId'));
                    $extendedCard = new card($extendedRs->fields);
                    $extendedCard->addProperty(SITECATALYST_VAR_IDENTIFIER, $card->get(SITECATALYST_VAR_IDENTIFIER));
                    $extendedCard->addProperty('otherIssuerCards', CMS_libs_Cards::getTopCardsFromIssuerCategory($card->get('cardId'), $card->get('category_id'), 1, $this->site->get('siteId')));
                    $extendedCard->addProperty('cardCategories', CMS_libs_Cards::getCardCategories($card->get('cardId')));

                    $buffindpage = & csCore_Import::instanciateObject('CMS_layouts_individualcardlayouts_' . $this->site->get('layout') . 'IndividualCardLayoutExtended');
                    $buffindpage->writeHeader($extendedCard, "1", $this->site->get('pagetype'));
                    $buffindpage->writeBody($extendedCard, $cardData, $cardpage);
                    $buffindpage->writeFooter($extendedCard);
                }
                else {
                    $buffindpage = & csCore_Import::instanciateObject('CMS_layouts_individualcardlayouts_' . $this->site->get('layout') . 'IndividualCardLayout');
                    $buffindpage->writeHeader($card, "1", $this->site->get('pagetype'));
                    $buffindpage->writeBody($card, $cardData, $cardpage);
                    $buffindpage->writeFooter($card);
                }

                $filename = $this->site->get('individualcarddir') . "/" . $card->get('cardLink') . "." . $this->site->get('pagetype');

	            if ($filename == '.php') {
		            continue;
	            }

                $buffindpage->writeBufferedOutput($this->destDir . "/" . $filename);

                fwrite($this->indCardListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

                if ($this->site->get('createSeoDoc') && !in_array($this->site->get('publishurl') . '/' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink') . '.' . $this->site->get('pagetype'), $this->uniquePages)) {

                    if (!isset($cardCatMap[$card->get('cardId')])) {
                        $cardCatMap[$card->get('cardId')] = '';
                    }

                    $this->uniquePages[] = $this->site->get('publishurl') . '/' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink') . '.' . $this->site->get('pagetype');
                    $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink') . '.' . $this->site->get('pagetype'), 'monthly', '0.5');
                    $this->yahooCardsSeo->writeEntryMeta($this->site->get('publishurl') . '/' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink') . '.' . $this->site->get('pagetype'), $card->getTitle(), $card->getPageMeta());
                    $this->yahooSearchMonkeySeo->writeCardEntry($this->site->get('publishurl') . '/' . $this->site->get('individualcarddir') . '/' . $card->get('cardLink') . '.' . $this->site->get('pagetype'), $card, $cardData, $cardpage, $cardCatMap[$card->get('cardId')]);
                }
            }
            else {
                //print("Writing 301 redirect: ".$this->destDir."/".$this->site->get('individualcarddir')."/".$card->get('cardLink').".".$this->site->get('pagetype')."<br>");
                $buffindpage = & csCore_Import::instanciateObject('CMS_layouts_genericpagelayouts_' . $this->site->get('layout') . 'GenericPageLayout');
                $buffindpage->writeBody($this->site->get('layout') . '/301_redirect', '/' . $cardpage->get('pageLink') . "." . $this->site->get('pagetype'));
                $buffindpage->writeBufferedOutput($this->destDir . "/" . $this->site->get('individualcarddir') . "/" . $card->get('cardLink') . "." . $this->site->get('pagetype'));
            }
        }
    }

    /**
     * Builds the individual merchant service pages if the site requires it
     * @author  Jason Huie
     * @version 1.0
     */
    function _buildIndividualMerchantServicesPages() {
        @mkdir($this->destDir . "/" . $this->site->get('individualmerchantservicesdir'));

        $merger = new CMS_libs_MerchantServiceMergeFilter();
        $pages = $this->site->getMerchantServicePages();
        $services = array();

        //collect all merchant services
        foreach ($pages as $page) {
            $subPages = $page->getSubPages();
            $services = array_merge($services, $page->getMerchantServices());
            foreach ($subPages as $subPage) {
                $services = array_merge($services, $subPage->getMerchantServices());
            }
        }

        //write all individual pages
        foreach ($services as $service) {
            foreach ($service->merchantServiceDetail as $header => $detail) {
                $serviceData[$header] = $merger->translate($detail, $service->get('merchant_service_id'));
            }
            $buffindpage = & csCore_Import::instanciateObject('CMS_layouts_individualmerchantservicelayouts_' . $this->site->get('layout') . 'IndividualMerchantServiceLayout');
            $buffindpage->writeHeader($service, "1", $this->site->get('pagetype'));
            $buffindpage->writeBody($service, $serviceData);
            $buffindpage->writeFooter($service);

            $filename = $this->site->get('individualmerchantservicesdir') . "/" . $service->get('merchant_service_link') . "." . $this->site->get('pagetype');

	        if ($filename == '.php') {
		        continue;
	        }

            $buffindpage->writeBufferedOutput($this->destDir . "/" . $filename);

            fwrite($this->indMerchListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

            if ($this->site->get('createSeoDoc') && !in_array($this->site->get('publishurl') . '/' . $this->site->get('individualmerchantservicesdir') . "/" . $service->get('merchant_service_link') . '.' . $this->site->get('pagetype'), $this->uniquePages)) {
                $this->uniquePages[] = $this->site->get('publishurl') . '/' . $this->site->get('individualmerchantservicesdir') . "/" . $service->get('merchant_service_link') . '.' . $this->site->get('pagetype');
                $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $this->site->get('individualmerchantservicesdir') . "/" . $service->get('merchant_service_link') . '.' . $this->site->get('pagetype'), 'monthly', '0.5');
                $this->yahooCardsSeo->writeEntryMeta($this->site->get('publishurl') . '/' . $this->site->get('individualmerchantservicesdir') . '/' . $service->get('merchant_service_link') . '.' . $this->site->get('pagetype'), $service->getTitle(), $service->getPageMeta());
            }
        }
    }

    function _buildAlternativeCardPages() {
        @mkdir($this->destDir . "/" . $this->site->get('alternativecardpagesdir'));
        $siteMapCategory = LANG_SEARCH_CREDIT_CARDS;
        $merger = new CMS_libs_MergeFilter();
        $pages = $this->site->getCardPages();
        //$sitemapPages = array();
        foreach ($pages as $page) {
            //         if($page->get('sitemapLink'))
            //            $this->sitemap[$page->get('cardpageId')] = array();
            // bypass the recommender pages
            if (!$page->get('sitemapLink')) {
                continue;
            }

            $rootPath = '../' . $page->get('rootPath');

            $pageNumber = 1;
            $counter = 1;
            $contents = array();
            $subPages = $page->getSubPages();
            $cards = $page->getCards();
            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'AlternativeCardPageLayout');
            $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	        $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);

            // now we need to create the proper page ids
            $pageIdGen = new CMS_libs_PageIdGenerator(); // get the generator
            // let's go ahead and set up the name, url, etc.
            $originalPageId = $page->get('fid');
            $pageReferenceId = $originalPageId . '_matrix';
            $pageUrl = '/' . $this->site->get('alternativecardpagesdir') . '/' . $page->get('pageLink');
            $pageName = $page->get('pageLink') . '-matrix';
            $order = 0;

            $pageId = $pageIdGen->getPageId($pageReferenceId, $pageName, $pageUrl, $pageType = CMS_libs_PageIdGenerator::PAGE_TYPE_PRODUCT_CATEGORY, 0, $originalPageId);

            // now that we have the correct page id, let's set it in the original object
            $page->set('fid', $pageId);

            $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $rootPath, $prevNextLinks, $canonicalTag);
            $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page) : NULL;
            $pageNumber == 1 ? $bufferedPage->writeSubHeader($page, '', $subPageNav) : $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);

            // reset page id to original
            $page->set('fid', $originalPageId);

            $topcard = '';

            // since we're dealing with alternative card pages, we need to appropriately set the site catalyst vars
            $siteCatalystData = $page->get(SITECATALYST_VAR_IDENTIFIER);

            if (!isset($siteCatalystData['prop14'])) {
                $siteCatalystData['prop14'] = 'matrix'; // yeah, I hardcoded it. You'll live.
            }

            $page->set(SITECATALYST_VAR_IDENTIFIER, $siteCatalystData);

            foreach ($cards as $card) {
                if ($card->get('active') == 1) {
                    //               if($page->get('sitemapLink'))
                    //                  $sitemapPages[$page->get('cardpageId')][$card->get('cardId')] = $card->get('cardTitle').'::'.$this->site->get('individualcarddir').'/'.$card->get('cardLink');

                    $cardData = array();
                    foreach ($card->cardDetail as $header => $detail) {
                        $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                    }

                    //add cardpage
                    if (!$bufferedPage) {
                        $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'AlternativeCardPageLayout');
                        $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                    $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $rootPath, $prevNextLinks, $canonicalTag);
                        $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page) : NULL;
                        $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);
                    }
                    $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties, $pageNumber);

                    // pagination
                    // added code to aid in rendering correct card count on first page
                    // vs. subsequent pages.  - mz 1/3/08
                    if ($pageNumber == 1) {
                        if ($topcard == '') {
                            $topcard = $card->get('cardLink');
                        }

                        // if only the main category should show on the 1st page, then we check 2 things:
                        // 1) if the number of cards designated to show on the 1st page has come, or
                        // 2) if the number of assigned cards to the main category has already come.  - mz 1/8/08
                        if ($page->properties['showMainCatOnFirstPage'] == 1 && ($counter % $page->properties['itemsOnFirstPage'] == 0 || $counter >= count($cards))) {
                            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                            $bufferedPage->writeFooter($page, $pageNumber);
                            $contents[] = $bufferedPage;
                            $pageNumber++;
                            $bufferedPage = NULL;
                            $counter = 0;
                        }
                        // otherwise we keep going till the # of cards designated for the 1st
                        // page expires.  - mz 1/8/08
                        else if ($counter % $page->properties['itemsOnFirstPage'] == 0) {
                            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                            $bufferedPage->writeFooter($page, $pageNumber);
                            $contents[] = $bufferedPage;
                            $pageNumber++;
                            $bufferedPage = NULL;
                            $counter = 0;
                        }
                    }
                    else if ($counter % $page->properties['itemsPerPage'] == 0) {
                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                        $bufferedPage->writeFooter($page, $pageNumber);
                        $contents[] = $bufferedPage;
                        $pageNumber++;
                        $bufferedPage = NULL;
                    }
                    $counter++;
                }
            }

            //sub-pages       
            foreach ($subPages as $subPage) {
                if (!$subPage->get('hide') && $subPage->getActiveCardCount() > 0) {
                    if (!$bufferedPage) {
                        $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'AlternativeCardPageLayout');
                        $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                    $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $rootPath, $prevNextLinks, $canonicalTag);
                    }

                    $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page, $subPage) : NULL;
                    // if the last card we looked at was the end of a page, then isPageTop = true, otherwise false
                    $bufferedPage->writeSubHeader($subPage, '', $subPageNav, (($counter - 1) % $page->properties['itemsPerPage'] == 0));
                    $merger = new CMS_libs_MergeFilter();
                    $cards = $subPage->getCards();

                    foreach ($cards as $card) {
                        if ($card->get('active') == 1) {
                            //                     if($page->get('sitemapLink'))
                            //                        $sitemapPages[$page->get('cardpageId')][$card->get('cardId')] = $card->get('cardTitle').'::'.$this->site->get('individualcarddir').'/'.$card->get('cardLink');
                            //add card page
                            if (!$bufferedPage) {
                                $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'AlternativeCardPageLayout');
                                $prevNextLinks = CMS_libs_Pagination::getLinkTags($page, $pageNumber);
	                            $canonicalTag = CMS_libs_Pagination::getCanonicalTag($page);
                                $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                                $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $rootPath, $prevNextLinks, $canonicalTag);
                                $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page, $subPage) : NULL;
                                $bufferedPage->writeSubHeader($subPage, $pageNav, $subPageNav, TRUE);
                            }

                            $cardData = array();
                            foreach ($card->cardDetail as $header => $detail) {
                                $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                            }

                            $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties);

                            //pagination                 
                            if ($pageNumber == 1) {
                                if ($topcard == '') {
                                    $topcard = $card->get('cardLink');
                                }

                                // if only the main category should show on the 1st page, then we check 2 things:
                                // 1) if the number of cards designated to show on the 1st page has come, or
                                // 2) if the # of actual cards assigned to the 1st page has already come.  - mz 1/8/08
                                if ($page->properties['showMainCatOnFirstPage'] == 1 && ($counter % $page->properties['itemsOnFirstPage'] == 0 || $counter >= count($cards))) {
                                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                    $bufferedPage->writeFooter($page, $pageNumber);
                                    $contents[] = $bufferedPage;
                                    $pageNumber++;
                                    $bufferedPage = NULL;
                                    $counter = 0;
                                }
                                // otherwise we keep going till the # of cards designated for the 1st
                                // page expires.  - mz 1/8/08
                                else if ($counter % $page->properties['itemsOnFirstPage'] == 0) {
                                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                    $bufferedPage->writeFooter($page, $pageNumber);
                                    $contents[] = $bufferedPage;
                                    $pageNumber++;
                                    $bufferedPage = NULL;
                                    $counter = 0;
                                }
                            }
                            else if ($counter % $page->properties['itemsPerPage'] == 0) {
                                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                $bufferedPage->writeFooter($page, $pageNumber);
                                $contents[] = $bufferedPage;
                                $pageNumber++;
                                $bufferedPage = NULL;
                            }
                            $counter++;
                        }
                    }
                }
            }

            //save page
            if ($bufferedPage) {
                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                $bufferedPage->writeFooter($page, $pageNumber);
                $contents[] = $bufferedPage;
            }

            //publish pages
            for ($x = 0; $x < sizeof($contents); $x++) {
                $filename = $x == 0 ? $page->get('pageLink') . "." . $this->site->get('pagetype') : $page->get('pageLink') . "-page-" . ($x + 1) . "." . $this->site->get('pagetype');

	            if ($filename == '.php') {
		            continue;
	            }

                $contents[$x]->writeBufferedOutput($this->destDir . "/" . $this->site->get('alternativecardpagesdir') . '/' . $filename);
                fwrite($this->catListHandle, $this->site->get('publishurl') . '/' . $filename . "\n");

                //            if($this->site->get('createSeoDoc') && $page->get('sitemapLink') && !in_array($this->site->get('publishurl').'/'.$filename, $this->uniquePages)){
                //               $this->uniquePages[] = $this->site->get('publishurl').'/'.$filename;
                //               $this->googleSeo->writeEntry($this->site->get('publishurl').'/'.$filename, 'weekly', '0.5');
                //               $pageCID = $this->_getPageCID( $filename );
                //               $this->yahooCategoriesSeo->writeEntryMeta($this->site->get('publishurl').'/'.$filename, $page->getTitle(), $page->getPageMeta(), null, $pageCID);
                //               if ($x==0) // only creating searchmonkey for first page
                //                  $this->yahooSearchMonkeySeo->writeCategoryEntry($this->site->get('publishurl').'/'.$filename, $page, $topcard);
                //            }
            }

            // reset site catalyst vars
            $siteCatalystData = $page->get(SITECATALYST_VAR_IDENTIFIER);
            $siteCatalystData['prop14'] = '';

            $page->set(SITECATALYST_VAR_IDENTIFIER, $siteCatalystData);
        }

        //write to sitemap
        //      if($this->site->get('sitemap'))
        //         $this->_buildSiteMap($siteMapCategory, $sitemapPages, 'sitemap_listing');
    }

    /**
     * Build the sitemap if required by the site
     * @author  Jason Huie
     * @version 2.0
     */
    function _buildSiteMap($categoryName, $pages, $listingType) {

        if (sizeof($pages) > 0) {
            $this->map->writeBody($this->site->get('layout') . '/' . $listingType, array('listType' => 'category', 'category' => $categoryName));
        }

        $pCounter = 0;
        if (is_array($pages)) {
            foreach ($pages as $pageId => $items) {

                $page = $this->site->getCardPage($pageId);


                //if the setting is null or 0
                if ($page->get('rollup') != 1) {
                    $cCounter = 0;

                    foreach ($items as $itemInfo) {
                        $itemInfo = explode('::', $itemInfo);
                        $entryParams = array('listType' => 'cardListing', 'page' => $cCounter <= 0 ? $page : NULL, 'card' => $itemInfo, 'remainingCards' => (count($items) - 1 - $cCounter), 'remainingPages' => (count($pages) - 1 - $pCounter));

                        $this->map->writeBody($this->site->get('layout') . '/' . $listingType, $entryParams);

                        $cCounter++;
                    }
                }

                //if the setting is null or 1
                if ($page->get('rollup') != 0) {
                    //some often use variables that we'll put in simple variables.
                    $categorySiteMapLink = strToLower($page->get('pageLink'));
                    //$pageName = isset($this->_sitemapReductionTestPageLinks[$page->get('pageLink')]) ? $this->_sitemapReductionTestPageLinks[$page->get('pageLink')] : '';
                    //define strings for sitemap creation
                    $this->site->get('layout') . '/' . $listingType . '_collapsed';

                    $tplParams = array('listType' => 'cardListing', 'page' => $page, 'remainingPages' => (count($pages) - 1 - $pCounter), 'sitemap_link' => 'site-map/' . $categorySiteMapLink);

                    //We want a custom title on this page, so we're just going to fudge it a little bit.
                    $page->properties['pageTitle'] = $page->get('pageHeaderString') . ' Site Map';
                    $page->properties['pageMeta'] = '<meta name="keywords" content="' . $page->get('siteMapTitle') . ' site map, credit cards, credit card offers">' . "\n" . '<meta name="description" content="Compare ' . $page->get('siteMapTitle') . '. Below are the top ' . $page->get('siteMapTitle') . ' available at CreditCards.com">';

                    // write the category link to the parent site map only if rollup status is 1
                    $tpl = $this->site->get('layout') . '/' . $listingType . '_collapsed';
                    if ($page->get('rollup') == 1) {
                        $this->map->writeBody($tpl, $tplParams);
                    }


                    // then stamp out this category's specific site map page
                    $this->categoryMap = & csCore_Import::instanciateObject('CMS_layouts_genericpagelayouts_' . $this->site->get('layout') . 'GenericPageLayout');

                    $this->categoryMap->writeHeader($page, '../');

                    //$siteMapReductionTitle = isset($this->_sitemapReductionTestPageLinks[$page->get('pageLink')]) ? $this->_sitemapReductionTestPageLinks[$page->get('pageLink')] : '';

                    $this->categoryMap->writeSubHeader($this->site->get('layout') . '/category_sitemap_sub_header', array('page_header_string' => 'Search ' . $page->get('siteMapTitle'), 'category_name' => $page->get('siteMapTitle')));

                    // write out the child links to a seperate category site map
                    $cCounter = 0;

                    switch ($page->get('contentType')) {
                        case 'card':
                            $items = $page->getCards();
                            break;
                        case 'merchant service':
                            $items = $page->getMerchantServices();
                            break;
                        case 'merchant service application':
                            $items = $page->getMerchantServices();
                            break;
                        case 'specials':
                            $items = $page->getSpecials();
                            break;
                    }

                    //scrub array for inactive cards
                    foreach ($items as $item) {
                        if (!$item->get('active')) {
                            unset($items[$item->getId()]);
                        }
                    }

                    foreach ($items as $item) {
                        $tplParams = array('listType' => 'cardListing', 'page' => $cCounter <= 0 ? $page : NULL, 'card' => $item, 'remainingCards' => (count($items) - 1 - $cCounter), 'remainingPages' => (count($pages) - 1 - $pCounter), 'category_name' => $page->get('pageHeaderString'));

                        $this->categoryMap->writeBody($this->site->get('layout') . '/category_sitemap_listing', $tplParams);
                        $cCounter++;
                    }

                    //And now do the same for sub-pages
                    $subPages = $page->getSubPages();
                    $spCounter = 0;
                    foreach ($subPages as $subPage) {
                        // write out the child links to a seperate category site map
                        $cCounter = 0;

                        switch ($page->get('contentType')) {
                            case 'card':
                                $items = $subPage->getCards();
                                break;
                            case 'merchant service':
                                $items = $subPage->getMerchantServices();
                                break;
                            case 'specials':
                                $items = $subPage->getSpecials();
                                break;
                        }

                        //scrub array for inactive cards
                        foreach ($items as $item) {
                            if (!$item->get('active')) {
                                unset($items[$item->getId()]);
                            }
                        }

                        foreach ($items as $item) {
                            $tplParams = array('listType' => 'cardListing', 'page' => $cCounter <= 0 ? $subPage : NULL, 'card' => $item, 'remainingCards' => (count($items) - 1 - $cCounter), 'remainingPages' => (count($subPages) - 1 - $spCounter), 'category_name' => $subPage->get('pageHeaderString'));
                            $this->categoryMap->writeBody($this->site->get('layout') . '/category_sitemap_listing', $tplParams);
                            $cCounter++;
                        }
                        $spCounter++;
                    }

                    // there's not really a sub-footer, but we still need to write it to complete
                    // the HTML between the body and footer of the page.  - mz
                    $this->categoryMap->writeSubFooter($this->site->get('layout') . '/category_sitemap_sub_footer');

                    // write the footer w/SiteCatalyst variables
                    $siteCatalystData = array('pageName' => 'tools:site map', 'channel' => 'tools', 'prop1' => 'tools', 'prop2' => $categorySiteMapLink);
                    $this->categoryMap->writeFooterWithSiteCatalystData(new generic(array('title' => $this->site->get('siteName') . ' - Site Map - ' . $page->get('siteMapTitle'))), $siteCatalystData);


                    //category sitemap filename
                    $filename = $this->destDir . '/' . $this->site->get('sitemaplink') . '/' . $categorySiteMapLink . '.' . $this->site->get('pagetype');

                    // write the buffered page content               
                    $this->categoryMap->writeBufferedOutput($filename);
                }
                $pCounter++;
            }
        }
    }

    /**
     * Dynamically create the index page using the [layout]_index template
     * @author  Jason Huie
     * @version 1.0
     */
    function _buildIndexPage() {
        $pages = $this->site->getIndexPages();

        //get merchants
        $merchants = CMS_libs_Merchants::getAllMerchants();

        //get top card 
        if (sizeof($pages) == 0) {
            return;
        } //short circuit if there are no specials pages
        foreach ($pages as $page) {
            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_genericpagelayouts_' . $this->site->get('layout') . 'GenericPageLayout');
            $bufferedPage->writeHeader($page);
            $bufferedPage->writeBody($this->site->get('layout') . '/index', array('page' => $page, 'merchants' => $merchants));
            $bufferedPage->writeFooter($page);
            $bufferedPage->writeBufferedOutput($this->destDir . "/index." . $this->site->get('pagetype'));
        }
    }

    /**
     * Builds landing pages
     * @author  Jason Huie
     * @version 2.1
     *
     * FA0020984 - changed call from writeSubHeader to writeLandingSubHeader
     */
    function _buildLandingPages() {
        $merger = new CMS_libs_MergeFilter();
        $pages = $this->site->getCardPages();
        $sitemapPages = array();
        foreach ($pages as $page) {
            if ($page->get('landingPage')) {
                $pageNumber = 1;
                $counter = 1;
                $contents = array();
                $subPages = $page->getSubPages();
                $cards = $page->getCards();
                $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                //             $articles = $page->getArticles();

                //$bufferedPage->writeLandingHeader($page, $pageNumber, $this->site->get('pagetype'));
                $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page) : NULL;
                $pageNumber == 1 ? $bufferedPage->writeLandingSubHeader($page, '', $subPageNav) : $bufferedPage->writeLandingSubHeader($page, $pageNav, $subPageNav);
                foreach ($cards as $card) {
                    if ($card->get('active') == 1) {
                        $cardData = array();
                        foreach ($card->cardDetail as $header => $detail) {
                            $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                        }

                        //add cardpage
                        if (!$bufferedPage) {
                            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                            $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page) : NULL;
                            $bufferedPage->writeLandingHeader($page, $pageNumber, $this->site->get('pagetype'));
                            $bufferedPage->writeLandingSubHeader($page, $pageNav);
                        }
                        $bufferedPage->writeLandingCard($page, $card, $cardData, $counter, $this->site->properties);

                        // pagination
                        // added code to aid in rendering correct card count on first page
                        // vs. subsequent pages.  - mz 1/3/08                                    
                        if ($pageNumber == 1) {
                            // if only the main category should show on the 1st page, then we check 2 things:
                            // 1) if the # of cards designated to show on the 1st page has come, or
                            // 2) if the # of actual cards assigned to the 1st page has already come.  - mz 1/8/08
                            if ($page->properties['showMainCatOnFirstPage'] == 1 && ($counter % $page->properties['itemsOnFirstPage'] == 0 || $counter >= count($cards))) {
                                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                $bufferedPage->writeFooter($page);
                                $contents[] = $bufferedPage;
                                $pageNumber++;
                                $bufferedPage = NULL;
                                $counter = 0;
                            }
                            // otherwise we keep going till the # of cards designated for the 1st
                            // page expires.  - mz 1/8/08
                            else if ($counter % $page->properties['itemsOnFirstPage'] == 0) {
                                $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                $bufferedPage->writeFooter($page);
                                $contents[] = $bufferedPage;
                                $pageNumber++;
                                $bufferedPage = NULL;
                                $counter = 0;
                            }
                        }
                        else if ($counter % $page->properties['itemsPerPage'] == 0) {
                            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                            $bufferedPage->writeFooter($page);
                            $contents[] = $bufferedPage;
                            $pageNumber++;
                            $bufferedPage = NULL;
                        }

                        $counter++;
                    }
                }

                //sub-pages         
                foreach ($subPages as $subPage) {
                    if (!$subPage->get('hide')) {
                        if (!$bufferedPage) {
                            $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                            $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                            $bufferedPage->writeLandingHeader($page, $pageNumber, $this->site->get('pagetype'));
                        }

                        $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page, $subPage) : NULL;
                        $bufferedPage->writeLandingSubHeader($subPage, '', $subPageNav, FALSE);
                        $merger = new CMS_libs_MergeFilter();
                        $cards = $subPage->getCards();

                        foreach ($cards as $card) {
                            if ($card->get('active') == 1) {
                                //add card page
                                if (!$bufferedPage) {
                                    $bufferedPage = & csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_' . $this->site->get('layout') . 'CardPageLayout');
                                    $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                                    $bufferedPage->writeLandingHeader($page, $pageNumber, $this->site->get('pagetype'));
                                    $subPageNav = $page->get('subPageNav') ? CMS_libs_Pagination::getSubPageNavBar($page, $subPage) : NULL;
                                    $bufferedPage->writeLandingSubHeader($subPage, $pageNav, $subPageNav, TRUE);
                                }

                                $cardData = array();
                                foreach ($card->cardDetail as $header => $detail) {
                                    $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                                }

                                $bufferedPage->writeLandingCard($page, $card, $cardData, $counter, $this->site->properties);

                                //pagination
                                if ($pageNumber == 1) {
                                    // if only the main category should show on the 1st page, then we check 2 things:
                                    // 1) if the number of cards designated to show on the 1st page has come, or
                                    // 2) if the # of actual cards assigned to the 1st page has already come.  - mz 1/8/08
                                    if ($page->properties['showMainCatOnFirstPage'] == 1 && ($counter % $page->properties['itemsOnFirstPage'] == 0 || $counter >= count($cards))) {
                                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                        $bufferedPage->writeFooter($page);
                                        $contents[] = $bufferedPage;
                                        $pageNumber++;
                                        $bufferedPage = NULL;
                                        $counter = 0;
                                    }
                                    // otherwise we keep going till the number of cards designated for the 1st
                                    // page expires.  - mz 1/8/08
                                    else if ($counter % $page->properties['itemsOnFirstPage'] == 0) {
                                        $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                        $bufferedPage->writeFooter($page);
                                        $contents[] = $bufferedPage;
                                        $pageNumber++;
                                        $bufferedPage = NULL;
                                        $counter = 0;
                                    }
                                }
                                else if ($counter % $page->properties['itemsPerPage'] == 0) {
                                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                                    $bufferedPage->writeFooter($page);
                                    $contents[] = $bufferedPage;
                                    $pageNumber++;
                                    $bufferedPage = NULL;
                                }
                                $counter++;
                            }
                        }
                    }
                }

                //save page
                if ($bufferedPage) {
                    $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, $articles);
                    $bufferedPage->writeLandingFooter($page);
                    $contents[] = $bufferedPage;
                }

                //publish pages
                for ($x = 0; $x < sizeof($contents); $x++) {
                    $filename = $x == 0 ? $this->site->get('landingPageDir') . '/' . $page->get('pageLink') . "." . $this->site->get('pagetype') : $this->site->get('landingPageDir') . '/' . $page->get('pageLink') . "-page-" . ($x + 1) . "." . $this->site->get('pagetype');
                    $contents[$x]->writeBufferedOutput($this->destDir . "/" . $filename);
                    if ($this->site->get('createSeoDoc') && $page->get('sitemapLink') && !in_array($this->site->get('publishurl') . '/' . $filename, $this->uniquePages)) {
                        $this->uniquePages[] = $this->site->get('publishurl') . '/' . $filename;
                        $this->googleSeo->writeEntry($this->site->get('publishurl') . '/' . $filename, 'weekly', '0.5');
                    }
                }
            }
        }
    }

    /**
     * Build the article portion of the site map.  Accomplishes this by sending a cURL
     * request and writing the resulting HTML to the site map.
     * @author  Jason Huie
     * @version 2.0
     */
    function _addArticlesToSiteMap() {
        // added this code to append the site map html from cardpress      
        if ($this->site->get('sitemap')) {
            $articleFile = $this->site->get('articleSiteMapFile');

            if ($articleFile != '') {
                $curlContent = $this->_cUrlRequest($articleFile);

                if ($curlContent['errorNumber'] == 0) {
                    $this->map->writeContentToBody($curlContent['contents'], array('listType' => 'category', 'category' => 'Credit Card Stories'));
                }
            }
        }
    }

    /**
     * Adds the articles to google's xml file.  If the site map for the site
     * shouldn't be built, the function returns immediately.
     * @author  mz
     * @date    1/17/08
     */
    function _addArticlesToGoogleXML() {
        if ($this->site->get('sitemap')) {
            $articleFile = $this->site->get('googleArticleFile');

            if ($articleFile != '') {
                $curlContent = $this->_cUrlRequest($articleFile);

                if ($curlContent['errorNumber'] == 0) {
                    $this->googleSeo->bufferString($curlContent['contents']);
                }
            }
        }
    }

    /**
     * Adds the articles to yahoo's txt file
     * @author  mz
     * @date    1/17/08
     */
    function _addArticlesToYahooTxt() {
        if ($this->site->get('sitemap')) {
            $articleFile = $this->site->get('yahooArticleFile');

            if ($articleFile != '') {
                $curlContent = $this->_cUrlRequest($articleFile);

                if ($curlContent['errorNumber'] == 0) {
                    $this->yahooArticlesSeo->bufferString($curlContent['contents']);
                }
            }
        }
    }

    /**
     * Adds the articles to yahoo's txt file
     * @author  mz
     * @date    1/17/08
     */
    function _addArticleCategoriesToYahooTxt() {
        if ($this->site->get('sitemap')) {
            $articleFile = $this->site->get('yahooArticleCategoryFile');

            if ($articleFile != '') {
                $curlContent = $this->_cUrlRequest($articleFile);

                if ($curlContent['errorNumber'] == 0) {
                    $this->yahooArticleCategoriesSeo->bufferString($curlContent['contents']);
                }
            }
        }
    }

    /**
     * Make sure that source and destination directories are present
     * @author  Patrick Mizer
     * @version 1.0
     */
    function _preBuildSanityCheck() {
        // first check that destination and source dirs exist and are
        // readable / writable.

        if (!@is_dir($this->destDir)) {
            if (!mkdir($this->destDir, 0777)) {
                _setMessage($this->destDir . " Does not exist and is not writable!", TRUE);
                return FALSE;
            }
        }


        if (!@is_writable(dirname($this->destDir))) {
            _setMessage($this->destDir . " is not writable!", TRUE);
            return FALSE;
        }
        else {
            $this->_rmDir($this->destDir);
            @mkdir($this->destDir, 0777);
        }

        if (!@is_dir($this->sourceDir)) {
            _setMessage($this->sourceDir . " does not exist!", TRUE);
            return FALSE;
        }

        if (!@is_readable($this->sourceDir)) {
            _setMessage($this->destDir . " is not readable!", TRUE);
            return FALSE;
        }

        if ($coreDir = $this->site->get('corePath')) {
            if (!@is_dir($coreDir)) {
                _setMessage($coreDir . " does not exist!", TRUE);
                return FALSE;
            }

            if (!@is_readable($coreDir)) {
                _setMessage($coreDir . " is not readable!", TRUE);
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Copy all images from the image repository into the destination folder
     * @author  Patrick Mizer
     * @version 1.0
     */
    function _moveCardImages() {
        $fromDir = SITE_PATH . $this->settings->getSetting('CMS_image_repository') . '/';
        $toDir = $this->destDir . '/images/';
        $chmod = 0777;
        $verbose = FALSE;

        $handle = opendir($fromDir);
        $pages = $this->site->getCardPages();

        if (!file_exists($toDir)) {
            mkdir($toDir);
        }
        foreach ($pages as $page) {
            foreach ($page->getCards() as $card) {
                $from = $fromDir . $card->get('imagePath');
                $to = $toDir . $card->get('imagePath');
                if (@copy($from, $to)) {
                    chmod($to, $chmod);
                    touch($to, filemtime($from));
                    $messages[] = 'File copied from ' . $from . ' to ' . $to;
                }
                else {
                    $errors[] = 'cannot copy file from ' . $from . ' to ' . $to;
                }
            }

            foreach ($page->getSubPages() as $sub) {
                foreach ($sub->getCards() as $card) {
                    $from = $fromDir . $card->get('imagePath');
                    $to = $toDir . $card->get('imagePath');
                    if (@copy($from, $to)) {
                        chmod($to, $chmod);
                        touch($to, filemtime($from));
                        $messages[] = 'File copied from ' . $from . ' to ' . $to;
                    }
                    else {
                        $errors[] = 'cannot copy file from ' . $from . ' to ' . $to;
                    }
                }
            }
        }
        closedir($handle);
        if ($verbose) {
            if (is_array($errors)) {
                foreach ($errors as $err) {
                    $error = TRUE;
                    _setMessage($err, TRUE);
                }
            }
        }
        return TRUE;
    }

    /**
     * Copy all images from the article repository into the destination folder
     * @author  Patrick Mizer
     * @version 1.0
     */
    function _moveArticleImages() {
        if (sizeof($this->site->getArticleCategories()) > 0) {
            $dstdir = $this->settings->getSetting('CMS_publish') . '/' . $this->site->get('publishPath') . '/credit-card-news/images/';
            $srcdir = SITE_PATH . $this->settings->getSetting('CMS_article_images') . '/';
            $num = 0;
            if (!is_dir($dstdir)) {
                mkdir($dstdir);
            }
            if ($curdir = opendir($srcdir)) {
                while ($file = readdir($curdir)) {
                    if ($file != '.' && $file != '..' && $file != 'CVS') {
                        $srcfile = $srcdir . '/' . $file;
                        $dstfile = $dstdir . '/' . $file;
                        if (is_file($srcfile)) {
                            if (is_file($dstfile)) {
                                $ow = filemtime($srcfile) - filemtime($dstfile);
                            }
                            else {
                                $ow = 1;
                            }
                            if ($ow > 0) {
                                if ($verbose) {
                                    echo "Copying '$srcfile' to '$dstfile'...";
                                }
                                if (copy($srcfile, $dstfile)) {
                                    touch($dstfile, filemtime($srcfile));
                                    $num++;
                                    if ($verbose) {
                                        echo "OK\n";
                                    }
                                }
                                else {
                                    echo "Error: File '$srcfile' could not be copied!\n";
                                }
                            }
                        }
                        else if (is_dir($srcfile)) {
                            $num += $this->_moveStaticContent($srcfile, $dstfile, $verbose);
                        }
                    }
                }
                closedir($curdir);
            }
            return $num;
        }
    }

    /**
     * Copies relevant landing page files into the target publish path.
     * This needs to be revisited after GUI support has been added for this.
     * @author  mz
     * @version 1.0
     */
    function _moveLandingPageFiles() {
        if ($this->site->get('editorialLandingPgPath') != '') {
            $destDir = $this->destDir . '/credit-card-news/landing-module-content/';
            $this->_moveStaticContent($this->site->get('editorialLandingPgPath'), $destDir);
        }

        if ($this->site->get('creditCardNewsPg') != '') {
            $destDir = $this->destDir;
            $fileName = end(explode('/', $this->site->get('creditCardNewsPg')));
            copy($this->site->get('creditCardNewsPg'), $this->destDir . '/' . $fileName);
        }

        return;
    }

    /**
     * Copies relevant landing page files into the target publish path.
     * This needs to be revisited after GUI support has been added for this.
     * @author  mz
     * @version 1.0
     */
    function _moveOldArtciles() {
        // this should only exec for cccom.  - mz 2/19/08
        if ($this->site->get('siteName') != 'CreditCards.com' && $this->site->get('siteName') != 'New CreditCards.com') {
            return;
        }

        $this->_moveStaticContent(OLD_ARTICLES_PATH, $this->destDir);

        return;
    }

    function _getSiteAID($site) {
        // I don't feel like creating a constant for the default, since this will possibly get reworked soon. The 1017 is cccom's AID.
        return isset($this->siteAIDMap[$site]) ? $this->siteAIDMap[$site] : 1017;
    }

    function _getPageCID($page) {
        // I don't feel like creating a constant for the default, since this will possibly get reworked soon. The 10000 is the CID for card pages.
        return isset($this->pageCIDMap[$page]) ? $this->pageCIDMap[$page] : 10000;
    }

    /**
     * Copies relevant landing page files into the target publish path.
     * This needs to be revisited after GUI support has been added for this.
     * @author  mz
     * @version 1.0
     */
    function _getSiteMapPageVariables() {
        $channel = 'tools';
        $prop1 = 'tools';
        $pageName = 'tools:site map';

        return array('channel' => $channel, 'prop1' => $prop1, 'pageName' => $pageName);
    }

    /**
     * Move static content from the source folder into the destination folder
     * @author  Patrick Mizer
     * @version 1.0
     */
    function _moveStaticContent($srcdir, $dstdir, $verbose = FALSE) {
        $num = 0;
        if (!is_dir($dstdir)) {
            mkdir($dstdir);
        }
        if ($curdir = opendir($srcdir)) {
            while ($file = readdir($curdir)) {
                if ($file != '.' && $file != '..' && $file != 'CVS') {
                    $srcfile = $srcdir . '/' . $file;
                    $dstfile = $dstdir . '/' . $file;
                    if (is_file($srcfile)) {
                        if ($verbose) {
                            echo "Copying '$srcfile' to '$dstfile'...<br>";
                        }
                        if (copy($srcfile, $dstfile)) {
                            touch($dstfile, filemtime($srcfile));
                            $num++;
                            if ($verbose) {
                                echo "OK<br>";
                            }
                        }
                        else {
                            echo "Error: File '$srcfile' could not be copied!\n";
                        }
                    }
                    else if (is_dir($srcfile)) {
                        $num += $this->_moveStaticContent($srcfile, $dstfile, $verbose);
                    }
                }
            }
            closedir($curdir);
        }
        return $num;
    }

    /**
     * Move static content from the source folder into the destination folder
     * @author  Patrick Mizer
     * @version 1.0
     */
    function _moveStaticDirContent($srcdir, $dstdir, $verbose = FALSE) {
        $num = 0;
        if (!is_dir($dstdir)) {
            mkdir($dstdir);
        }
        if ($curdir = opendir($srcdir)) {
            while ($file = readdir($curdir)) {
                if ($file != '.' && $file != '..' && $file != 'CVS') {
                    $srcfile = $srcdir . '/' . $file;
                    $dstfile = $dstdir . '/' . $file;
                    if (is_file($srcfile)) {
                        if (is_file($dstfile)) {
                            $ow = filemtime($srcfile) - filemtime($dstfile);
                        }
                        else {
                            $ow = 1;
                        }
                        if ($ow > 0) {
                            if ($verbose) {
                                echo "Copying '$srcfile' to '$dstfile'...";
                            }
                            if (copy($srcfile, $dstfile)) {
                                touch($dstfile, filemtime($srcfile));
                                $num++;
                                if ($verbose) {
                                    echo "OK\n";
                                }
                            }
                            else {
                                echo "Error: File '$srcfile' could not be copied!\n";
                            }
                        }
                    }
                    else if (is_dir($srcfile)) {
                        $num += $this->_moveStaticContent($srcfile, $dstfile, $verbose);
                    }
                }
            }
            closedir($curdir);
        }
        return $num;
    }

    /**
     * Removes a directory
     * @author  Patrick Mizer
     * @version 1.0
     */
    function _rmDir($dir) {
        $file_deleted = 0;
        $dir_deleted = 0;
        if (!$dh = @opendir($dir)) {
            return;
        }
        while (($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..') {
                continue;
            }
            if (!@unlink($dir . '/' . $obj)) {
                $this->_rmDir($dir . '/' . $obj);
            }
            else {
                $file_deleted++;
            }
        }
        if (@rmdir($dir)) {
            $dir_deleted++;
        }
    }

    /**
     * makes a curl request to a given url and returns the response
     * as a string.
     * @author  mz
     * @date    1/22/08
     */
    function _cUrlRequest($url) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Don't return the header, just the html    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return contents as a string                        

        $errorNumber = curl_errno($ch);
        $contents = curl_exec($ch);

        curl_close($ch);

        return array('errorNumber' => $errorNumber, 'contents' => $contents);
    }

    /**
     * Build the redirect pages for the site
     *
     * @author  Jason Huie
     * @date    3/16/2009
     */
    function _buildRedirects() {
        $pages = $this->site->getCardPages();

        foreach (CMS_libs_Sites::getCardsBySiteId($this->site->get('siteId')) as $card) {
            if ($card['cardLink'] != NULL) {
                $filename = $this->destDir . '/' . $this->site->get('individualcarddir') . '/' . $card['cardLink'] . '.' . $this->site->get('pagetype');
                $destination = isset($pages[$card['merchantcardpage']]) ? $this->site->get('publishurl') . '/' . $pages[$card['merchantcardpage']]->get('pageLink') . '.' . $this->site->get('pagetype') : '/index.php';
                $content = <<<REDIRECT
<?
// DISCONTINUED PAGE
Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: $destination" );
?>
REDIRECT;
                $fh = fopen($filename, 'w');
                fwrite($fh, $content);
                fclose($fh);
            }
        }

        foreach ($this->site->getRedirects() as $filename => $destination) {
            $filename = $this->destDir . '/' . $filename . '.' . $this->site->get('pagetype');

            $content = <<<REDIRECT
<?
// DISCONTINUED PAGE
Header( "HTTP/1.1 301 Moved Permanently" );
Header( "Location: $destination?\$_SERVER[QUERY_STRING]" );
?>
REDIRECT;

            $fh = fopen($filename, 'w');
            fwrite($fh, $content);
            fclose($fh);
        }
    }

}
