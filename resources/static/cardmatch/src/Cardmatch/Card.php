<?php
/**
 * Card Entity/ORM/DAO all-in-one
 *
 * @copyright 2007 CreditCards.com
 * @author    Patrick J. Mizer <patrick.mizer@creditcards.com>
 * @package   partner.entity
 */


class Cardmatch_Card
{
    const CCCOM_CAT_CONTEXT = 1;
    const IF_CAT_CONTEXT = 2;

    const CAT_BALANCE_TRANSFER = 2;
    const CAT_BUSINESS = 12;
    const CAT_CASH_BACK = 10;
    const CAT_INSTANT_APPROVAL = 3;
    const CAT_LOW_INTEREST = 1;
    const CAT_PREPAID_DEBIT = 14;
    const CAT_REWARDS = 4;
    const CAT_STUDENT = 13;
    const CAT_SPECIAL_OFFERS = 19;
    const CAT_AIRLINE = 8;
    const CAT_ZERO_APR = 38;
    const CAT_SECURE = 68;
    const CAT_EXCLUSIVE_OFFERS = 72;

    const CAT_AMEX = 15;
    const CAT_BOA = 45;
    const CAT_BARCLAYCARD = 71;
    const CAT_CAPITALONE = 37;
    const CAT_CHASE = 36;
    const CAT_FIRST_PREMIER = 34;
    const CAT_SIMMONS_BANK = 84;

    const CAT_ALL = 420;

    /**
     * Card ID.
     *
     * @access private
     * @var int
     */
    private $_id;


    /**
     * Card name.
     *
     * @access private
     * @var String
     */
    private $_name;

    /**
     * Internal Name
     *
     * @access private
     * @var String
     */
    private $_internalName;

    /**
     * Card attribute bullet points.
     *
     * @access private
     * @var String
     */
    private $_bulletpoints;


    /**
     * Card's image path.
     *
     * @access private
     * @var String
     */
    private $_imagepath;


    /**
     * Card's destination url.
     *
     * @access private
     * @var String
     */
    private $_url;

    private $_cardLink;

    /**
     * Card's intro apr.
     *
     * @access  private
     * @private String
     */
    private $_introapr;


    /**
     * Card quantitative Intro Apr.
     *
     * @access private
     * @var double
     */
    private $_qintroapr;


    /**
     * Card regularApr.
     *
     * @access private
     * @var String
     */
    private $_regularapr;


    /**
     * Card quantitative Regular Apr.
     *
     * @access private
     * @var double
     */
    private $_qregularapr;


    /**
     * Card introAprPeriod.
     *
     * @access private
     * @var String
     */
    private $_introaprperiod;


    /**
     * Card quantitative Intro Apr Period.
     *
     * @access private
     * @var double
     */
    private $_qintroaprperiod;


    /**
     * Card annual fee.
     */
    private $_annualFee;


    /**
     * Card quantitative annual fee.
     *
     * @access private
     * @var double
     */
    private $_qannualfee;


    /**
     * Card monthly fee.
     *
     * @access private
     * @var String
     */
    private $_monthlyfee;


    /**
     * Card quantitative monthly.
     *
     * @access private
     * @var String
     */
    private $_qmonthlyfee;


    /**
     * Card balance transfers.
     *
     * @access private
     * @var String
     */
    private $_balancetransfers;


    private $_balanceTransferIntroAprDisplay;
    private $_balanceTransferIntroAprValue;
    private $_balanceTransferIntroAprPeriodValue;
    private $_balanceTransferIntroAprPeriodDisplay;



    /**
     * Card quantitative balance transfers.
     *
     * @access private
     * @var int
     */
    private $_qbalancetransfers;


    /**
     * Card balance transfer fee.
     *
     * @access private
     * @var String
     */
    private $_balancetransferfee;


    /**
     * Card quantitative balance transfer fee.
     *
     * @access private
     * @var double
     */
    private $_qbalancetransferfee;


    /**
     * Card credit needed.
     *
     * @access private
     * @var String
     */
    private $_creditneeded;


    /**
     * Card credit needed.
     *
     * @access private
     * @var int
     */
    private $_qcreditneeded;

    /**
     * Default commission
     *
     * @access private
     * @var double
     */
    private $_defaultCommission;

    /**
     * Commission Label
     *
     * @access private
     * @var string
     */
    private $_commissionLabel;

    /**
     * Card status
     *
     * @access private
     * @var String
     */
    private $_status;

    /**
     * Card short description
     *
     * @access private
     * @var String
     */
    private $_shortDescription;

    /**
     * Card merchant
     *
     * @access private
     * @var String
     */
    private $_merchant;

    /**
     * Card date created
     *
     * @access private
     * @var String
     */
    private $_dateCreated;

    /**
     * Apply-by-phone number
     *
     * @access private
     * @var String
     */
    private $_applyByPhoneNumber;

    /**
     * Rates & Fees (Terms) Link
     *
     * @access private
     * @var String
     */
    private $_termsLink;

    /**
     * @var int
     */
    private $_linkTypeId;
    /**
     * Set id
     *
     * @access public
     *
     * @param  int $id
     */
    function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Get id
     *
     * @access public
     * @return  int
     */
    function getId()
    {
        return $this->_id;
    }


    /**
     * Set name
     *
     * @access public
     *
     * @param  String $name
     */
    function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * Get name
     *
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set internal name
     *
     * @access public
     *
     * @param String $internalName
     */
    function setInternalName($internalName)
    {
        $this->_internalName = $internalName;
    }

    /**
     * Get internal name
     *
     * @access public
     * @return String
     */
    function getInternalName()
    {
        return $this->_internalName;
    }

    /**
     * Set bulletPoints
     *
     * @access public
     *
     * @param  String $bulletPoints
     */
    function setBulletPoints($bulletPoints)
    {
        $this->_bulletpoints = $bulletPoints;
    }

    /**
     * Get bulletPoints
     *
     * @return String
     */
    public function getBulletPoints()
    {
        return $this->_bulletpoints;
    }


    /**
     * Set imagePath
     *
     * @access public
     *
     * @param  String $imagePath
     */
    function setImagePath($imagePath)
    {
        $this->_imagepath = $imagePath;
    }

    /**
     * Get imagePath
     *
     * @return String
     */
    function getImagePath()
    {
        return $this->_imagepath;
    }


    /**
     * Set url
     *
     * @param  String $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    /**
     * Get url
     *
     * @return String
     */
    public function getUrl()
    {
        return $this->_url;
    }

    /**
     * Set card link
     *
     * @param $cardLink
     */
    public function setCardLink($cardLink)
    {
        $this->_cardLink = $cardLink;
    }

    /**
     * Get card link
     *
     * @override
     * @return
     */
    public function getCardLink()
    {
        return $this->_cardLink;
    }

    /**
     * Set introApr
     *
     * @param  String $introApr
     */
    public function setIntroApr($introApr)
    {
        $this->_introapr = $introApr;
    }

    /**
     * Get introApr
     *
     * @return
     */
    public function getIntroApr()
    {
        return $this->_introapr;
    }


    /**
     * Set qIntroApr
     *
     * @param  double $qIntroApr
     */
    public function setQIntroApr($qIntroApr)
    {
        $this->_qintroapr = $qIntroApr;
    }

    /**
     * Get qIntroApr
     *
     * @return float
     */
    public function getQIntroApr()
    {
        return $this->_qintroapr;
    }


    /**
     * Set regularApr
     *
     * @param  String $regularApr
     */
    public function setRegularApr($regularApr)
    {
        $this->_regularapr = $regularApr;
    }

    /**
     * Get regularApr
     *
     * @return String
     */
    public function getRegularApr()
    {
        return $this->_regularapr;
    }


    /**
     * Set qRegularApr
     *
     * @param  double $qRegularApr
     */
    public function setQRegularApr($qRegularApr)
    {
        $this->_qregularapr = $qRegularApr;
    }

    /**
     * Get qRegularApr
     *
     * @return float
     */
    public function getQRegularApr()
    {
        return $this->_qregularapr;
    }


    /**
     * Set introAprPeriod
     *
     * @param  String $introAprPeriod
     */
    public function setIntroAprPeriod($introAprPeriod)
    {
        $this->_introaprperiod = $introAprPeriod;
    }

    /**
     * Get introAprPeriod
     *
     * @return String
     */
    public function getIntroAprPeriod()
    {
        return $this->_introaprperiod;
    }


    /**
     * Set qIntroAprPeriod
     *
     * @param  double $qIntroAprPeriod
     */
    public function setQIntroAprPeriod($qIntroAprPeriod)
    {
        $this->_qintroaprperiod = $qIntroAprPeriod;
    }

    /**
     * Get qIntroAprPeriod
     *
     * @return float
     */
    public function getQIntroAprPeriod()
    {
        return $this->_qintroaprperiod;
    }

    /**
     * Set annual fee
     *
     * @param String $annualFee
     */
    public function setAnnualFee($annualFee)
    {
        $this->_annualFee = $annualFee;
    }

    /**
     * Get annual fee
     *
     * @return String
     *
     */
    public function getAnnualFee()
    {
        return $this->_annualFee;
    }

    /**
     * Set qAnnualFee
     *
     * @param  double $qAnnualFee
     */
    public function setQAnnualFee($qAnnualFee)
    {
        $this->_qannualfee = $qAnnualFee;
    }

    /**
     * Get qAnnualFee
     *
     * @return float
     */
    public function getQAnnualFee()
    {
        return $this->_qannualfee;
    }


    /**
     * Set monthlyFee
     *
     * @param  String $monthlyFee
     */
    public function setMonthlyFee($monthlyFee)
    {
        $this->_monthlyfee = $monthlyFee;
    }

    /**
     * Get monthlyFee
     *
     * @return String
     */
    public function getMonthlyFee()
    {
        return $this->_monthlyfee;
    }


    /**
     * Set qMonthlyFee
     *
     * @param String $qMonthlyFee
     */
    public function setQMonthlyFee($qMonthlyFee)
    {
        $this->_qmonthlyfee = $qMonthlyFee;
    }

    /**
     * Get qMonthlyFee
     *
     * @return String
     */
    public function getQMonthlyFee()
    {
        return $this->_qmonthlyfee;
    }


    /**
     * Set balanceTransfers
     *
     * @param  String $balanceTransfers
     */
    public function setBalanceTransfers($balanceTransfers)
    {
        $this->_balancetransfers = $balanceTransfers;
    }

    /**
     * Get balanceTransfers
     *
     * @return String
     */
    public function getBalanceTransfers()
    {
        return $this->_balancetransfers;
    }


    /**
     * Set qBalanceTransfers
     *
     * @param  int $qBalanceTransfers
     */
    public function setQBalanceTransfers($qBalanceTransfers)
    {
        $this->_qbalancetransfers = $qBalanceTransfers;
    }

    /**
     * Get qBalanceTransfers
     *
     * @return int
     */
    public function getQBalanceTransfers()
    {
        return $this->_qbalancetransfers;
    }


    /**
     * Set balanceTransferFee
     * @param  String $balanceTransferFee
     */
    public function setBalanceTransferFee($balanceTransferFee)
    {
        $this->_balancetransferfee = $balanceTransferFee;
    }

    /**
     * Get balanceTransferFee
     *
     * @return String
     */
    public function getBalanceTransferFee()
    {
        return $this->_balancetransferfee;
    }


    /**
     * Set qBalanceTransferFee
     *
     * @param  double $qBalanceTransferFee
     */
    public function setQBalanceTransferFee($qBalanceTransferFee)
    {
        $this->_qbalancetransferfee = $qBalanceTransferFee;
    }

    /**
     * Get qBalanceTransferFee
     *
     * @return float
     */
    public function getQBalanceTransferFee()
    {
        return $this->_qbalancetransferfee;
    }


    /**
     * Set creditNeeded
     *
     * @param  String $creditNeeded
     */
    public function setCreditNeeded($creditNeeded)
    {
        $this->_creditneeded = $creditNeeded;
    }

    /**
     * Get creditNeeded
     *
     * @return String
     */
    public function getCreditNeeded()
    {
        return $this->_creditneeded;
    }


    /**
     * Set qCreditNeeded
     *
     * @param  int $qCreditNeeded
     */
    public function setQCreditNeeded($qCreditNeeded)
    {
        $this->_qcreditneeded = $qCreditNeeded;
    }

    /**
     * Get qCreditNeeded
     *
     * @return int
     */
    public function getQCreditNeeded()
    {
        return $this->_qcreditneeded;
    }

    /**
     * Set default commission
     *
     * @param double $commission
     */
    public function setDefaultCommission($commission)
    {
        $this->_defaultCommission = $commission;
    }

    /**
     * Get default commission
     *
     * @return double
     */
    public function getDefaultCommission()
    {
        return $this->_defaultCommission;
    }

    /**
     * Set commission label
     *
     * @param double $commission
     */
    public function setCommissionLabel($commission)
    {
        $this->_commissionLabel = $commission;
    }

    /**
     * Get commission label
     *
     * @return double
     */
    public function getCommissionLabel()
    {
        return $this->_commissionLabel;
    }

    /**
     * Set status
     *
     * @param String $status
     */
    public function setStatus($status)
    {
        $this->_status = $status;
    }

    /**
     * Get status
     *
     * @return String
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Short decription
     *
     * @param String $short
     */
    public function setShortDescription($short)
    {
        $this->_shortDescription = $short;
    }

    /**
     * Get short descrpiton
     *
     * @return String
     */
    public function getShortDescription()
    {
        return $this->_shortDescription;
    }

    /**
     * Set merchant
     *
     * @param String $merchant
     */
    public function setMerchant($merchant)
    {
        $this->_merchant = $merchant;
    }

    /**
     * Get merchant
     *
     * @return String
     */
    public function getMerchant()
    {
        return $this->_merchant;
    }

    /**
     * Set date created
     *
     * @param String $date
     */
    public function setDateCreated($date)
    {
        $this->_dateCreated = $date;
    }

    /**
     * Get date created
     *
     * @return String
     */
    public function getDateCreated()
    {
        return $this->_dateCreated;
    }

    /**
     * Set apply-by-phone number
     *
     * @param String $applyByPhoneNumber
     */
    public function setApplyByPhoneNumber($applyByPhoneNumber)
    {
        $this->_applyByPhoneNumber = $applyByPhoneNumber;
    }

    /**
     * Get date created
     *
     * @return String
     */
    public function getApplyByPhoneNumber()
    {
        return $this->_applyByPhoneNumber;
    }


    /**
     *  Get the Value of balance transfer intro APR
     */
    public function getBalanceTransferIntroAprDisplay()
    {
        return $this->_balanceTransferIntroAprDisplay;
    }

    /**
     * Set the balance Transfer Intro APR
     *
     * @param $_balanceTransferIntroApr
     */
    public function setBalanceTransferIntroAprDisplay($_balanceTransferIntroApr)
    {
        $this->_balanceTransferIntroAprDisplay = $_balanceTransferIntroApr;
    }


    /**
     *  Get the Value of balance transfer intro APR
     */
    public function getBalanceTransferIntroAprValue()
    {
        return $this->_balanceTransferIntroAprValue;
    }

    /**
     * Set the balance Transfer Intro APR
     *
     * @param $_balanceTransferIntroApr
     */
    public function setBalanceTransferIntroAprValue($_balanceTransferIntroApr)
    {
        $this->_balanceTransferIntroAprValue = $_balanceTransferIntroApr;
    }

    /**
     * Get the value of terms link
     * @return String
     */
    public function getTermsLink() {
        return $this->_termsLink;
    }

    /**
     * Set the value of terms link
     * @param $termsLink
     */
    public function setTermsLink($termsLink) {
        $this->_termsLink = $termsLink;
    }

    /**
     *  Get the Value of balance transfer intro APR
     */
    public function getBalanceTransferIntroAprPeriodValue() {
        return $this->_balanceTransferIntroAprPeriodValue;
    }


    /**
     * Set the balance Transfer Intro APR
     *
     * @param $value
     */
    public function setBalanceTransferIntroAprPeriodValue($value) {
        $this->_balanceTransferIntroAprPeriodValue = $value;
    }

    public function getBalanceTransferIntroAprPeriodDisplay() {
        return $this->_balanceTransferIntroAprPeriodDisplay;
    }
    public function setBalanceTransferIntroAprPeriodDisplay($period) {
        $this->_balanceTransferIntroAprPeriodDisplay = $period;
    }

    /**
     * @return int
     */
    public function getLinkTypeId()
    {
        return $this->_linkTypeId;
    }

    /**
     * @param int $linkTypeId
     */
    public function setLinkTypeId($linkTypeId)
    {
        $this->_linkTypeId = $linkTypeId;
    }


}
