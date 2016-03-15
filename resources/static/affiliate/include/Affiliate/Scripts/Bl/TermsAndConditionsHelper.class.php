<?php

//ALTERNATE LINK FOR TERMS AND CONDITIONS
// http://firstaid.in.creditcards.com/view.php?id=30093

QUnit_Global::includeClass('QCore_Settings');

define('ALTERNATE_LINK_TERMS_SENTINEL_AID_VALUE', '104000');
define('ALTERNATE_LINK_TERMS_SENTINEL_WEBSITEID_VALUE', 19152);

class Affiliate_Scripts_Bl_TermsAndConditionsHelper
{
    // getTermsAndConditionsLink :
    // returns STRING or FALSE
    // STRING = the Terms and Conditions Link for that clickable
    // FALSE = No Terms and Conditions Link found for that clickable

    function getSentinelAidValue() {
        return ALTERNATE_LINK_TERMS_SENTINEL_AID_VALUE;
    }

    function getSentinelWebsiteIdValue() {
        return ALTERNATE_LINK_TERMS_SENTINEL_WEBSITEID_VALUE;
    }

    function getTermsAndConditionsLink($targetClickableId, $targetAffiliateId = ALTERNATE_LINK_TERMS_SENTINEL_AID_VALUE, $targetWebsiteId = ALTERNATE_LINK_TERMS_SENTINEL_WEBSITEID_VALUE) {

        $sql = '
SELECT
    url, affiliate_id, website_id
FROM
    cms_alternate_links
WHERE
    affiliate_id = ' . _q($targetAffiliateId) . '
AND
    website_id = ' . $targetWebsiteId . '
AND
    clickable_id = ' . _q($targetClickableId) .'
LIMIT 1
';

        $rs = QCore_Sql_DBUnit::execute($sql, __FILE__, __LINE__);

        if (!$rs)
        {
            $errorMsg = "TermsAndConditionsHelper: DB error for params " .
            $targetClickableId .
            $targetAffiliateId .
            $targetWebsiteId;
            LogError($errorMsg, __FILE__, __LINE__);
            return false;
        }

        if (!$rs->EOF) {
            return $rs->fields['url'];
        } else {
            return false;
        }
    } // end function getTermsAndConditionsLink
	
} // end class getTermsAndConditionsLink
?>
