<?php
/**
 * Description of Page
 *
 * @author jasonh
 */
class Cardmatch_Page {

    public function getCardOrdering($pageId){
        $sql = 'SELECT cardId, rank FROM cms_card_page_map WHERE cardpageId=%d ORDER BY rank';
        $sql = sprintf($sql, $pageId);

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__, true);

	    $order = array();
        while(!$rs->EOF){
            $order[$rs->fields['cardId']] = $rs->fields['rank'];
            $rs->MoveNext();
        }

        return $order;
    }

}
