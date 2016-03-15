<?php
/**
 * 
 * CreditCards.com
 * 3/15/2007
 * 
 * Authors:
 * Jason Huie
 * <jasonh@creditcards.com>
 * 
 * @package CMS_Lib
 */
csCore_Import::importClass('CMS_libs_SecondaryDBConnection');
csCore_Import::importClass('CMS_libs_siteComponents');

class CMS_libs_Affiliates {
   
    /**
     * Get all XML affiliates
     * @author Jason Huie
     * @version 1.0
     * @return Array categories
     * @static
     */
    function getXMLAffiliates($host, $un, $pw, $db)
    {
        $csdb = new CMS_libs_SecondaryDBConnection('mysql', $host, $un, $pw, $db);
        $sql = 
<<<SQL
SELECT * FROM wd_g_users
LEFT JOIN wd_pa_affiliatescampaigns ON (userid = affiliateid)
LEFT JOIN wd_pa_campaigns USING (campaignid)
WHERE product_ref = "xml_feed"
AND wd_pa_affiliatescampaigns.rstatus = 2
SQL;
        
        $rs = $csdb->query($sql, __LINE__, __FILE__, DEBUG_MODE);
        //echo $sql.'<hr>';
        
        //Destroy database connection
        $csdb->DB->Close();
        return $rs;
    }
    
    /**
     * Get all XML affiliates and their appropraited products
     * @author Jason Huie
     * @version 1.0
     * @return Array categories
     * @static
     */
    function getXMLAffiliatesWithProducts($host, $un, $pw, $db)
    {
        $csdb = new CMS_libs_SecondaryDBConnection('mysql', $host, $un, $pw, $db);
        $sql = 
<<<SQL
SELECT * FROM wd_pa_campaigns as c 
LEFT JOIN wd_pa_affiliatescampaigns as ac USING (campaignid)
LEFT JOIN wd_pa_banners as b USING (campaignid)
LEFT JOIN wd_g_users as u ON (affiliateid = userid)
WHERE userid IN (SELECT userid FROM wd_g_users
                LEFT JOIN wd_pa_affiliatescampaigns ON (userid = affiliateid)
                LEFT JOIN wd_pa_campaigns USING (campaignid)
                WHERE product_ref = "xml_feed"
                AND wd_pa_affiliatescampaigns.rstatus = 2)
AND product_ref IS NULL
AND ac.rstatus = 2
AND c.deleted != 1
ORDER BY userid
SQL;
        
        $rs = $csdb->query($sql, __LINE__, __FILE__, DEBUG_MODE);
        //echo $sql.'<hr>';
        //echo'<pre>';print_r($rs);echo'</pre>';
        
        //Destroy database connection
        $csdb->DB->Close();
        return $rs;
    }
    
    /**
     * Get pages associated with an affiliate
     * @author Jason Huie
     * @version 1.0
     * @return ResultSet
     * @static
     */
    function getAffiliatePages($host, $un, $pw, $db, $aid)
    {
        $csdb = new CMS_libs_SecondaryDBConnection('mysql', $host, $un, $pw, $db);
        $sql = 
<<<SQL
SELECT * FROM cs_affcamptypemap
WHERE affiliateid = '$aid'
AND rstatus = 2
SQL;
        
        $rs = $csdb->query($sql, __LINE__, __FILE__, DEBUG_MODE);
        //echo'<pre>';print_r($sql);echo'</pre>';
        
        //Destroy database connection
        $csdb->DB->Close();
        return $rs;
    }
     
    /**
     * Get affiliate trans URL
     * @author Jason Huie
     * @version 1.0
     * @return ResultSet
     * @static
     */
    function getAffTransURL($host, $un, $pw, $db){
    	$csdb = new CMS_libs_SecondaryDBConnection('mysql', $host, $un, $pw, $db);
    	$sql =
<<<SQL
SELECT value 
FROM wd_g_settings 
WHERE code = "Aff_tran_url"
SQL;
        $rs = $csdb->query($sql, __LINE__, __FILE__, DEBUG_MODE);
        
        $csdb->DB->Close();
        return $rs;
    }
}
?>