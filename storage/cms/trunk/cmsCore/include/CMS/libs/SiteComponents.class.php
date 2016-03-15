<?PHP

csCore_Import::importClass('CMS_libs_MergeFilter');

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
 * <jasonh@creditcards.com>
 *
 * @package CMS_Lib
 */
class CMS_libs_siteComponents
{
	var $properties = array();

	/**
	 * Constructor
	 * @author Patrick Mizer
	 * @version 1.0
	 */
	function component()
	{}

	/**
	 * Add one property to a component
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param String Property Name
	 * @param String Property Value
	 */
	function addProperty($propName, $propValue)
	{
		$this->properties[$propName] = $propValue;
	}

	/**
	 * Set the component properties to an array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Properties ($field=>$value)
	 */
	function setProperties($properties)
	{
		$this->properties = properties;
	}

	/**
	 * Get a property from the component
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param String Property Name
	 * @return String Property Value
	 */
	function get($col)
	{
		return isset($this->properties[$col]) ? $this->properties[$col] : '';
	}

	/*
	* Sets a property
	* @author mz
	* @version 1.0
	* @param String Property Name
	*/
function set($propertyName, $property)
{
	$this->properties[$propertyName] = $property;
}

	/**
	 * Get the formatted title of the component
	 * @author Jason Huie
	 * @version 1.0
	 * @param String Component Title
	 * @abstract
	 */
	function getTitle()
	{
		return "OVERRIDE";
	}

	/**
	 * Get the properties array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @abstract
	 */
	function getComponents()
	{
		return array();
	}

	/**
	 * Get the formatted meta for the component
	 * @author Jason Huie
	 * @version 1.0
	 * @return String HTML for page meta
	 */
	function getPageMeta()
	{
		return isset($this->properties['pageMeta']) ? $this->properties['pageMeta'] : '';
	}
}

class site extends CMS_libs_siteComponents
{
	var $cardPages = array();
	var $merchantServicePages = array();
	var $merchantServiceApplicationPages = array();
	var $specialsPages = array();
	var $profilePages = array();
	var $indexPages = array();
	var $redirects = array();
	var $orphanedCards = array();

	/**
	 * Constructor -- initilizes the properties
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Site properties ($field=>$value)
	 */
	function site($fields)
	{
		$this->properties = $fields;
	}

	/**
	 * Get the card pages that belong to the site
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Card Pages
	 */
	function getCardPages()
	{
		return $this->cardPages;
	}

	function getOrphanedCards()
	{
		return $this->orphanedCards;
	}


	function getCardPage($id){
		if(isset($this->cardPages[$id])){
			return $this->cardPages[$id];
		}
		else if(isset($this->merchantServicePages[$id])){
			return $this->merchantServicePages[$id];
		}
		else if(isset($this->merchantServiceApplicationPages[$id])){
			return $this->merchantServiceApplicationPages[$id];
		}
		else if(isset($this->specialsPages[$id])){
			return $this->specialsPages[$id];
		}
		else if(isset($this->profilePages[$id])){
			return $this->profilePages[$id];
		}
	}

	/**
	 * Get the merchant service pages that belong to the site
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Merchant Service Pages
	 */
	function getMerchantServicePages()
	{
		return $this->merchantServicePages;
	}

	/**
	 * Get the application pages that belong to the site
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Merchant Service Pages
	 */
	function getMerchantServiceApplicationPages()
	{
		return $this->merchantServiceApplicationPages;
	}

	/**
	 * Get the specials pages that belong to the site
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Specials Pages
	 */
	function getSpecialsPages()
	{
		return $this->specialsPages;
	}

	/**
	 * Get the profile pages that belong to the site
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Specials Pages
	 */
	function getProfilePages()
	{
		return $this->profilePages;
	}

	/** Get the index pages that belong to the site
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Specials Pages
	 */
	function getIndexPages()
	{
		return $this->indexPages;
	}

	/**
	 * Add an array of cardpages to the sites card pages array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Card Pages
	 */
	function addCardPages($pages)
	{
		if(!is_array($pages))
			$pages = array($pages);
		foreach($pages as $page){
			if(is_object($page))
				$this->cardPages[$page->get('cardpageId')] = $page;
		}
	}

	function addOrphanedCards($cards)
	{
		if(!is_array($cards))
			$cards = array($cards);
		foreach($cards as $card){
			if(is_object($card))
				$this->orphanedCards[$card->get('cardId')] = $card;
		}
	}

	/**
	 * Add an array of merchant service pages to the sites merchant service pages array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Merchant Service Pages
	 */
	function addMerchantServicePages($pages)
	{
		if(!is_array($pages))
			$pages = array($pages);
		foreach($pages as $page){
			if(is_object($page)){
				$this->merchantServicePages[$page->get('cardpageId')] = $page;
			}
		}
	}

	/**
	 * Add an array of applicatoin pages to the sites merchant service pages array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Merchant Service Pages
	 */
	function addMerchantServiceApplicationPages($pages)
	{
		if(!is_array($pages))
			$pages = array($pages);
		foreach($pages as $page){
			if(is_object($page)){
				$this->merchantServiceApplicationPages[$page->get('cardpageId')] = $page;
			}
		}
	}

	/**
	 * Add an array of cardpages to the sites card pages array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Card Pages
	 */
	function addSpecialsPages($pages)
	{
		if(!is_array($pages))
			$pages = array($pages);
		foreach($pages as $page){
			if(is_object($page))
				$this->specialsPages[$page->get('cardpageId')] = $page;
		}
	}

	/**
	 * Add an array of profiles to the sites profiles pages array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Card Pages
	 */
	function addProfilePages($pages)
	{
		if(!is_array($pages))
			$pages = array($pages);
		foreach($pages as $page){
			if(is_object($page))
				$this->profilePages[$page->get('cardpageId')] = $page;
		}
	}

	/**
	 * Add an array of index pages to the sites index pages array
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Card Pages
	 */
	function addIndexPages($pages)
	{
		if(!is_array($pages))
			$pages = array($pages);
		foreach($pages as $page){
			if(is_object($page))
				$this->indexPages[$page->get('cardpageId')] = $page;
		}
	}

	function addRedirects($redirects){
		while(!$redirects->EOF){
			$this->redirects[$redirects->fields['filename']] = $redirects->fields['destination_url'];
			$redirects->MoveNext();
		}
	}

	/**
	 * Get the distinct cards from the site
	 * @author Patrick Mizer
	 * @version 1.0
	 * @return array Cards
	 */
	function getDistinctCards()
	{
		$cards = array();
		foreach($this->cardPages as $page){
			$pageCards = $page->getCards();
			foreach($pageCards as $card){
				$cards[$card->get('id')] = $card;}
		}
		return $cards;
	}

	/**
	 * Get the distinct components from the site
	 * @author Patrick Mizer
	 * @version 1.0
	 * @return array Components
	 */
	function getDistinctComponents()
	{
		$items = array();
		foreach($this->cardPages as $page){
			$pageComponents = $page->getComponents();
			foreach($pageComponents as $item)
				$items[$item->get('id')] = $item;
		}

		//$cards = array_merge($cards);
		return $items;
	}

	function getRedirects(){
		return $this->redirects;
	}

	/**
	 * Create a Javascript and HTML representation of the site displayed as a tree
	 * @author Patrick Mizer/Jason Huie
	 * @version 1.3
	 * @param String Source from which to retrieve data (ex. XML)
	 * @return String HTML and javascript for the site tree
	 */
	function displayStructure($source)
	{
		$tree = '<h1>'.$this->get('siteName').'</h1><ul class="siteTree">';
		foreach($this->cardPages as $page){
			$tree .= '<li>'.$page->get('pageName').'
						<ul class="siteTreePage">';
			$cards = $page->getCards();
			foreach($cards as $card){
			$tree .= '<li>'.$card->get('cardTitle').'</li>';
			}
			$subPages = $page->getSubPages();
			foreach($subPages as $subPage){
				$tree .= '<li>'.$subPage->get('pageName').'
							<ul class="siteTreeSubPage">';
				$subPageCards = $subPage->getCards();
				foreach($subPageCards as $subPageCard){
					$tree .= '<li>'.$subPageCard->get('cardTitle').'</li>';
				}
				$tree .= '</li></ul>';
			}
			$tree .= '</li></ul>';
		}

		//display Merchant service pages
		foreach($this->merchantServicePages as $page){
			$tree .= '<li>'.$page->get('pageName').'
						<ul class="siteTreeMerchantServicePage">';
			$merchantServices = $page->getMerchantServices();
			foreach($merchantServices as $merchantService){
				$tree .= '<li>'.$merchantService->get('merchant_service_name').'</li>';
			}
			$subPages = $page->getSubPages();
			foreach($subPages as $subPage){
				$tree .= '<li>'.$subPage->get('pageName').'
							<ul class="siteTreeSubPage">';
				$subPageCards = $subPage->getMerchantServices();
				foreach($subPageCards as $subPageMerchantService){
					$tree .= '<li>'.$subPageMerchantService->get('merchant_service_name').'</li>';
				}
				$tree .= '</li></ul>';
			}
			$tree .= '</li></ul>';
		}

		//display Specials Page
		foreach($this->specialsPages as $page){
			$tree .= '<li>'.$page->get('pageName').
					'<ul>';
			$cards = $page->getCards();
			foreach($cards as $card){
				$tree .= '<li>'.$card->get('cardTitle').'</li>';
			}
			$subPages = $page->getSubPages();
			foreach($subPages as $subPage){
				$tree .= '<li>'.$subPage->get('pageName').'<ul>';
				$subPageCards = $subPage->getCards();
				foreach($subPageCards as $subPageCard){
					$tree .= '<li>'.$subPageCard.'</li>';
				}
				$tree .= '</li></ul>';
			}
			$tree .= '</li></ul>';
		}

		$tree .= '<li>Profiles
						<ul>';
		foreach($this->profilePages as $page){
			$tree .= '<li>'.$page->get('pageName').'</li>';
		}
		$tree .= '</li></ul>';

		return $tree;
	}
}

class page extends CMS_libs_siteComponents
{
	var $cards = array();
	var $merchantServices = array();
	var $subPages = array();
	var $components = array();
	var $profiles = array();
	var $itemsPerPage;

	/**
	 * Constructor -- initilize the properties array
	 * @author Patrick Mizer
	 * @version 1.0
	 */
	function __construct($fields)
	{
		$this->properties = $fields;
	}

	/**
	 * Add cards to the page
	 * @author Patrick Mizer
	 * @version 1.0
	 * @param array Cards to be added
	 */
	function addCards($cards)
	{
		if(!is_array($cards))
			$cards = array($cards);
		foreach($cards as $card){
			if(is_object($card))
				//$this->cards[$card->getId()] = $card;
				$this->cards[] = $card;
		}
	}

	/**
	 * Add merchant services to the page
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Merchant Services to be added
	 */
	function addMerchantServices($merchantServices)
	{
		if(!is_array($merchantServices))
			$merchantServices = array($merchantServices);
		foreach($merchantServices as $merchantService){
			if(is_object($merchantService)){
//                print '<pre>'; print_r($merchantService);print'</pre>';
				$this->merchantServices[$merchantService->getId()] = $merchantService;
			}
		}
	}

	/**
	 * Add sub-pages to the page
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Sub-pages to be added
	 */
	function addSubPages($subPages)
	{
		if(!is_array($subPages))
			$subPages = array($subPages);
		foreach($subPages as $subPage){
			if(is_object($subPage)){
				$subPage->properties['pageAnchor'] = $subPage->get('pageLink');
				$subPage->properties['pageLink'] = $this->calculateSubPageLink($subPage);
				$this->subPages[] = $subPage;
			}
		}
	}

	function calculateSubPageLink($subPage){
		$totalCards = sizeof($this->getCards());
		foreach($this->subPages as $subPage){
			$totalCards += sizeof($subPage->getCards());
		}

		//+1 in case we are at the bottom of the page
		$totalCards++;

		/**
		 * ok, so now we see how many cards are on the first page.
		 * this may seem simple but we need to take into account that we added some stupid stuff
		 * a while back that we have to now support (the show only main category on first page)
		 */
		if($this->get('showMainCatOnFirstPage') && $this->get('itemsOnFirstPage') >= sizeof($this->getCards())){
			$pageNumber = ($totalCards - sizeof($this->getCards()))/$this->get('itemsPerPage');
		}else{
			$totalCards -= $this->get('itemsOnFirstPage');
			$pageNumber = ceil($totalCards/$this->get('itemsPerPage')) + 1;
		}

		return $pageNumber > 1 ?
					$this->get('pageLink') . '-page-' . $pageNumber :
					$this->get('pageLink');
	}

	/**
	 * Add components to the page
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Components to be added
	 */
	function addComponents($components)
	{
		if(!is_array($components))
			$components = array($components);
		foreach($components as $component){
			if(is_object($component))
				$this->components[$component->properties['rank']] = $component;
		}
	}

	/**
	 * Get the cards associated with the page
	 * @author Patrick Mizer
	 * @version 1.0
	 * @return array Cards
	 */
	function getCards()
	{
		return $this->cards;
	}

	/**
	 * Get the merchant services associated with the page
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Merchant Services
	 */
	function getMerchantServices()
	{
		return $this->merchantServices;
	}

	/**
	 * Get the number of cards associated with the page
	 * @author Jason Huie
	 * @version 1.0
	 * @return int Card count
	 */
	function getNumberOfCards()
	{
		return sizeof($this->cards);
	}

	/**
	 * Get the sub-pages associated with the page
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Sub-pages
	 */
	function getSubPages()
	{
		return $this->subPages;
	}

	/**
	 * Get the components associated with the page
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Comonponents
	 */
	function getComponents()
	{
		return $this->components;
	}

	/**
	 * Get the formatted title of the page
	 * @author Jason Huie
	 * @version 1.0
	 * @return String Title
	 */
	function getTitle()
	{
		return cleanTitle($this->get('pageTitle'));
	}

	/**
	 * Get the number of active cards on this page
	 * @return int
	 */
	function getActiveCardCount(){
		$cnt = 0;
		foreach($this->cards as $card){
			if($card->get('active') == 1){
				++$cnt;
			}
		}
		return $cnt;
	}


	function getCardView($inCard){

		$myCard = CMS_libs_Cards::getExtendedCard($inCard->get('cardId'));

		$outArray = array();

		$merger = new CMS_libs_MergeFilter();

		// Change per requirement from Jasonh, meeting 11-Nov-09 PM
		// Adjust the order of prepaid card fields

			if ($this->get('active_introApr'))
			{
				$outArray[LANG_INTRO_APR] = $myCard->fields['introApr'];
			}
			if ($this->get('active_introAprPeriod'))
			{
				$outArray[LANG_INTRO_APR_PERIOD] = $myCard->fields['introAprPeriod'];
			}
			if ($this->get('active_regularApr'))
			{
				$outArray[LANG_REGULAR_APR] = $myCard->fields['regularApr'];
			}
			if ($this->get('active_annualFee'))
			{
				$outArray[LANG_ANNUAL_FEE] = $myCard->fields['annualFee'];
			}
			if ($this->get('active_balanceTransfers'))
			{
				$outArray[LANG_BALANCE_TRANSFERS] = $myCard->fields['balanceTransfers'];
			}
			if ($this->get('active_balanceTransferFee'))
			{
				$outArray[LANG_BALANCE_TRANSFER_FEE] = $myCard->fields['balanceTransferFee'];
			}
			if ($this->get('active_balanceTransferIntroApr'))
			{
				$outArray[LANG_BALANCE_TRANSFER_INTRO_APR] = $myCard->fields['balanceTransferIntroApr'];
			}
			if ($this->get('active_balanceTransferIntroAprPeriod'))
			{
				$outArray[LANG_BALANCE_TRANSFER_INTRO_APR_PERIOD] = $myCard->fields['balanceTransferIntroAprPeriod'];
			}
			if ($this->get('active_activationFee'))
			{
				$outArray[LANG_ACTIVATION_FEE] = '$'. $myCard->fields['ccx_pp_activation_fee'] . '*';
			}
			if ($this->get('active_monthlyFee'))
			{
				$outArray[LANG_MONTHLY_FEE] = $myCard->fields['monthlyFee'];
			}
			if ($this->get('active_transactionFeeSignature'))
			{
				$outArray[LANG_TRANSACTION_FEE_SIGNATURE] = '$'. $myCard->fields['ccx_pp_signature_transaction_fee'] . '*';
			}
			if ($this->get('active_transactionFeePin'))
			{
				$outArray[LANG_TRANSACTION_FEE_PIN] = '$'. $myCard->fields['ccx_pp_pin_transaction_fee'] . '*';
			}
			if ($this->get('active_atmFee'))
			{
				$outArray[LANG_ATM_FEE] = '$'. $myCard->fields['ccx_pp_atm_fee'] . '*';
			}
			if ($this->get('active_loadFee'))
			{
				$outArray[LANG_LOAD_FEE] = '$'. $myCard->fields['ccx_pp_load_fee'] . '*';
			}
			if ($this->get('active_creditNeeded'))
			{
				$outArray[LANG_CREDIT_NEEDED] = $myCard->fields['creditNeeded'];
			}
			if ($this->get('active_prepaidText'))
			{
				$outArray[LANG_PREPAID_TEXT] = $myCard->fields['ccx_custom_prepaid_display_text'];
			}

		return $outArray;
	}

} // end class page

class card extends CMS_libs_siteComponents
{
	/**
	 * Constructor -- initilize the properties array/sets the cardDetail array ($display=>$field)
	 * @author Patrick Mizer
	 * @version 1.0
	 */
	function __construct($fields)
	{
		$this->properties = $fields;


		if($fields['active_introApr']==1) {
			$this->cardDetail['Intro APR']=$fields['introApr'];
		}

		/*
		 * Find out the actual value for the BT intro APR
		 * It could be N/A, the override or the numeric value
		 */
		$noAtAt = strpos($fields['balanceTransferIntroApr'],"@@") === false;
		$numValue = isset($fields['ccx_bt_intro_apr']) ? $fields['ccx_bt_intro_apr'] : null;


		if($fields['balanceTransferIntroApr'] == '') {
			$this->cardDetail['Balance Transfer Intro APR'] = $numValue . '%';
		} else {
			if ($noAtAt) {
				$this->cardDetail['Balance Transfer Intro APR'] = $fields['balanceTransferIntroApr'];
			} else {
				if($numValue != '999.00') {
					if($numValue == 0) $numValue = '0';

					$override =  $fields['balanceTransferIntroApr'];

					// Don't add another '%' if the override already has one
					$override = str_replace('@@balanceTransferIntroApr@@ %', $numValue.' %', $override);
					$override = str_replace('@@balanceTransferIntroApr@@%', $numValue.'%', $override);
					$override = str_replace('@@balanceTransferIntroApr@@', $numValue.'%', $override);

					$this->cardDetail['Balance Transfer Intro APR'] = $override;
				} else {
					$this->cardDetail['Balance Transfer Intro APR'] = 'N/A';
				}
			}
		}

		if($fields['active_balanceTransferFee']==1){
			$this->cardDetail['Transfer Fee']=$fields['balanceTransferFee'];
		}

		if($fields['active_introAprPeriod']==1) {
			$this->cardDetail['Intro APR Period']=$fields['introAprPeriod'];
			$value = '';

			if (isset($fields['ccx_intro_apr']) &&  isset($fields['ccx_intro_period_end_date']) && $fields['ccx_intro_period_end_date']) {
				if ($fields['ccx_intro_apr'] != '999.00' && $fields['ccx_intro_period_end_date'] != '0000-00-00') {
					$this->cardDetail['Intro APR Period']= 'Until '. date('m/Y', strtotime($fields['ccx_intro_period_end_date']));
				}
			}

			if (isset($fields['ccx_min_intro_period']) && isset($fields['ccx_max_intro_period'])) {
				$min = $fields['ccx_min_intro_period'];
				$max = $fields['ccx_max_intro_period'];

				if ($min != $max && $min && $max) {
					$value = $min. '-'. $max;

					$this->cardDetail['Intro APR Period']= str_replace('@@introAprPeriod@@', $value, $this->cardDetail['Intro APR Period']);
				}
			}
		}

		$value = '';

		if (isset($fields['ccx_min_ongoing_apr']) &&
			isset($fields['ccx_max_ongoing_apr']) &&
			isset($fields['min_ongoing_apr_used_rate_type'])
		) {
			$min = number_format($fields['ccx_min_ongoing_apr'] *1, 2);
			$max = number_format($fields['ccx_max_ongoing_apr'] *1, 2);
			$type = $fields['min_ongoing_apr_used_rate_type'];

			// Temporary hack - this needs to be fixed in the CCX adapter
			$type = ($type == 'variable') ? ' (Variable)' : '';

			if ($min != 999.00) {
				if ($min != $max) {
					$value = "$min%-$max%";
				} else {
					$value = "$min%";
				}

				$value .= $type;
			}
		}

		if($fields['active_regularApr']==1 && $fields['active_balanceTransferIntroApr']) {
			$this->cardDetail['Typical APR']=$fields['regularApr'];

			if ($value) {
				$this->cardDetail['Typical APR'] = str_replace('@@regularApr@@%', $value, $fields['regularApr']);
			}
		}

		if($fields['active_regularApr']==1 && !$fields['active_balanceTransferIntroApr']) {
			$this->cardDetail['Regular APR']=$fields['regularApr'];

			if ($value) {
				$this->cardDetail['Regular APR'] = str_replace('@@regularApr@@%', $value, $fields['regularApr']);
			}
		}

		if($fields['active_annualFee']==1) {
			$this->cardDetail['Annual Fee']=$fields['annualFee'];
		}


		if($fields['active_monthlyFee']==1) {
			$this->cardDetail['Monthly Fee (up&nbsp;to)']=$fields['monthlyFee'];
		}

		if($fields['active_balanceTransfers']==1) {
			$this->cardDetail['Balance Transfers']=$fields['balanceTransfers'];
		}


		/*
		 * Balance Transfer Intro Period
		 */

		$override = $fields['balanceTransferIntroAprPeriod'];
		$this->cardDetail['Balance Transfer Intro Period'] = $override;


		if (isset($fields['ccx_bt_min_intro_period']) && isset($fields['ccx_bt_max_intro_period'])) {
			$min = $fields['ccx_bt_min_intro_period'];
			$max = $fields['ccx_bt_max_intro_period'];

			if ($min != $max) {
				$value = $min . '-' . $max;
			} else {
				$value = $min;
			}

			$this->cardDetail['Balance Transfer Intro Period'] = str_replace('@@balanceTransferIntroAprPeriod@@', $value, $override);
		}


		if (isset($fields['ccx_bt_intro_apr']) && isset($fields['ccx_bt_intro_period_end_date']) && $fields['ccx_bt_intro_period_end_date']) {
			if ($fields['balanceTransferIntroApr'] != '999.00' && $fields['ccx_bt_intro_period_end_date'] != '0000-00-00') {
				$this->cardDetail['Balance Transfer Intro Period'] = 'Until '. date('m/Y', strtotime($fields['ccx_bt_intro_period_end_date']));
			}
		}



		if($fields['active_creditNeeded']==1) {
			$this->cardDetail['Credit Needed']=$fields['creditNeeded'];
		}

	}

	/**
	 * Get the formatted title of the card
	 * @author Jason Huie
	 * @version 1.0
	 * @return String Title
	 */
	function getTitle()
	{
		return cleanTitle($this->get('categoryAltText'));
	}

	function getPageMeta(){
		return $this->get('cardPageMeta');
	}

	function getId(){
		return $this->properties['cardId'];
	}

	function getDefaultView(){
		$myCard = CMS_libs_Cards::getExtendedCard($this->get('cardId'));
		$outArray = array();
		$merger = new CMS_libs_MergeFilter();

		if ( ($myCard->fields['ccx_type'] == 'credit') || ($myCard->fields['ccx_type'] == 'charge') )
		{
			$outArray[LANG_INTRO_APR]         = $myCard->fields['introApr'];
			$outArray[LANG_INTRO_APR_PERIOD]  = $myCard->fields['introAprPeriod'];
			$outArray[LANG_REGULAR_APR]       = $myCard->fields['regularApr'];
			$outArray[LANG_ANNUAL_FEE]        = $myCard->fields['annualFee'];
			$outArray[LANG_BALANCE_TRANSFERS] = $myCard->fields['balanceTransfers'];
			$outArray[LANG_CREDIT_NEEDED]     = $myCard->fields['creditNeeded'];
		}

		// Fixed bug introduced in Revision 583 - labels for ATM and activation reversed
		if (   ($myCard->fields['ccx_type'] == 'secured'))
		{
			$outArray[LANG_ATM_FEE]                   = '$' . $myCard->fields['ccx_pp_atm_fee'] . '*';
			$outArray[LANG_MONTHLY_FEE]               = $myCard->fields['monthlyFee'];
			$outArray[LANG_TRANSACTION_FEE_SIGNATURE] = '$' . $myCard->fields['ccx_pp_signature_transaction_fee'] . '*';
			$outArray[LANG_TRANSACTION_FEE_PIN]       = '$' . $myCard->fields['ccx_pp_pin_transaction_fee'] . '*';
			$outArray[LANG_ACTIVATION_FEE]            = '$' . $myCard->fields['ccx_pp_activation_fee'] . '*';
			$outArray[LANG_LOAD_FEE]                  = '$' . $myCard->fields['ccx_pp_load_fee'] . '*';
			$outArray[LANG_CREDIT_NEEDED]             = $myCard->fields['creditNeeded'];
		}

		if (	($myCard->fields['ccx_type'] == 'debit'))
		{
			$outArray[LANG_ATM_FEE]                   = '$' . $myCard->fields['ccx_pp_atm_fee'] . '*';
			$outArray[LANG_MONTHLY_FEE]               = $myCard->fields['monthlyFee'];
			$outArray[LANG_TRANSACTION_FEE_SIGNATURE] = '$' . $myCard->fields['ccx_pp_signature_transaction_fee'] . '*';
			$outArray[LANG_TRANSACTION_FEE_PIN]       = '$' . $myCard->fields['ccx_pp_pin_transaction_fee'] . '*';
			$outArray[LANG_ACTIVATION_FEE]            = '$' . $myCard->fields['ccx_pp_activation_fee'] . '*';
			$outArray[LANG_LOAD_FEE]                  = '$' . $myCard->fields['ccx_pp_load_fee'] . '*';
			$outArray[LANG_CREDIT_NEEDED]             = $myCard->fields['creditNeeded'];
			$outArray[LANG_PREPAID_TEXT]			  = $myCard->fields['ccx_custom_prepaid_display_text'];
		}

		// Change per requirement from Fernando, e-mail 2:37pm 04-Nov-09
		// Adjust the order of prepaid card fields
		if (	($myCard->fields['ccx_type'] == 'prepaid')	)
		{
			$outArray[LANG_ACTIVATION_FEE]            = '$' . $myCard->fields['ccx_pp_activation_fee'] . '*';
			$outArray[LANG_MONTHLY_FEE]               = $myCard->fields['monthlyFee'];
			$outArray[LANG_TRANSACTION_FEE_SIGNATURE] = '$' . $myCard->fields['ccx_pp_signature_transaction_fee'] . '*';
			$outArray[LANG_TRANSACTION_FEE_PIN]       = '$' . $myCard->fields['ccx_pp_pin_transaction_fee'] . '*';
			$outArray[LANG_ATM_FEE]                   = '$' . $myCard->fields['ccx_pp_atm_fee'] . '*';
			$outArray[LANG_LOAD_FEE]                  = '$' . $myCard->fields['ccx_pp_load_fee'] . '*';
			$outArray[LANG_CREDIT_NEEDED]             = $myCard->fields['creditNeeded'];
			$outArray[LANG_PREPAID_TEXT]			  = $myCard->fields['ccx_custom_prepaid_display_text'];
		}

		// http://firstaid.inside.cs/view.php?id=28224
		// Adding basic fields based on prepaid just so we will have them available if we need them
		if (	($myCard->fields['ccx_type'] == 'giftcard')	)
		{
			$outArray[LANG_ACTIVATION_FEE]            = '$' . $myCard->fields['ccx_pp_activation_fee'] . '*';
			$outArray[LANG_MONTHLY_FEE]               = $myCard->fields['monthlyFee'];
			$outArray[LANG_TRANSACTION_FEE_SIGNATURE] = '$' . $myCard->fields['ccx_pp_signature_transaction_fee'] . '*';
			$outArray[LANG_TRANSACTION_FEE_PIN]       = '$' . $myCard->fields['ccx_pp_pin_transaction_fee'] . '*';
			$outArray[LANG_ATM_FEE]                   = '$' . $myCard->fields['ccx_pp_atm_fee'] . '*';
			$outArray[LANG_LOAD_FEE]                  = '$' . $myCard->fields['ccx_pp_load_fee'] . '*';
			$outArray[LANG_CREDIT_NEEDED]             = $myCard->fields['creditNeeded'];
			$outArray[LANG_PREPAID_TEXT]			  = $myCard->fields['ccx_custom_prepaid_display_text'];
		}

		return $outArray;
	}

	function getExtendedFields(){

		$myCard = CMS_libs_Cards::getExtendedCard($this->get('cardId'));

		return $myCard->fields;

	} // function getExtendedCard()

	// card::getTermsAndConditionsLink()
	// Returns a string containing a link to the card's terms and conditions
	// as defined in the TERM_LINKS_TABLE

	function getTermsAndConditionsLinkFields(){

		$myRs = CMS_libs_Cards::getTermsAndConditionsLink($this->get('cardId'));

		return $myRs->fields;

	} // function getTermsAndConditionsLink()

} // end class card

class merchantService extends CMS_libs_siteComponents
{
	/**
	 * Constructor -- initilize the properties array/sets the merchantServiceDetail array ($display=>$field)
	 * @author Jason Huie
	 * @version 1.0
	 */
	function merchantService($fields)
	{
		$this->properties = $fields;
		if($fields['active_setup_fee']==1)
			$this->merchantServiceDetail['Setup Fee']=$fields['setup_fee'];
		if($fields['active_monthly_minimum'])
			$this->merchantServiceDetail['Monthly Minimum']=$fields['monthly_minimum'];
		if($fields['active_gateway_fee'])
			$this->merchantServiceDetail['Gateway Fee']=$fields['gateway_fee'];
		if($fields['active_statement_fee'])
			$this->merchantServiceDetail['Statement Fee']=$fields['statement_fee'];
		if($fields['active_transaction_fee'])
			$this->merchantServiceDetail['Transaction Fee']=$fields['transaction_fee'];
		if($fields['active_discount_rate'])
			$this->merchantServiceDetail['Discount Rate']=$fields['discount_rate'];
		if($fields['active_tech_support_fee'])
			$this->merchantServiceDetail['Tech Support Fee']=$fields['tech_support_fee'];
	}

	/**
	 * Get the formatted title of the merchant service
	 * @author Jason Huie
	 * @version 1.0
	 * @return String Title
	 */
	function getTitle()
	{
		return cleanTitle($this->get('merchant_service_header_string'));
	}

	function getId(){
		return $this->properties['merchant_service_id'];
	}

	/**
	 * Get the formatted meta for the component
	 * @author Jason Huie
	 * @version 1.0
	 * @return String HTML for page meta
	 */
	function getPageMeta()
	{
		return isset($this->properties['page_meta']) ? $this->properties['page_meta'] : '';
	}
}

class pageComponent extends CMS_libs_siteComponents
{
	/**
	 * Constructor -- initilize the properties array
	 * @author Jason Huie
	 * @version 1.0
	 */
	function pageComponent($fields)
	{
		$this->properties = $fields;
	}
}

class profile extends CMS_libs_siteComponents
{
	/**
	 * Constructor -- initialize the properties array
	 * @author Jason Huie
	 * @version 1.0
	 */
	function profile($fields)
	{
		$this->properties = $fields;
	}

	/**
	 * Get the formatted title
	 * @author Jason Huie
	 * @version 1.0
	 * @return String Title
	 */
	function getTitle()
	{
		return $this->get('title');
	}

	/**
	 * Add components to the profile
	 * @author Jason Huie
	 * @version 1.0
	 * @param array Components to be added
	 */
	function addComponents($components)
	{
		if(!is_array($components))
			$components = array($components);
		foreach($components as $component){
			if(is_object($component)){
				$this->components[$component->properties['rank']] = $component;
			}
		}
	}

	/**
	 * Get the components associated with the profile
	 * @author Jason Huie
	 * @version 1.0
	 * @return array Components
	 */
	function getComponents()
	{
		return $this->components;
	}
}

class generic extends CMS_libs_siteComponents
{
	/**
	 * Constructor -- initialize the properties array
	 * @author Jason Huie
	 * @version 1.0
	 */
	function generic($fields)
	{
		$this->properties = $fields;
	}

	/**
	 * Get the formatted title
	 * @author Jason Huie
	 * @version 1.0
	 * @return String Title
	 */
	function getTitle()
	{
		return $this->get('title');
	}

	/**
	 * Get the formatted title
	 * @author Jason Huie
	 * @version 1.0
	 * @return String Title
	 */
	function getPageMeta()
	{
		return $this->get('pageMeta');
	}
}
?>