<?php
/**
 * Chameleon class that sets and maintains the chameleon cookie 
 * 
 * @author Jason Huie <jasonh@creditcards.com>
 */
class Affiliate_Scripts_Bl_Chameleon
{
	/**
	 * Affiliate ID
	 */
	var $_affiliate;
	
	/**
	 * Banner ID
	 */
	var $_banner;
	
	/**
	 * Card ID
	 */
	var $_card;
	
	/**
	 * Landing Page ID
	 */
	var $_landingPage;
	
	/**
	 * Exit Page ID
	 */
	var $_exitPage;
	
	/**
	 * Time when cookie was set
	 */
	var $_date;
	
	/**
	 * Constructor
	 * @access public
	 */
	function Affiliate_Scripts_Bl_Chameleon($cString = array()){
		$kvArray = explode('|', $cString);
		foreach($kvArray as $kv){
			$keyValue = explode('_', $kv);
			switch($keyValue[0]){
				case 'affiliate':
					$this->_affiliate = $keyValue[1];
					break;
				case 'banner':
					$this->_banner = $keyValue[1];
					break;
				case 'landingPage':
					$this->_landingPage = $keyValue[1];
					break;
				case 'date':
					$this->_date = $keyValue[1];
					break;
				case 'card':
					$this->_card = $keyValue[1];
					break;
				case 'exitPage':
					$this->_exitPage = $keyValue[1];
					break;
			}
		}
	}
	
	/**
	 * Set the Affiliate ID
	 * @access public
	 */
	function setAffiliate($aid){
		$this->_affiliate = $aid;
	}
	
	/**
	 * Set the Banner ID
	 * @access public
	 */
	function setBanner($bid){
		$this->_banner = $bid;
	}
	
	/**
	 * Set the Card ID
	 * @access public
	 */
	function setCard($cardId){
		$this->_card = $cardId;
	}
	
	/**
	 * Set the Landing Page ID
	 * @access public
	 */
	function setLandingPage($page){
		$this->_landingPage = $page;
	}
	
	/**
	 * Set the Exit Page ID
	 * @access public
	 */
	function setExitPage($page){
		$this->_exitPage = $page;
	}
	
	/**
	 * Set the date
	 * @access public
	 */
	function setDate($date){
		$this->_date = $date;
	}
	
	/**
	 * Get the Affiliate ID
	 * @access public
	 * @return String
	 */
	function getAffiliate(){
		return $this->_affiliate;
	}
	
	/**
	 * Get the Banner ID
	 * @access public
	 * @return String
	 */
	function getBanner(){
		return $this->_banner;
	}
	
	/**
	 * Get the Card ID
	 * @access public
	 * @return String
	 */
	function getCard(){
		return $this->_card;
	}
	
	/**
	 * Get the Landing Page
	 * @access public
	 * @return String
	 */
	function getLandingPage(){
		return $this->_landingPage;
	}
	
	/**
	 * Get the Exit Page
	 * @access public
	 * @return String
	 */
	function getExitPage(){
		return $this->_exitPage;
	}
	
	/**
	 * Get the date
	 * @access public
	 * @return String
	 */
	function getDate(){
		return $this->_date;
	}
	
	/**
	 * Send the Chameleon Cookie
	 * @access public
	 */
	function sendCookie(){
		$chameleon[] = 'affiliate_'.$this->_affiliate;
		$chameleon[] = 'banner_'.$this->_banner;
		$chameleon[] = 'landingPage_'.$this->_landingPage;
		$chameleon[] = 'date_'.$this->_date;
		$chameleon[] = 'card_'.$this->_card;
		$chameleon[] = 'exitPage_'.$this->_exitPage;

		setCookie('chameleon', implode('|', $chameleon), (time()+60*60*24), '/');
	}
	
	/**
	 * Save the Chameleon Cookie to persistance
	 * @access public
	 */
	function saveCookie(){
		$sql = 'INSERT INTO alternately_tracked_clicks
				(card_id, exit_page_id, landing_page_id, banner_id, affiliate_id, click_datetime)
			   	VALUES
				('._q($this->_card).', '.
				_q($this->_exitPage).', '.
				_q($this->_landingPage).', '.
				_q($this->_banner).', '.
				_q($this->_affiliate).', '.
				_q($this->_date).')';
				
		//print'<pre>';print $sql;print'</pre>';
		$ret = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);   	   
	}
	
	/**
	 * Get the Chameleon Cookie Data as an array
	 * @access public
	 * @return Array
	 */
	function getData(){
		$kvArray = $_COOKIE['chameleon'];
		$kv = explode('|', $kvArray);
		foreach($kv as $data){
			$keyValue = explode('_', $data);
			$chameleon[$keyValue[0]] = $keyValue[1];
		}
		
		return $chameleon;
	}
	
	/**
	 * Print the Chameleon Cookie
	 * @access public
	 */
	function printCookie(){
		print'<pre>';
		print_r($this->getData());
		print'</pre><hr>';
	}
}