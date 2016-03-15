<?php
/**
 * Publish History Class
 * 
 * @copyright 2009 CreditCards.com
 * @author Patrick "El Chapo" Mizer <patrick.mizer@creditcards.com>
 */

class CMS_libs_PublishHistory
{
	/**
	 * Site ID
	 * 
	 * @var int
	 */
	private $_siteId;
	
	/**
	 * User ID
	 * 
	 * @var int
	 */
	private $_userId;
	
	/**
	 * Publish ID
	 * @var int
	 */
	private $_publishId;
	
	/**
	 * Publish Note
	 * 
	 * @var String
	 */
	private $_note;
	
	/**
	 * Datebase singleton
	 * 
	 * @var ADOConnection
	 */
	private $_conn;

    /**
     * Failure flag
     * True = a failure has occurred before while publishing this site, and
     *  we tried to report it to the user.
     * False = No failure occurred to our knowledge.  If a failure occurs, try
     *  to report it to the user.
     */

    private $_failedBefore;

	/**
	 * Prepared Statement for 
	 * Publish State History
	 * 
	 * @var unknown_type
	 */
	private static $_publishStateStatement;

	/**
	 * Constructor
	 *
	 * @param int $SiteId
	 * @return CMS_libs_PublishHistory
	 */
	public function __construct($siteId, $userId, $note = null) {
		
		$this->_initConn();
		
		$this->_siteId  	 = $siteId;
		$this->_userId  	 = $userId;
		$this->_note 		 = $note;
		$this->_publishId 	 = $this->_createPublish();
        $this->_failedBefore = false;

	}
	
	/**
	 * Init DB connection
	 * 
	 * @return void
	 */
	private function _initConn() {
		/* DB Stuff -- 
		 * I'm using prepared statements and transactions, 
		 * so I need direct access 
		 */
		$this->_conn = NewADOConnection(DB_TYPE);
		$this->_conn->Connect(DB_HOST, DB_UN, DB_PW, DB_NAME);
		$this->_conn->SetFetchMode(ADODB_FETCH_ASSOC);	
		
		// $this->_conn->BeginTrans();		
	}
	
	
	/**
	 * Create publish entry in persistence
	 * 
	 * @return int publish ID
	 */
	private function _createPublish() {
		
		$sql = 'INSERT INTO build_history (site_id, build_time, user_id) VALUES (?, NOW(), ?)';
		$stmt = $this->_conn->Prepare($sql);
		$this->_conn->Execute($stmt, array($this->_siteId, $this->_userId));
		
		return $this->_conn->Insert_ID('publishes', 'publish_id');
		
	}
	
	/**
	 * Add publish state
	 * 
	 * @param $pageFid
	 * @param $pageFidPos
	 * @param $subPageId
	 * @param $subPagePos
	 * @param $pageNumber
	 * @param $cardId
	 * @return void
	 */
	public function addPublishState(
		$pageFid, $pageFidPos, $subPageId, 
		$subPagePos, $pageNumber, $cardId) {	
		
		$stmt = $this->_getPublishStateStatement();	
		
		$params = array(
			$this->_publishId,
			$pageFid,
			$subPageId,
			$cardId,
			$pageFidPos,
			$subPagePos,
			$pageNumber	
		);

        // We might choose to report failure to the error box in the future
        // We don't currently because there are persistent errors in the error
        // box that have never been cleaned up, and thus no one pays attention
        // to the poor error box anymore.

        $stmtExecuteResult = $this->_conn->Execute($stmt, $params);

		if ($stmtExecuteResult == false) {
            if ($this->_failedBefore == false) {

                echo "<h1 class=\"error\">ADD CARD RANK HISTORY FAILED!</h1>\n";
                echo "<p>First failed addition follows:</p>\n";
                echo "<ul>\n";
                echo "<li>PubId      : $this->_publishId </li>\n";
                echo "<li>FID        : $pageFid          </li>\n";
                echo "<li>Subpage    : $subPageId        </li>\n";
                echo "<li>Card       : $cardId           </li>\n";
                echo "<li>PagePos    : $pageFidPos       </li>\n";
                echo "<li>subPagePos : $subPagePos       </li>\n";
                echo "<li>PageNum    : $pageNumber       </li>\n";
                echo "</ul>\n";
                $this->_failedBefore = true;

            }
        }

        
	}

	/**
	 * Save publish state to persistence
	 * @return boolean
	 */
	public function save() {
		// $this->_conn->CommitTrans($ok);
		return $ok;
	} 
	
	/**
	 * Get publish state prepared statement
	 * 
	 * @return unknown_type
	 */
	private function _getPublishStateStatement() {
		if(!isset(self::$_publishStateStatement)) {
			$sql = 'INSERT INTO build_history_detail 
						(   build_history_id, 
						 	web_page_id, 
						 	sub_page_id, 
						 	card_id, 
						 	web_page_position, 
						 	sub_page_position,
						 	web_page_number
						 ) VALUES (?, ?, ?, ?, ?, ?, ?)';
			self::$_publishStateStatement = $this->_conn->Prepare($sql);
		}
		
		return self::$_publishStateStatement;
	}
}
?>