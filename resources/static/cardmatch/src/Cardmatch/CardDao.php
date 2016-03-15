<?php

/**
 * Card DAO
 * @author Kenneth Skertchly
 * @copyright 2013 CreditCards.com
 */
class Cardmatch_CardDao {

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    public function __construct(Zend_Db_Adapter_Abstract $adapter = null) {

        if(!$adapter) {
            $adapter = $this->_getDbAdapter();
        }

        $this->_db = $adapter;

    }


    /**
     * @param $cardId
     *
     * @return Cardmatch_Card
     */
    public function getCardById($cardId) {

        $select = $this->_getBaseQuery();
        $select->where('cms_cards.cardId = ?', $cardId);

        $row = $select->query()->fetch();

        $card = $this->buildFromRow($row);

        return $card;

    }

    public function getCardIdsBySkus($skus, $merchantId) {

        $select = $this->_db->select();

        $fields = array('card_sku' => 'ccx_cards.card_sku', 'card_id' => 'cms_cards.cardId');
        $select->from(array('ccx_cards' => 'vw_cms_ccx_cards'), $fields)
            ->join(array('map' => 'vw_ccx_cms_map'), 'ccx_cards.card_id = map.ccx_card_id', null)
            ->join('cms_cards', 'cms_cards.cardId = map.cms_card_id', null);


        $select->where('ccx_cards.card_sku IN(?)', $skus);
        $select->where('cms_cards.merchant = ?', $merchantId);

        $results = $select->query()->fetchAll();

        $productIds = array();
        foreach($results as $result) {
            $productIds[] = $result['card_id'];
        }

        return $productIds;

    }



    /**
     * Loads a set of cards based on an array of IDs passed in
     *
     * @param array $cardIds
     *
     * @return array
     */
    public function getCards(array $cardIds) {


        $select = $this->_getBaseQuery();
        $select->where('cms_cards.cardId IN (?)', $cardIds);
        $rows = $select->query()->fetchAll();
        $cards = $this->buildFromRows($rows);

        return $cards;

    }


    public function getResultCategoryCount($cardIds)
    {

        $select = $this->_db->select();

        $select->from(array("cc" => "cms_cards"), array("cnt" => "COUNT(1)"))
            ->join(array('ccr' => 'cms_card_ranks'), 'cc.cardId = ccr.card_id', array('card_category_id'))
            ->where('ccr.card_category_context_id = ?', Cardmatch_Card::CCCOM_CAT_CONTEXT)
            ->where('ccr.card_id IN(?)', $cardIds)
            ->where('cc.deleted != 1')
            ->where('cc.active = 1')
            ->group('ccr.card_category_id');


        $rows = $select->query()->fetchAll();

        $counts = array();
        foreach($rows as $row) {
            $counts[$row['card_category_id']] = $row['cnt'];
        }

        return $counts;
    }

    /**
     * Loads a set of cards based on a category id and an array of ids passed in
     *
     * @param array $cardIds ids of the cards to fetch from the DB
     * @param int $catId     id of the card category to get cards for
     *
     * @return array
     */
    public function getCardsByCategory($cardIds, $catId) {


        $select = $this->getCategorySelect(Cardmatch_Card::CCCOM_CAT_CONTEXT, $catId);

        $select->where('cms_cards.cardId IN (?)', $cardIds);

        $rows = $select->query()->fetchAll();
        $cards = $this->buildFromRows($rows);

        return $cards;
    }


    public function getAllCardsByCategory($catId, $contextId = null, $limit = null)	{

        if (empty($contextId)) $contextId = Cardmatch_Card::CCCOM_CAT_CONTEXT;

        $select = $this->getCategorySelect($contextId, $catId);
        $select->join('cms_card_page_map', 'cms_card_data.cardId = cms_card_page_map.cardId', []);

        if($limit) {
            $select->limit($limit);
        }

        $rows = $select->query()->fetchAll();
        $cards = $this->buildFromRows($rows);

        return $cards;

    }


    /**
     * @param $contextId
     * @param $catId
     * @return Zend_Db_Select
     */
    protected function getCategorySelect($contextId, $catId) {
        $select = $this->_getBaseQuery();
        $select->distinct();
        $select->join('cms_card_ranks', 'cms_cards.cardId = cms_card_ranks.card_id', [])
            ->join(['cccr' => 'cms_card_category_ranks'], 'cms_card_ranks.card_category_id = cccr.card_category_id', []);


        $select->where('cccr.card_category_context_id = ?', $contextId)
            ->where('cccr.card_category_id = ?', $catId);


        $select->order(['cms_card_ranks.card_rank', 'cccr.card_category_rank']);
        return $select;
    }


    /**
     * @param $row
     *
     * @return Cardmatch_Card
     */
    public function buildFromRow($row)
    {
        $map = $this->_getMap();
        $card = new Cardmatch_Card();
        foreach($map as $name=>$field) {
            $setter = 'set'.ucfirst($name);
            $value = isset($row[$field]) ? $row[$field] : '';
            $card->$setter($value);
        }

        return $card;
    }

    public function buildFromRows($rows) {

        $cards = [];
        foreach($rows as $row) {
            $card = $this->buildFromRow($row);
            $cards[] = $card;
        }

        return $cards;
    }


    protected function _getMap() {


        $map = [
            'id' =>'cardId',
            'defaultCommission' =>'default_commission',
            'commissionLabel' =>'commission_label',
            'status' =>'status',
            'name' =>'cardTitle',
            'internalName' =>'cardDescription',
            'bulletPoints' =>'cardDetailText',
            'imagePath' =>'imagePath',
            'url' =>'url',
            'cardLink' =>'cardLink',
            'introApr' =>'introApr',
            'qIntroApr' =>'q_introApr',
            'regularApr' =>'regularApr',
            'qRegularApr' =>'q_regularApr',
            'introAprPeriod' =>'introAprPeriod',
            'qIntroAprPeriod' =>'q_introAprPeriod',
            'annualFee' =>'annualFee',
            'qAnnualFee' =>'q_annualFee',
            'monthlyFee' =>'monthlyFee',
            'qMonthlyFee' =>'q_monthlyFee',
            'balanceTransfers' =>'balanceTransfers',
            'qBalanceTransfers' =>'q_balanceTransfers',
            'balanceTransferFee' =>'balanceTransferFee',
            'qBalanceTransferFee' =>'q_balanceTransferFee',
            'creditNeeded' =>'creditNeeded',
            'qCreditNeeded' =>'q_creditNeeded',
            'shortDescription' =>'cardIntroDetail',
            'merchant' =>'merchant',
            'dateCreated' =>'dateCreated',
            'applyByPhoneNumber' =>'applyByPhoneNumber',
            'balanceTransferIntroAprDisplay' =>'balanceTransferIntroAprDisplay',
            'balanceTransferIntroAprValue' =>'balanceTransferIntroAprValue',
            'balanceTransferIntroAprPeriodDisplay' =>'balanceTransferIntroAprPeriodDisplay',
            'balanceTransferIntroAprPeriodValue' =>'balanceTransferIntroAprPeriodValue',
            'termsLink' => 'termsLink',
            'linkTypeId' => 'linkTypeId'
        ];

        return $map;

    }

    /**
     * @return Zend_Db_Select
     */
    protected function _getBaseQuery()
    {
        $cardDetailsFields = array(
            'cardIntroDetail',
            'cardLink',
            'cardDetailText',
        );

        $merchantsFields = array(
            'merchant' => 'merchantname',
        );

        $cardDataFields = array(
            'q_creditNeeded'       => 'creditNeeded',
            'q_introApr'           => 'introApr',
            'q_regularApr'         => 'regularApr',
            'q_introAprPeriod'     => 'introAprPeriod',
            'q_annualFee'          => 'annualFee',
            'q_monthlyFee'         => 'monthlyFee',
            'q_balanceTransfers'   => 'balanceTransfers',
            'q_balanceTransferFee' => 'balanceTransferFee'
        );

        $creditNeeded = new Zend_Db_Expr("
		    REPLACE(cms_cards.creditNeeded, '@@creditNeeded@@', CASE cms_card_data.creditNeeded
		                WHEN 0 THEN CONVERT('No Credit Check' USING latin1)
		                WHEN 1 THEN CONVERT('Bad Credit' USING latin1)
		                WHEN 2 THEN CONVERT('Fair Credit' USING latin1)
		                WHEN 3 THEN CONVERT('Good Credit' USING latin1)
		                WHEN 4 THEN CONVERT('Excellent Credit' USING latin1)
		            END
		    )");

        $cardsFields = array(
            'cardId',
            'applyByPhoneNumber',
            'cardTitle',
            'imagePath',
            'url',
            'dateCreated'                       => new Zend_Db_Expr('DATE(cms_cards.dateCreated)'),
            'introApr'                          => 'cms_cards.introApr',
            'regularApr'                        => new Zend_Db_Expr("REPLACE(cms_cards.regularApr, '@@regularApr@@', cms_card_data.regularApr)"),
            'introAprPeriod'                    => new Zend_Db_Expr("REPLACE(cms_cards.introAprPeriod, '@@introAprPeriod@@', cms_card_data.introAprPeriod)"),
            'annualFee'                         => new Zend_Db_Expr("REPLACE(cms_cards.annualFee, '@@annualFee@@', cms_card_data.annualFee)"),
            'monthlyFee'                        => new Zend_Db_Expr("REPLACE(cms_cards.monthlyFee, '@@monthlyFee@@', cms_card_data.monthlyFee)"),
            'balanceTransfers'                  => new Zend_Db_Expr("REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'N/A'))"),
            'balanceTransferFee'                => new Zend_Db_Expr("REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'No'))"),
            'balanceTransferIntroAprDisplay'    => 'cms_cards.balanceTransferIntroApr',
            'balanceTransferIntroAprValue'      => 'cms_card_data.balanceTransferIntroApr',
            'balanceTransferIntroAprPeriodDisplay' => 'cms_cards.balanceTransferIntroAprPeriod',
            'balanceTransferIntroAprPeriodValue' => 'cms_card_data.balanceTransferIntroAprPeriod',
            'creditNeeded'                      => $creditNeeded,
            'termsLink'                         => 'cms_product_links.url',
            'linkTypeId'                        => 'cms_product_links.link_type_id'
        );


        $select = $this->_db->select();

        $select->from('cms_cards', $cardsFields)
            ->joinLeft('cms_product_links', 'cms_cards.cardId = cms_product_links.product_id AND cms_product_links.link_type_id = 4')
            ->join('cms_card_details', 'cms_cards.cardId = cms_card_details.cardId', $cardDetailsFields)
            ->join('cms_merchants', 'cms_cards.merchant = cms_merchants.merchantid', $merchantsFields)
            ->join('cms_card_data', '(cms_card_details.cardId = cms_card_data.cardId)', $cardDataFields);


        $select->where('cms_cards.deleted != 1')
            ->where('cms_cards.active = 1')
            ->where('cms_card_details.cardDetailVersion = -1');

        return $select;
    }

    /**
     * @return Zend_Db_Adapter_Abstract
     */
    protected function _getDbAdapter() {

        return Cardmatch_Database::getDbAdapter();
    }


}
