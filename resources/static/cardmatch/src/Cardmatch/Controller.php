<?php
//unset( $_SESSION[ 'user' ] );

require_once(AFFILIATE_PATH . '/global.php');
require_once(CARDMATCH_PATH . '/src/Cardmatch/Client/CardQuery/CardQuery.class.php');

class Cardmatch_Controller {

    // action constants
    const ACTION_START = 'index';
    const ACTION_DISPLAY_FORM = 'show_form';
    const ACTION_PROCESS_FORM = 'process_form';
    const ACTION_CONFIRM_USER_INFO = 'confirm_user_info';
    const ACTION_EDIT_USER_INFO = 'edit_user_info';
    const ACTION_PROCESS_INQUIRY = 'process_inquiry';
    const ACTION_SHOW_RESULTS = 'show_results';
    const ACTION_SHOW_ERROR = 'show_error';
    const ACTION_SERVER_ERROR = 'server_error';
    const ACTION_CLEAR_RESULTS = 'clear_results';
    const ACTION_SHOW_TEST_FORM = 'show_test_form';
    const ACTION_RUN_TEST = 'run_tuna_test';

    // Process state
    const STATE_START = 0;
    const STATE_SUBMITTED_FORM = 1;
    const STATE_CONFIRMED_INFO = 2;
    const STATE_SUBMITTED_QUERY = 3;
    const STATE_HAS_RESULTS = 4;
    const STATE_ERROR = 5;

    const DEFAULT_CARD_CATEGORY = 1;
    const NUM_NON_MATCHED_CARDS = 3;

    protected $_state = 0;
    protected $_tpl;
    protected $_messages = array();
    protected $_errorMessages = array();
    protected $_user;
    protected $_results;
    protected $_channelHub;
    protected $_form;

    /**
     * @var Cardmatch_Log
     */
    protected $_logger;

    public function __construct($request) {

        $this->_userPersistence = new Cardmatch_UserPersistence($this->_getConfig()->cache->cookie);
        $this->_user = $this->_userPersistence->getCurrentUser();
        $this->_tpl = new Cardmatch_Template();
        $this->_logger = Cardmatch_Logger::getInstance();

        $this->_state = isset($_SESSION['if_user_state']) ? $_SESSION['if_user_state'] : self::STATE_START;

        $this->_channelHub = new Cardmatch_ChannelHub($this->_getConfig(), $this->_user, $this->_getVisitId());

        $this->_form = new Cardmatch_Form();
        $this->_request = $request;
    }

    public function run() {

        $action = $this->_getParam('action', 'default');

        switch ($action) {
            case self::ACTION_START:
                $this->showDefaultLandingPage();
                break;
            case self::ACTION_PROCESS_FORM: // action = submit -> process form
                $this->processForm();
                break;
            case self::ACTION_CONFIRM_USER_INFO: // action = confirm user info -> process confirmation -> send inquiry
                $this->confirmUserInfo();
                break;
            case self::ACTION_PROCESS_INQUIRY:
                $this->processInquiry();
                break;
            case self::ACTION_SHOW_ERROR:
                $this->displayError();
                break;
            case self::ACTION_SERVER_ERROR:
                $this->displayServerError();
                break;
            case self::ACTION_CLEAR_RESULTS:
                $this->clearResults();
                break;
            case self::ACTION_SHOW_RESULTS:
                $this->displayResults();
                break;

            case self::ACTION_EDIT_USER_INFO: // action = edit user info -> show form

            case self::ACTION_DISPLAY_FORM:
                $this->displayForm();
                break;

            default:
                if ($this->_channelHub->hasValidCache()) {
                    $this->displayResults();
                } else {
                    //$this->displayForm();
                    $this->showDefaultLandingPage();
                }
        }
    }

    protected function displayForm() {
        $this->_logger->logServer('Landed on main form');
        return $this->displayTemplate('user_info_form');
    }

    protected function showDefaultLandingPage() {
        return $this->displayTemplate('index');
    }


    protected function processForm() {

        $this->_channelHub->clearCache();

        $form = $this->_form;

        $form->populate($this->_getAllParams());

        if (!$form->isValid($this->_getAllParams())) {

            $messages = $form->getMessages();

            foreach ($messages as $field => $errors) {

                $label = $form->$field->getLabel();
                $message = $label . " " . array_pop($errors);
                $error = new Cardmatch_Error(0, 0, $message);

                $this->_tpl->setError($field, $error);
            }

            $this->_errorMessages[] = ERR_USER_INFO_FORM;
            $this->displayForm();

            return false;
        }

        $this->_logger->logServer('Processing user data');

        $ssn = $form->getValue('ssn');

        // Pad to 9 digits with zeroes
        $format = '%09d';
        $ssn = sprintf($format, $ssn);

        $this->_user->setFirstName($form->getValue('firstName'));
        $this->_user->setMiddleInitial($form->getValue('middleInitial'));
        $this->_user->setLastName($form->getValue('lastName'));
        $this->_user->setStreetAddress($form->getValue('streetAddress'));
        $this->_user->setCity($form->getValue('city'));
        $this->_user->setState($form->getValue('state'));
        $this->_user->setZipCode($form->getValue('zipCode'));
        $this->_user->setSSN($ssn);

        $this->_userPersistence->persist($this->_user);



        $this->setState(self::STATE_SUBMITTED_FORM);
        return $this->displayConfirmation();
    }

    protected function displayConfirmation() {

        $config = $this->_getConfig();
        $version = $config->disclosure->version;

        $disclosure = new Cardmatch_Disclosure();
        $disclosureText = $disclosure->getDisclosureText($version);

        $this->_tpl->assign('disclosureText', $disclosureText);

        return $this->displayTemplate('confirm_user_info');
    }

    protected function confirmUserInfo() {
        // make sure user has submitted the form and it's been validated
        if ($this->_state != self::STATE_SUBMITTED_FORM) {
            return $this->displayForm();
        }

        $this->setState(self::STATE_CONFIRMED_INFO);
        $this->displayLoading();

    }

    protected function _isValidCaptcha($userString) {
        //return true; // Debugging

        $captchaText = $_SESSION['CAPTCHAString'];
        $isValid = $userString == $captchaText;

        return $isValid;
    }


    /**
     * This function instantiates the channel hub which queries all the available channels
     * for pre-screened products. This is all done while the user is seeing the loading page.
     * When this function is done, it returns an ajax response with the result of the
     * inquiry, not the actual products. The products are saved in cache for later use.
     *
     */
    protected function processInquiry() {

        if ($this->_state != self::STATE_CONFIRMED_INFO) {
            $this->confirmUserInfo();
            $this->setState(self::STATE_ERROR);
            $response = array(
                "status" => "error",
                "action" => self::ACTION_CONFIRM_USER_INFO
            );
        } else {

            $this->_logger->logServer('Getting results from channels');

            $offers = $this->_channelHub->getOffers();

            $products = array();
            foreach ($offers as $offer) {
                $cardId = $offer->getCardId();
                $products[] = $cardId;
            }

            if ($this->_channelHub->hasErrors() && empty($products)) {
                $this->setState(self::STATE_ERROR);
                $errors = $this->_channelHub->getErrors();

                foreach ($errors as $error) {
                    $this->_logger->err($error->getMessage());
                }

                $this->_channelHub->clearCache();
                $response = array(
                    "status" => "error",
                    "action" => self::ACTION_SHOW_ERROR,
                    "products" => $products,
                );
            } else {

                $this->setState(self::STATE_HAS_RESULTS);

                /*
                 * After this step we don't need any user data other than the name
                 * and results, so we scrub all "sensitive" data
                 */
                $this->_userPersistence->clearUserData();

                /*
                 * Store the results for later
                 */
                $this->_channelHub->saveOffers($offers);

                $response = array(
                    "status" => "success",
                    "action" => self::ACTION_SHOW_RESULTS,
                    "products" => $products,
                );
            }
        }

        echo json_encode($response);
    }

    protected function displayResults() {

        $offers = $this->_channelHub->getOffers();

        if ($this->_channelHub->hasErrors()) {
            $this->setState(self::ACTION_SHOW_ERROR);
        }

        $ptvs = array();
        $cardIds = array();
        foreach ($offers as $offer) {
            $cardId = $offer->getCardId();
            $cardIds[] = $cardId;
            $ptvValues = $offer->getPtvValues();
            if (!empty($ptvValues) && is_array($ptvValues)) {
                $ptvs[$cardId] = $this->_ptvArrToString($ptvValues);
            }
        }


        if (count($cardIds) > 0) {

            $dao = new Cardmatch_CardDao();
            $cardCatId = $this->_getParam('category', Cardmatch_Card::CAT_EXCLUSIVE_OFFERS);

            switch ($cardCatId) {
                case Cardmatch_Card::CAT_ALL:
                    $cards = $dao->getCards($cardIds);
                    break;

                case Cardmatch_Card::CAT_PREPAID_DEBIT:
                    $cards = $dao->getAllCardsByCategory($cardCatId);
                    break;

                case Cardmatch_Card::CAT_SECURE:
                    $cards = $dao->getAllCardsByCategory($cardCatId, NULL, 5);
                    break;

                default:
                    // Get only the cards that match the category
                    $cardsExclusive = $dao->getCardsByCategory($cardIds, $cardCatId);
                    $cardCatIdAll = $this->_getParam('category', Cardmatch_Card::CAT_ALL);
                    $cardsAll = $dao->getCardsByCategory($cardIds, $cardCatIdAll);

                    if (count($cardsExclusive) == 0) {
                        $cardCatId = $this->_getParam('category', Cardmatch_Card::CAT_ALL);
                        $cards = $dao->getCards($cardIds);
                    } elseif (count($cardsAll) == 0) {
                        $cardCatId = $this->_getParam('category', Cardmatch_Card::CAT_EXCLUSIVE_OFFERS);
                        $cards = $dao->getCardsByCategory($cardIds, $cardCatId);
                    } else {
                        $cardCatId = $this->_getParam('category', Cardmatch_Card::CAT_PREPAID_DEBIT);
                        $cards = $dao->getCardsByCategory($cardIds, $cardCatId);
                    }
                    break;
            }

            $resultCount = $dao->getResultCategoryCount($cardIds);

            $cards = $this->_orderResults($cards);
            $this->_tpl->assign('cards', $cards);
            $this->_tpl->assign('ptvs', $ptvs);
            $this->_tpl->assign('resultCount', $resultCount);
            $this->_tpl->assign('totalMatches', count($cardIds));

            $template = 'user_results';

            // always show link back to form
            $this->_tpl->assign('previousResults', true);

            $this->_tpl->assign('currentCatId', $cardCatId);

            $this->_tpl->assign('amexCatId', Cardmatch_Card::CAT_AMEX);
            $this->_tpl->assign('boaCatId', Cardmatch_Card::CAT_BOA);
            $this->_tpl->assign('barclayCatId', Cardmatch_Card::CAT_BARCLAYCARD);
            $this->_tpl->assign('caponeCatId', Cardmatch_Card::CAT_CAPITALONE);
            $this->_tpl->assign('chaseCatId', Cardmatch_Card::CAT_CHASE);
            $this->_tpl->assign('firstPremierCatId', Cardmatch_Card::CAT_FIRST_PREMIER);
            $this->_tpl->assign('simmonsBankCatId', Cardmatch_Card::CAT_SIMMONS_BANK);

            $this->_tpl->assign('categoryLabel', $this->_getCardCategoryLabel($cardCatId));

            $this->_tpl->assign('specialOffersCatId', Cardmatch_Card::CAT_SPECIAL_OFFERS);
            $this->_tpl->assign('balanceTransferCatId', Cardmatch_Card::CAT_BALANCE_TRANSFER);
            $this->_tpl->assign('businessCatId', Cardmatch_Card::CAT_BUSINESS);
            $this->_tpl->assign('cashBackCatId', Cardmatch_Card::CAT_CASH_BACK);
            $this->_tpl->assign('instantApprovalCatId', Cardmatch_Card::CAT_INSTANT_APPROVAL);
            $this->_tpl->assign('lowInterestCatId', Cardmatch_Card::CAT_LOW_INTEREST);
            $this->_tpl->assign('prepaidDebitCatId', Cardmatch_Card::CAT_PREPAID_DEBIT);
            $this->_tpl->assign('rewardsCatId', Cardmatch_Card::CAT_REWARDS);
            $this->_tpl->assign('studentCatId', Cardmatch_Card::CAT_STUDENT);
            $this->_tpl->assign('airlineCatId', Cardmatch_Card::CAT_AIRLINE);
            $this->_tpl->assign('zeroAprCatId', Cardmatch_Card::CAT_ZERO_APR);
            $this->_tpl->assign('secureCatId', Cardmatch_Card::CAT_SECURE);
            $this->_tpl->assign('exclusiveOffersCatId', Cardmatch_Card::CAT_EXCLUSIVE_OFFERS);
            $this->_tpl->assign('allCatId', Cardmatch_Card::CAT_ALL);

            $this->displayTemplate($template);

        } else {
            $this->setState(self::STATE_START);
            $this->displayTemplate('user_no_results');
        }
    }

    protected function _ptvArrToString($ptvValues) {
        $ptvInput = array('ptv' => $ptvValues);
        $ptvUri = '&';
        $ptvUri .= http_build_query($ptvInput);
        return $ptvUri;
    }

    protected function displayTemplate($template) {

        $this->_tpl->assign('messages', $this->_messages);
        $this->_tpl->assign('errorMessages', $this->_errorMessages);

        $this->_tpl->assign('user', $this->_user);

        $this->_tpl->assign('processFormAction', self::ACTION_PROCESS_FORM);
        $this->_tpl->assign('confirmUserInfoAction', self::ACTION_CONFIRM_USER_INFO);
        $this->_tpl->assign('editUserInfoAction', self::ACTION_EDIT_USER_INFO);
        $this->_tpl->assign('showResultsAction', self::ACTION_SHOW_RESULTS);
        $this->_tpl->assign('showErrorAction', self::ACTION_SHOW_ERROR);

        return $this->_tpl->display($template);

    }


    protected function setState($state) {
        $this->_state = $state;
        $_SESSION['if_user_state'] = $state;
    }

    /**
     * @param array $results
     *
     * @return mixed
     */
    private function _orderResults($results) {
        //load ordering page
        $page = new Cardmatch_Page();
        $ordering = $page->getCardOrdering(CMS_ORDER_PAGE);
        $unranked = 0;
        $rtn = array();
        foreach($results as $card) {
            /**
             * if the card is ranked, then put it in it's place
             * if not, then put it at the bottom
             */
            if (!isset($ordering[$card->getId()])) {
                $rtn[999 + ($unranked++)] = $card;
            } else {
                $rtn[$ordering[$card->getId()]] = $card;
            }
        }

        ksort($rtn);
        return $rtn;
    }

    protected function _getCardCategoryLabel($catId) {
        switch ($catId) {
            case -1:
                return 'special offer';
                break;
            case Cardmatch_Card::CAT_BALANCE_TRANSFER:
                return 'balance transfer';
                break;
            case Cardmatch_Card::CAT_BUSINESS:
                return 'business';
                break;
            case Cardmatch_Card::CAT_CASH_BACK:
                return 'cash back';
                break;
            case Cardmatch_Card::CAT_INSTANT_APPROVAL:
                return 'instant approval';
                break;
            case Cardmatch_Card::CAT_LOW_INTEREST:
                return 'low interest';
                break;
            case Cardmatch_Card::CAT_PREPAID_DEBIT:
                return 'prepaid/debit';
                break;
            case Cardmatch_Card::CAT_REWARDS:
                return 'rewards';
                break;
            case Cardmatch_Card::CAT_STUDENT:
                return 'student';
                break;
            case Cardmatch_Card::CAT_AIRLINE:
                return 'travel & airline';
                break;
            case Cardmatch_Card::CAT_ALL:
                return 'all matches';
                break;
            case Cardmatch_Card::CAT_ZERO_APR:
                return '0% apr';
                break;
            case Cardmatch_Card::CAT_SECURE:
                return 'secure';
                break;
            case Cardmatch_Card::CAT_EXCLUSIVE_OFFERS:
                return 'special offers';
                break;
            case Cardmatch_Card::CAT_AMEX:
                return 'American Express';
                break;
            case Cardmatch_Card::CAT_BARCLAYCARD:
                return 'Barclaycard';
                break;
            case Cardmatch_Card::CAT_BOA:
                return 'Bank of America';
                break;
            case Cardmatch_Card::CAT_CAPITALONE:
                return 'Capital One';
                break;
            case Cardmatch_Card::CAT_CHASE:
                return 'Chase';
                break;
            case Cardmatch_Card::CAT_FIRST_PREMIER:
                return 'First PREMIER';
                break;
            case Cardmatch_Card::CAT_SIMMONS_BANK:
                return 'Simmons Bank';
                break;
            default:
                return 'special';
        }
    }


    protected function displayLoading() {
        $this->displayTemplate('loading');
    }

    protected function setResultCount($resultCount) {
        $_SESSION['resultCount'] = $resultCount;
    }

    protected function displayError() {

        $this->setState(self::STATE_START);
        return $this->displayTemplate('user_error');
    }

    protected function displayServerError() {

        $this->setState( self::STATE_START );
        return $this->displayTemplate( 'server_error' );
    }

    protected function clearResults() {
        $this->_userPersistence->removeFromPersistence();
        $this->_channelHub->clearCache();

        $this->_user = $this->_userPersistence->getCurrentUser();

        $this->displayForm();
    }


    protected function _getVisitId() {
        return isset($_SESSION['external_visit_id']) ? $_SESSION['external_visit_id'] : false;
    }

    protected function _getParam($key, $default = null) {
        if (!empty($this->_request[$key])) {
            $value = $this->_request[$key];
        } else {
            $value = $default;
        }

        return $value;
    }

    protected function _getAllParams() {
        return $this->_request;
    }

    protected function _getConfig() {
        $config = new Zend_Config_Ini(CARDMATCH_PATH . '/config/channels.ini', APPLICATION_ENV);

        return $config;
    }



}
