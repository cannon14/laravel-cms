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
csCore_Import::importClass('CMS_libs_SubPages');
csCore_Import::importClass('CMS_libs_SiteComponents');

csCore_Import::importClass('CMS_libs_MergeFilter');
csCore_Import::importClass('CMS_libs_Pagination');

class CMS_libs_Previewer
{
	private $cards;
	private $site;
    private $page;
	private $subPages;
	
	function CMS_libs_Previewer($id){
		$rs = CMS_libs_Sites::getSite($id);
		$this->site = new site($rs->fields);
		if($this->site->get('siteId') != $id){
			_setMessage("Site could not be found!", true, __LINE__, __FILE__);
		}
    }
    
    public function getSite(){
    	return $this->site;
    }
    
	public function compilePage($pageId){
        $rs = CMS_libs_Pages::getPageByIdAndSite($pageId, $this->site->get('siteId'));
        $this->page = new page($rs->fields);
	}
    
    public function compileSubPages($struct){
        foreach($struct as $subpageId => $cardsId){
            if($subpageId != $this->page->get('cardpageId')){
                $rs = CMS_libs_Pages::getPageByIdAndSite($subpageId, $this->site->get('siteId'));
                $this->subPages[$rs->fields['cardpageId']] = new page($rs->fields);
            }
    	}

//        print '<pre>'; print_r($this->subPages); print '</pre>';
    }

    public function compileCards($struct){
        foreach($struct as $pageId => $cardsId){
            foreach($cardsId as $id){
                $rs = CMS_libs_Cards::getCardByIdAndSite($id, $this->site->get('siteId'));
                $this->cards[$pageId][$rs->fields['cardId']] = new card($rs->fields);
            }
        }

//        print '<pre>'; print_r($this->cards); print '</pre>';
	}
	
	public function compileSite(){
        //add cards to the main page
        $this->page->addCards($this->cards[$this->page->get('cardpageId')]);

        //add cards to all the sub-pages
        foreach($this->subPages as $subpage){
            $subpage->addCards($this->cards[$subpage->get('cardpageId')]);
        }

        //add all the sub-pages to the main page
        $this->page->addSubPages($this->subPages);
	}

    public function preview(){
        $merger = new CMS_libs_MergeFilter();
        $page = $this->page;

        $pageNumber = 1;
        $overallRank = 1;
        $counter = 1;

        $contents = array();
        //$subPages = $page->getSubPages();
        $cards = $page->getCards();

        $bufferedPage =& csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_'.$this->site->get('layout').'CardPageLayout');
        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);

        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'));
        $subPageNav = $page->get('subPageNav') ?
            CMS_libs_Pagination::getSubPageNavBar($page) :
            null;

        $pageNumber == 1 ?
            $bufferedPage->writeSubHeader($page, '', $subPageNav) :
            $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);

        $topcard = '';

        foreach ($cards as $card){
           if($card->get('active')== 1){
              $cardData = array();
              foreach($card->cardDetail as $header => $detail){
                 $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
              }

              //add cardpage
              if(!$bufferedPage){
                 $bufferedPage =& csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_'.$this->site->get('layout').'CardPageLayout');
                 $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                 $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'));
                 $subPageNav = $page->get('subPageNav')?CMS_libs_Pagination::getSubPageNavBar($page):null;
                 $bufferedPage->writeSubHeader($page, $pageNav, $subPageNav);
              }
              $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties, $pageNumber);

               $counter++;
               $overallRank++;
            }
         }

        $subPages = $this->page->getSubPages();
        
         //sub-pages
         foreach($subPages as $subPage)
         {
            if(!$subPage->get('hide') && $subPage->getActiveCardCount() > 0){
               if(!$bufferedPage){
                  $bufferedPage = csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_'.$this->site->get('layout').'CardPageLayout');
                  $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                  $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'));
               }

               $subPageNav = $page->get('subPageNav') ?
                CMS_libs_Pagination::getSubPageNavBar($page, $subPage) :
                null;
               $bufferedPage->writeSubHeader($subPage,'', $subPageNav, false);
               $merger = new CMS_libs_MergeFilter();
               $cards = $subPage->getCards();

               $subpageRank = 1;

               foreach ($cards as $card)
               {
                  if($card->get('active') == 1){
                     //add card page
                     if(!$bufferedPage){
                        $bufferedPage =& csCore_Import::instanciateObject('CMS_layouts_cardpagelayouts_'.$this->site->get('layout').'CardPageLayout');
                        $pageNav = CMS_libs_Pagination::getNavBar($page, $pageNumber);
                        $bufferedPage->writeHeader($page, $pageNumber, $this->site->get('pagetype'), $page->get('rootPath'));
                        $subPageNav = $page->get('subPageNav')?CMS_libs_Pagination::getSubPageNavBar($page, $subPage):null;
                        $bufferedPage->writeSubHeader($subPage, $pageNav, $subPageNav, true);
                     }

                     $cardData = array();
                     foreach($card->cardDetail as $header => $detail){
                        $cardData[$header] = $merger->translate($detail, $card->get('cardId'));
                     }

                     $bufferedPage->writeCard($page, $card, $cardData, $counter, $this->site->properties);

                     
                     $counter++;
                     $subpageRank++;
                     $overallRank++;
                  }
               }
            }
         }

         //save page
         if($bufferedPage){
            $bufferedPage->writeSubFooter($page, $pageNav, $pageNumber, null);
            $bufferedPage->writeFooter($page, $pageNumber);

            $html = preg_replace('/<\?.*?(\?>)/s', '', $bufferedPage->getBufferedOutput());
            return str_replace('="/', '="http://www.creditcards.com/', $html);
         }
      }
}
?>
