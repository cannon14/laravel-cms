<?php
// Must clear cache with this setting when WSDL is updated
ini_set('soap.wsdl_cache_enabled', 0);

//define("FEEDS_WSDL_SERVER_ADDRESS", "http://feeds.creditcards.com:8535/cardquery/QueryService?wsdl");

//define("FEEDS_WSDL_SERVER_ADDRESS", "http://cc120.aus.creditcards.com:8535/cardquery/QueryService?wsdl");
//define("FEEDS_WSDL_SERVER_ADDRESS", "http://lindev02.inside.cs:8080/cardquery/QueryService?wsdl");
//define("FEEDS_WSDL_SERVER_ADDRESS", "http://lindev04.in.creditcards.com:8080/cardquery/QueryService?wsdl");

class CardQuery {

    public static function getCardById($cardId) {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }
        $cardObj = $client->getCardById( array('cardId'=>$cardId) )->return;

        if (empty($cardObj)) {
            //echo "Error: Card data not found: " . $cardId;
            return false;
        }
        return $cardObj;
    }

    public static function getCardsById($cardIds) {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $cardObj = $client->getCardsById( array('cardId'=>$cardIds) )->return;

        if (empty($cardObj)) {
            //echo "Error: Card data not found: " . $cardId;
            return false;
        }

        if (count($cardsObj) < 2) {
            $cardsObj = array( $cardsObj );
        }

        return $cardObj;
    }

    public static function getPageById($pageId) {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $pageObj = $client->getPageById( array('pageId'=>$pageId) )->return;

        if (empty($pageObj)) {
            //echo "Error: Card data not found: " . $cardId;
            return false;
        }

        return $pageObj;
    }

    public static function getPagesByCardId($cardId, $siteId = '35') {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $pagesObj = $client->getPagesByCardId( array('cardId'=>$cardId, 'siteId'=>$siteId) )->return;

        if (empty($pagesObj)) {
            //echo "Error: Card data not found: " . $cardId;
            return false;
        }

        if (count($pagesObj) < 2) {
            $pagesObj = array( $pagesObj );
        }

        return $pagesObj;
    }

    public static function getMerchantPageByCardId($cardId) {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $pageObj = $client->getMerchantPageByCardId( array('cardId'=>$cardId) )->return;

        if (empty($pageObj)) {
            //echo "Error: Card data not found: " . $cardId;
            return false;
        }

        return $pageObj;
    }

    public static function getCardCategories($contextId = '1') {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $cardsObj = $client->getCardCategories( array('contextId'=>$contextId) )->return;

        if (count($cardsObj) < 2) {
            $cardsObj = array( $cardsObj );
        }

        return $cardsObj;

    }

    public static function getCreditCardsByExpression($expression, $contextId = '1') {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $cardsObj = $client->getCreditCardsByExpression( array('cardCategoryExpression'=>$expression, 'contextId'=>$contextId) )->return;

        if (count($cardsObj) < 2) {
            $cardsObj = array( $cardsObj );
        }

        return $cardsObj;

    }

    public static function getCreditCardsByExpressionAndMaxApr($expression, $maxApr, $contextId = '1') {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $cardsObj = $client->getCreditCardsByExpressionAndMaxApr( array('cardCategoryExpression'=>$expression, 'contextId'=>$contextId, 'maxApr'=>$maxApr) )->return;

        if (count($cardsObj) < 2) {
            $cardsObj = array( $cardsObj );
        }

        return $cardsObj;

    }

    public static function getCategoriesByCardId($cardId, $groupId = 3) {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $contextId = '1';

        $categoriesObj = $client->getCategoriesByCardId( array('cardId'=>$cardId, 'contextId'=>$contextId, 'groupId'=>$groupId) )->return;

        if (count($categoriesObj) < 2) {
            $categoriesObj = array( $categoriesObj );
        }

        return $categoriesObj;

    }

    // DEPRECATED, use categories instead
    public static function getCardsByPageIds($pageIds, $siteId = '35') {

        try {
            $client = new SoapClient(FEEDS_WSDL_SERVER_ADDRESS);
        } catch (Exception $e) {
            return false;
        }

        $cardsObj = $client->getCardsByPageIds( array('pageIds'=>$pageIds, 'siteId'=>$siteId) )->return;

        if (empty($cardsObj)) {
            //echo "Error: Card data not found: " . $cardId;
            return false;
        }

        if (count($cardsObj) < 2) {
            $cardsObj = array( $cardsObj );
        }

        return $cardsObj;
    }
}
?>