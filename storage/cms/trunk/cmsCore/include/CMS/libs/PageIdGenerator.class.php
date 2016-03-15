<?php

/**
 * Class to get page ids or generate them if necessary. Expects a 
 * database object to be passed in for interfacing with the database.
 * Since we don't have a standardized database interface, I'm building
 * it for whatever CMS uses. 
 *
 */

csCore_import::importClass('csCore_DB_db');

class CMS_libs_PageIdGenerator
{
    const PAGE_TYPE_ARTICLE            = 'ARTICLE';
    const PAGE_TYPE_INDIVIDUAL_OFFER   = 'INDIVIDUAL_OFFER';
    const PAGE_TYPE_OTHER              = 'OTHER';
    const PAGE_TYPE_PRODUCT_CATEGORY   = 'PRODUCT_CATEGORY';    
    
    public function getPageId( $pageReferenceId, $pageName, $pageUrl, $pageType = PageIdGenerator::PAGE_TYPE_OTHER, $order = 0, $originalPageId = null )
    {
	    $db = new csCore_DB_db();
        
        $getPageIdSQL = <<<SQL
            SELECT 
                page_id
            FROM 
                cccomus_page_reference
            WHERE
                page_reference_id = '$pageReferenceId'
SQL;

        $pageIdRs = $db->query($getPageIdSQL, __LINE__, __FILE__, DEBUG_MODE); // *sigh*        
        
        if ( !$pageIdRs->EOF ) // if we got a row, we have a valid page id...we just return it
        {
            return $pageIdRs->fields['page_id'];
        }
        
        // Hah! No page id, let's create one!
                
        // Validate that the page type is one of the acceptable ones right here
        
        $createPageIdSQL = <<<SQL
            INSERT INTO cccomus_pages
            (
                page_name,
                ordering,
                page_url,
                page_type
            )
            VALUES
            (
                '$pageName',
                $order,
                '$pageUrl',
                '$pageType'
            )
SQL;

        $db->query($createPageIdSQL, __LINE__, __FILE__, DEBUG_MODE); // srsly, we need a better database layer
        $pageId = $db->getLastInsertId();         
        
        $originalPageId = is_null( $originalPageId ) ? 'NULL' : $originalPageId;
        
        $createPageReferenceSQL = <<<SQL
            INSERT INTO cccomus_page_reference
            (
                page_reference_id,
                page_id_orig,
                page_id
            )
            VALUES
            (
                '$pageReferenceId',
                $originalPageId,
                $pageId
            )
SQL;

        $db->query($createPageReferenceSQL, __LINE__, __FILE__, DEBUG_MODE); // srsly, we need a better database layer
        
        return $pageId;
    }

}

?>