<?php
ini_set("session.cookie_domain", ".creditcards.com");
if(session_id() =='') {
	session_start();
}

define('DART_CAMPAIGN_ID', 10020);

define('GLOBAL_TRACKING_CONSTANT', 36);
define('AFFILIATE_DIRECT_TYPE', 999);
define('AFFILIATE_ROOT', 1000);
defined('COOKIE_TTL') || define('COOKIE_TTL', (60*60*24*365*77.5));
define('NO_PAGE_DEFINED', -1);
define('EXTERNAL_VISITS_TABLE', 'external_visits_mig');
define('EXTERNAL_VISITS_DEBUG_TABLE', 'external_visits_debug');
define('PAGE_VIEWS_TABLE', 'page_views');
 
/**
 * Traffic source constants.
 */ 
 
define('TS_COOKIE_TTL', (60*60*24*365*77.5));
define('TS_NO_PRODUCT_ID', -1);
define('TS_INVALID_PRODUCT_ID', -1);
define('TS_INVALID_CAMPAIGN_CATEGORY', -1);
define('TS_REDIRECT_RELIEF', 'relief.php');
define('TS_INVALID_TRAFFIC_SOURCE', 1099);
define('TS_ROOT_TRAFFIC_SOURCE', 1000);
define('TS_DIRECT_TYPE_TRAFFIC_SOURCE', 999);
define('TS_INVALID_ADVERTISEMENT', -1);

define('TS_REDIRECT_RULE_SEND', 1);
define('TS_REDIRECT_RULE_NO_SEND', 2);
define('TS_REDIRECT_RULE_SEND_W_SLASHES', 3);
define('TS_REDIRECT_RULE_SEND_OFFER', 4);
define('TS_REDIRECT_RULE_NO_SEND_OFFER', 5);  

define('TRANSFER_PAGE_ID', 9999);

/**
 *  DRTV AID to banner image mapping for drtv homepage banners
 *  Array elements in order are: (banner image, impression pixel ID, offer click pixel ID)
 */
//'c0bdc5d9'=>array('cc21-banner.jpg'), '069356b7'=>'cc23-banner.jpg', '71f6fe29'=>'cc25-banner.jpg', '546aee7b'=>'cc26-banner.jpg', '547c3b12'=>'cc28-banner.jpg', '356c13af'=>'cc29-banner.jpg', '1d95712a'=>'cc31-banner.jpg', 'cf331ed4'=>'cc32-banner.jpg', 'c06415e0'=>'cc34-banner.jpg', '790ca7b0'=>'cc35-banner.jpg', '5a67846e'=>'cc36-banner.jpg', '6a5adc21'=>'cc37-banner.jpg', 'ce5e31bb'=>'cc38-banner.jpg', '86e4b1d3'=>'cc39-banner.jpg'
define('DRTV_AFFILIATES_BANNER_MAP', serialize(array('c0bdc5d9'=>array('cc21-banner.jpg','1172106','1182106'), '069356b7'=>array('cc23-banner.jpg','1172107','1182107'), '71f6fe29'=>array('cc25-banner.jpg','1172108','1182108'), '546aee7b'=>array('cc26-banner.jpg','1172109','1182109'), '547c3b12'=>array('cc28-banner.jpg','1172110','1182110'), '356c13af'=>array('cc29-banner.jpg','1172111','1182111'), '1d95712a'=>array('cc31-banner.jpg','1172112','1182112'), 'cf331ed4'=>array('cc32-banner.jpg','1172113','1182113'), 'c06415e0'=>array('cc34-banner.jpg','1172114','1182114'), '790ca7b0'=>array('cc35-banner.jpg','1172115','1182115'), '5a67846e'=>array('cc36-banner.jpg','1172021','1182021'), '6a5adc21'=>array('cc37-banner.jpg','1172116','1182116'), 'ce5e31bb'=>array('cc38-banner.jpg','1172117','1182117'), '86e4b1d3'=>array('cc39-banner.jpg','1172118','1182118'), 'd3067c61'=>array('cc40-banner.jpg','1172119','1182119'), 'd3067c61'=>array('cc40-banner.jpg','1172119','1182119'), '59703892'=>array('cc41-banner.jpg','1172120','1182120'), '8fe73627'=>array('cc42-banner.jpg','1172121','1182121'), '9c3607c0'=>array('cc43-banner.jpg','1172122','1182122'),'615416ee'=>array('cc45-banner.jpg','1172123','1182123'), '0d2f0b1f'=>array('cc46-banner.jpg','1172124','1182124'), '486dcec0'=>array('cc47-banner.jpg','1172125','1182125'), '309bb66b'=>array('cc48-banner.jpg','1172126','1182126'),'fb7beee9'=>array('cc49-banner.jpg','1172127','1182127'), '5afe512e'=>array('cc50-banner.jpg','1172128','1182128'), '3b0912bd'=>array('cc51-banner.jpg','1172129','1182129'), '3b3fa14f'=>array('cc52-banner.jpg','1172130','1182130'),'ef7a9a48'=>array('cc53-banner.jpg','1172131','1182131'), 'b15226e0'=>array('cc54-banner.jpg','1172132','1182132'), 'e41e3719'=>array('cc56-banner.jpg','1172133','1182133'), '92fe6a82'=>array('cc57-banner.jpg','1172134','1182134'),'1106c1a3'=>array('cc58-banner.jpg','1172135','1182135'), '00153241'=>array('cc59-banner.jpg','1172136','1182136'), 'fe140cca'=>array('cc60-banner.jpg','1172137','1182137'), '33c5c4c8'=>array('cc61-banner.jpg','1172138','1182138')))); 

/*
 * awaiting future implementation:
 * '45def2af'=>'', '6ded5ea2'=>'', '96c6799e'=>'', '4062fbb0'=>'', 'e430fa50'=>'', '11b103bd'=>'', '8b92c96e'=>'',
 */