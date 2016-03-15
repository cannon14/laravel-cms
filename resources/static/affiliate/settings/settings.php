<?php

// Database config
defined('DB_TYPE')     || define('DB_TYPE','mysql');
defined('DB_HOSTNAME') || define('DB_HOSTNAME','localhost');
defined('DB_DATABASE') || define('DB_DATABASE','cccomus');
defined('DB_USERNAME') || define('DB_USERNAME','cccomususer');
defined('DB_PASSWORD') || define('DB_PASSWORD','cccomususer');

// application license
define('APPLICATION_LICENSE','83b12a7854678f544dba173f5c34005c');
//----------------------------------------------------------------------------
// customer product ID
define('CUSTPRODUCT_ID','e48fe74704');
// distinct ID (company, machine, department, etc)
define('ENTITY_ID','999');
//dynamic page switches
define('ENABLE_SORTING',	1);
define('ENABLE_LOCATE',		1);
define('DYNAMIC_URL', 'http://cctools.inside.cs');

define('TRANSFER_URL', 'http://oc.dev.creditcards.com/t/');

define('IMPS_WIDGET_URL', 'http://imps.dev.creditcards.com/imps_widget_node.php');

define('CCCOM_DEFAULT_AID', '104000');
define('CCCOMUS_MAIN_SID', '5696');

/* This turns on and off the content replace code on the front page */
//define('CONTENT_REPLACE_ENABLE', true);

/*
 * Flag to enable AdZerk banners on cccomus
 * If AdZerk server goes down, set flag to '0' to disable them.
 */
define('ADZERK_ENABLED', 1);

/*
 * This flag is for the banners associated with the home page
 */
define('ADZERK_HOMEPAGE_ENABLED', 1);

/*
 * Flag to enable cardmatch banners and links on cccomus
 * If CardMatch goes down, set flag to '0' to disable them.
 */
define('CARDMATCH_ENABLED', 1);

/*
 * Flag to enable background ad image for editorial section
 */
define('BACKGROUND_AD_IMAGE_ENABLED', 0);

/*
 * reCAPTCHA keys
 */
define('RECAPTCHA_PUBLIC_KEY','6LdIY-MSAAAAAMmqTvajDR2huwPklyezn1WW7LDk');
define('RECAPTCHA_PRIVATE_KEY','6LdIY-MSAAAAANnA0J5lH2D1DCQV3Vu0O4cRxfmG');


define('BLACKLIST_OTHER_OFFERS_REDIRECT', 'http://imps.creditcards.com/other-offers.php');

/*
 * Path for Category Page's Editorial Content (built out from CardPress)
 */
define("CATEGORY_PAGE_STORY_PATH", "/usr/local/apache2/htdocs/us_production/credit-card-news/category_stories/");

define("CARD_IMAGE_ROOT","http://imgsynergy.com/191x120");

/*
 * Analytics Suite Flags
 */
define('DTM_ANALYTICS_ENABLED', false);
define('SITE_CATALYST_ENABLED', false);

/*
 * Elasticsearch Search Bar Visibility (Mag glass in top right-hand corner of header)
 */
define('SEARCH_ENABLED', true);
