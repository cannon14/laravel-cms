<?php   
/**
 *
 * CreditCards.com
 * 7/13/2006
 *
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 *
 * @package CMS_Lib
 */
csCore_Import::importClass('CMS_libs_Cards');

abstract class CMS_libs_Pagination {

	private static function _getPageCount($page, $pageNumber) {
		$totalPages = NULL;
		$totalCards = 0;
		$numCardsOnThisPg = count($page->getCards());

		foreach($page->getCards() as $card){
			if($card->get('active') == 1)$totalCards++;
		}
		foreach ($page->getSubPages() as $sub){
			foreach($sub->getCards() as $card){
				if($card->get('active') == 1){
					$totalCards++;
				}
			}
		}


      // Changes below were made to aid in rendering correct card count
      // on page 1 vs. subsequent pages.  Original code commented.  - mz 1/3/08
      $cardCountOnPage1 = $page->properties['itemsOnFirstPage'];
      if($page->properties['showMainCatOnFirstPage'] == 1)
      {
         // if the number of cards designated for page 1 is > than the actual # of
         // cards assigned to that pg, then we use the actual.  - mz 1/4/08
         if($page->properties['itemsOnFirstPage'] > $numCardsOnThisPg)
         {
            $cardCountOnPage1 = $numCardsOnThisPg;
         }
      }

		if ($totalCards > $cardCountOnPage1) {
			$cardsPerPage = $page->properties['itemsPerPage'];
			$totalPages = ceil($totalCards/$cardsPerPage);
		}
		return $totalPages;
	}

	/**
	 * Builds a page navigation bar
	 * @author Jason Huie, Lawrence Behar
	 * @version 1.1
	 * @param Page A page object to build the navigation for
	 * @param int The page number to add style to the active page
	 * @return String HTML for the navbar
	 */
	public static function getNavBar($page, $pageNumber) {
		$pageNav = "<div class=nav-link>";
		$pageLink = $page->get('pageLink');
		$pageCount = self::_getPageCount($page, $pageNumber);
		//If there is no pagination, $pagecount is NULL
		if (!empty($pageCount)) {

			for ($x = 1; $x<=$pageCount; $x++) {
				$divider = self::_htmlDivider($x);
				$href = self::_htmlHref($pageLink, $x, 'getNavBar');
				$rel = self::_htmlRel($pageNumber, $x);
				$pageNav .= self::_htmlPageLink ($pageNumber, $divider, $href, $x);
			}
		}
		$pageNav .= '</div>';
		return $pageNav;
	}

	/**
	 * Get link rel="prev" and link rel="next" tags
	 *
	 * @param type $page
	 * @param type $pageNumber
	 * @return type
	 */
	public static function getLinkTags($page,$pageNumber) {
		$linkTags = '';
		$pageLink = $page->get('pageLink');
		$pageCount = self::_getPageCount($page, $pageNumber);
		if (!empty($pageCount) && $pageNumber>1) { //prev
			$href = self::_htmlHref($pageLink, $pageNumber-1, 'getLinkTags');
			$rel = self::_htmlRel($pageNumber, $pageNumber-1);
			$linkTags .= self::_htmlLinkTag($rel, $href);
		}
		if (!empty($pageCount) && $pageNumber<$pageCount) { //next
			$href = self::_htmlHref($pageLink, $pageNumber+1, 'getLinkTags');
			$rel = self::_htmlRel($pageNumber, $pageNumber+1);
			$linkTags .= self::_htmlLinkTag($rel, $href);
		}
		return $linkTags;
	}

	public static function getCanonicalTag($page) {
		$pageLink = $page->get('pageLink');
		$canonicalTag = '<link rel="canonical" href="http://www.creditcards.com/'.$pageLink.'.php" />';

		return $canonicalTag;
	}

	private static function _htmlLinkTag($rel, $href) {
		$linkTag = "<link{$rel}{$href} />\n";
		return $linkTag;
	}

	private static function _htmlPageLink ($pageNumber, $divider, $href, $x) {
		$pageNav = '';

		if($x !== $pageNumber){
			$pageNav = $divider . "<a{$href}>Page $x</a>";
		}else{
			$pageNav = $divider . "Page $x";
		}

		return $pageNav;
	}

	private static function _htmlHref ($pageLink, $x, $caller) {
		$href = '';
		if ($x === 1) {
			$href = " href=\"{$pageLink}.php\"";
			if ($caller == 'getLinkTags') {
				$href = " href=\"/{$pageLink}.php\"";
			}
		}else{
			$href = " href=\"{$pageLink}-page-{$x}.php\"";
			if ($caller == 'getLinkTags') {
				$href = " href=\"/{$pageLink}-page-{$x}.php\"";
			}
		}
		return $href;
	}

	private static function _htmlRel ($pageNumber, $x) {
		$rel = '';
		if ($x === $pageNumber-1) {
			$rel = ' rel="prev"';
		}elseif ($x === $pageNumber+1) {
			$rel = ' rel="next"';
		}
		return $rel;
	}

	private static function _htmlDivider ($x) {
		$divider = ($x === 1) ? '' : ' | ';
		return $divider;
	}


	/**
     * Builds a sub-page navigation bar
     * @author Jason Huie
     * @version 2.0
     * @param Page A page object to build the navigation for
     * @param int The page number to add style to the active page
     * @return String HTML for the navbar
     */
    public static function getSubPageNavBar($page, $subPage = null){
    	$nav = '';

        //if the current subpage is null, then we are writing the main the page and need to write the nav to reflect that
        if($subPage === null) $subPage = $page;

        $count = sizeof($page->getCards());

        $navArray[] = $page->get('pageName') != $subPage->get('pageName')?
                      '<a href="'.$page->get('pageLink').'.php#top">'.$page->get('navBarString').'</a>':
                      $page->get('navBarString');

        $mySubPages = $page->getSubPages();
        $count++;

        foreach($mySubPages as $mySubPage){

        	/*if we show all featured cards on the first page only, then we'll use the number of cards on the main page to calculate the page number*/
        	if($page->get('showMainCatOnFirstPage') && $page->get('itemsOnFirstPage') >= sizeof($page->getCards()))
        		$pageNumber = 1 + ceil(($count - sizeof($page->getCards()))/$page->get('itemsPerPage'));

        	/*otherwise we default to the actual number of cards allowed*/
        	else
        	   $pageNumber = 1 + ceil(($count - $page->get('itemsOnFirstPage'))/$page->get('itemsPerPage'));


            if($pageNumber > 1)
	            $navArray[] = $subPage->get('pageName') != $mySubPage->get('pageName')?
	                          '<a href="'.$page->get('pageLink')."-page-".$pageNumber.'.php#'.$mySubPage->get('pageAnchor').'">'.$mySubPage->get('navBarString').'</a>':
	                          $mySubPage->get('navBarString');
	        else
	            $navArray[] = $subPage->get('pageName') != $mySubPage->get('pageName')?
                              '<a href="'.$page->get('pageLink').'.php#'.$mySubPage->get('pageAnchor').'">'.$mySubPage->get('navBarString').'</a>':
                              $mySubPage->get('navBarString');

            $count += sizeof($mySubPage->getCards());
        }

        $nav .= implode(' | ', $navArray);

        return $nav;
    }

	/**
     * Builds a sub-page navigation bar
     * @author Jason Huie
     * @version 2.0
     * @param Page A page object to build the navigation for
     * @param int The page number to add style to the active page
     * @return String HTML for the navbar
     */
    public static function getMspSubPageNavBar($page, $subPage = null){
    	$nav = '';

        //if the current subpage is null, then we are writing the main the page and need to write the nav to reflect that
        if($subPage === null) $subPage = $page;

        $count = sizeof($page->getMerchantServices());

        $navArray[] = $page->get('pageName') != $subPage->get('pageName')?
                      '<a href="'.$page->get('pageLink').'.php#top">'.$page->get('navBarString').'</a>':
                      $page->get('navBarString');

        $mySubPages = $page->getSubPages();
        $count++;

        foreach($mySubPages as $mySubPage){

        	/*if we show all featured cards on the first page only, then we'll use the number of cards on the main page to calculate the page number*/
        	if($page->get('showMainCatOnFirstPage') && $page->get('itemsOnFirstPage') >= sizeof($page->getMerchantServices()))
        		$pageNumber = 1 + ceil(($count - sizeof($page->getMerchantServices()))/$page->get('itemsPerPage'));

        	/*otherwise we default to the actual number of cards allowed*/
        	else
        	   $pageNumber = 1 + ceil(($count - $page->get('itemsOnFirstPage'))/$page->get('itemsPerPage'));


            if($pageNumber > 1)
	            $navArray[] = $subPage->get('pageName') != $mySubPage->get('pageName')?
	                          '<a href="'.$page->get('pageLink')."-page-".$pageNumber.'.php#'.$mySubPage->get('pageAnchor').'">'.$mySubPage->get('navBarString').'</a>':
	                          $mySubPage->get('navBarString');
	        else
	            $navArray[] = $subPage->get('pageName') != $mySubPage->get('pageName')?
                              '<a href="'.$page->get('pageLink').'.php#'.$mySubPage->get('pageAnchor').'">'.$mySubPage->get('navBarString').'</a>':
                              $mySubPage->get('navBarString');

            $count += sizeof($mySubPage->getMerchantServices());
        }

        $nav .= implode(' | ', $navArray);

        return $nav;
    }
}
