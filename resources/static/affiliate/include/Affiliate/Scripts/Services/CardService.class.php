<?php

/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
* Description of CardService
*
* @author mark.williams
*/
class CardService {
//put your code here

public function getTopCardsByPageId($pageId, $numOfCards = 1) {

$sql="      SELECT DISTINCT(cms_cards.cardId) AS card_id, 
            cms_cards.cardTitle AS card_name,
            cms_cards.imagePath AS image_path,
            merchant
            FROM cms_cards 
            INNER JOIN cms_card_data USING(cardId)
            INNER JOIN cms_card_page_map as card_page_map USING (cardId) 
            INNER JOIN cms_pages USING (cardpageId)
            LEFT OUTER JOIN cms_card_exclusion_map 
            ON (cms_pages.cardpageid = cms_card_exclusion_map.pageid 
            AND cms_card_data.cardId = cms_card_exclusion_map.cardId 
            AND cms_card_exclusion_map.siteid = '35' )
            WHERE cms_card_exclusion_map.mapid IS NULL 
            AND cms_cards.active = 1 
            AND cms_cards.deleted != 1
            AND cardpageId IN (".$pageId.")
            ORDER BY card_page_map.rank
            LIMIT ".$numOfCards;

        $result = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__); 

        return $result->fields;
    
    }
}

?>