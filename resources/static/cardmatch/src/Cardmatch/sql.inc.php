<?php
/**
 * Card SQL Queries
 *
 * @copyright 2008 CreditCards.com
 */

define('SQL_LOAD_CARDS_BY_IDS',
<<<SQL
SELECT 
	`cms_cards`.`cardId` ,
    `cms_cards`.`applyByPhoneNumber` ,
    `cms_cards`.`cardTitle` ,
    `cms_card_details`.`cardDetailText` ,
    `cms_cards`.`imagePath` ,
    `cms_cards`.`url` ,
    `cms_card_details`.`cardIntroDetail`,
    `cms_card_details`.`cardLink`,
	`cms_merchants`.`merchantname` as merchant,
    DATE(`cms_cards`.`dateCreated`) as dateCreated,   
    REPLACE(cms_cards.introApr, '@@introApr@@', cms_card_data.introApr) AS introApr,
    `cms_card_data`.`introApr` AS q_introApr,
    REPLACE(cms_cards.regularApr, '@@regularApr@@', cms_card_data.regularApr) AS regularApr,
    `cms_card_data`.regularApr AS q_regularApr ,
    REPLACE(cms_cards.introAprPeriod, '@@introAprPeriod@@', cms_card_data.introAprPeriod) AS introAprPeriod,
    `cms_card_data`.introAprPeriod AS q_introAprPeriod ,
    REPLACE(cms_cards.annualFee, '@@annualFee@@', cms_card_data.annualFee) AS annualFee,
    `cms_card_data`.annualFee AS q_annualFee ,
    REPLACE(cms_cards.monthlyFee, '@@monthlyFee@@', cms_card_data.monthlyFee) AS monthlyFee,
    `cms_card_data`.monthlyFee AS q_monthlyFee ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'N/A')) AS balanceTransfers,
    `cms_card_data`.balanceTransfers AS q_balanceTransfers ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransferFee,
    `cms_card_data`.balanceTransferFee AS q_balanceTransferFee ,
	
	REPLACE(cms_cards.balanceTransferIntroApr, '@@balanceTransferIntroApr@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroApr, 'N/A')) AS intro_balance_transfer_apr,
	REPLACE(cms_cards.balanceTransferIntroAprPeriod, '@@balanceTransferIntroAprPeriod@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroAprPeriod, 'N/A')) AS intro_balance_transfer_apr_period,

    REPLACE(cms_cards.creditNeeded, '@@creditNeeded@@', CASE cms_card_data.creditNeeded
                WHEN 0 THEN CONVERT("No Credit Check" USING latin1)
                WHEN 1 THEN CONVERT("Bad Credit" USING latin1)
                WHEN 2 THEN CONVERT("Fair Credit" USING latin1)
                WHEN 3 THEN CONVERT("Good Credit" USING latin1)
                WHEN 4 THEN CONVERT("Excellent Credit" USING latin1)
            END
    ) AS creditNeeded,
    `cms_card_data`.creditNeeded AS `q_creditNeeded`,
    `cms_product_links`.`url` AS `termsLink`
FROM 
    cms_cards
INNER JOIN 
    cms_card_details
ON 
    (cms_cards.cardId = cms_card_details.cardId)
INNER JOIN
	cms_merchants
ON
	(cms_cards.merchant = cms_merchants.merchantid)
INNER JOIN 
     cms_card_data
ON 
    (cms_card_details.cardId = cms_card_data.cardId)
LEFT OUTER JOIN
	cms_product_links
ON
	(cms_card_details.cardId = cms_product_links.product_id AND cms_product_links.link_type_id = 4)
WHERE
    `cms_cards`.`cardId` IN (%s)
AND 
    cms_cards.deleted != 1
AND
    cms_cards.active = 1
AND 
    cms_card_details.cardDetailVersion = -1
SQL
);

define('SQL_LOAD_CARDS_BY_CAT_BY_IDS',
<<<SQL
SELECT DISTINCT
	`cms_cards`.`cardId` ,
    `cms_cards`.`applyByPhoneNumber` ,
    `cms_cards`.`cardTitle` ,
    `cms_card_details`.`cardDetailText` ,
    `cms_cards`.`imagePath` ,
    `cms_cards`.`url` ,
    `cms_card_details`.`cardIntroDetail`,
    `cms_card_details`.`cardLink`,
	`cms_merchants`.`merchantname` as merchant,
    DATE(`cms_cards`.`dateCreated`) as dateCreated,   
    REPLACE(cms_cards.introApr, '@@introApr@@', cms_card_data.introApr) AS introApr,
    `cms_card_data`.`introApr` AS q_introApr,
    REPLACE(cms_cards.regularApr, '@@regularApr@@', cms_card_data.regularApr) AS regularApr,
    `cms_card_data`.regularApr AS q_regularApr ,
    REPLACE(cms_cards.introAprPeriod, '@@introAprPeriod@@', cms_card_data.introAprPeriod) AS introAprPeriod,
    `cms_card_data`.introAprPeriod AS q_introAprPeriod ,
    REPLACE(cms_cards.annualFee, '@@annualFee@@', cms_card_data.annualFee) AS annualFee,
    `cms_card_data`.annualFee AS q_annualFee ,
    REPLACE(cms_cards.monthlyFee, '@@monthlyFee@@', cms_card_data.monthlyFee) AS monthlyFee,
    `cms_card_data`.monthlyFee AS q_monthlyFee ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'N/A')) AS balanceTransfers,
    `cms_card_data`.balanceTransfers AS q_balanceTransfers ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransferFee,
    `cms_card_data`.balanceTransferFee AS q_balanceTransferFee ,
    REPLACE(cms_cards.creditNeeded, '@@creditNeeded@@', CASE cms_card_data.creditNeeded
                WHEN 0 THEN CONVERT("No Credit Check" USING latin1)
                WHEN 1 THEN CONVERT("Bad Credit" USING latin1)
                WHEN 2 THEN CONVERT("Fair Credit" USING latin1)
                WHEN 3 THEN CONVERT("Good Credit" USING latin1)
                WHEN 4 THEN CONVERT("Excellent Credit" USING latin1)
            END
    ) AS creditNeeded,
	REPLACE(cms_cards.balanceTransferIntroApr, '@@balanceTransferIntroApr@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroApr, 'N/A')) AS intro_balance_transfer_apr,
	REPLACE(cms_cards.balanceTransferIntroAprPeriod, '@@balanceTransferIntroAprPeriod@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroAprPeriod, 'N/A')) AS intro_balance_transfer_apr_period,
    `cms_card_data`.creditNeeded AS `q_creditNeeded` ,
    `cms_product_links`.`url` AS `termsLink`
FROM
    cms_cards
INNER JOIN
    cms_card_details
ON
    (cms_cards.cardId = cms_card_details.cardId)
INNER JOIN
     cms_card_data
ON
    (cms_card_details.cardId = cms_card_data.cardId)
INNER JOIN
	cms_card_ranks
ON
	(cms_cards.cardId = cms_card_ranks.card_id)
INNER JOIN
	cms_merchants
ON
	(cms_cards.merchant = cms_merchants.merchantid)
INNER JOIN
	cms_card_category_ranks cccr
USING
	(card_category_id)
LEFT OUTER JOIN
	cms_product_links
ON
	(cms_card_details.cardId = cms_product_links.product_id AND cms_product_links.link_type_id = 4)
WHERE
	cccr.card_category_context_id = %d
AND
	cccr.card_category_id = %d
AND
    `cms_cards`.`cardId` IN (%s)
AND 
    cms_cards.deleted != 1
AND
    cms_cards.active = 1
AND 
    cms_card_details.cardDetailVersion = -1
ORDER BY cms_card_ranks.card_rank, cccr.card_category_rank
SQL
);

define('SQL_LOAD_CARDS_BY_CAT',
<<<SQL
SELECT DISTINCT
	`cms_cards`.`cardId` ,
    `cms_cards`.`applyByPhoneNumber` ,
    `cms_cards`.`cardTitle` ,
    `cms_card_details`.`cardDetailText` ,
    `cms_cards`.`imagePath` ,
    `cms_cards`.`url` ,
    `cms_card_details`.`cardIntroDetail`,
    `cms_card_details`.`cardLink`,
	`cms_merchants`.`merchantname` as merchant,
    DATE(`cms_cards`.`dateCreated`) as dateCreated,
    REPLACE(cms_cards.introApr, '@@introApr@@', cms_card_data.introApr) AS introApr,
    `cms_card_data`.`introApr` AS q_introApr,
    REPLACE(cms_cards.regularApr, '@@regularApr@@', cms_card_data.regularApr) AS regularApr,
    `cms_card_data`.regularApr AS q_regularApr ,
    REPLACE(cms_cards.introAprPeriod, '@@introAprPeriod@@', cms_card_data.introAprPeriod) AS introAprPeriod,
    `cms_card_data`.introAprPeriod AS q_introAprPeriod ,
    REPLACE(cms_cards.annualFee, '@@annualFee@@', cms_card_data.annualFee) AS annualFee,
    `cms_card_data`.annualFee AS q_annualFee ,
    REPLACE(cms_cards.monthlyFee, '@@monthlyFee@@', cms_card_data.monthlyFee) AS monthlyFee,
    `cms_card_data`.monthlyFee AS q_monthlyFee ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'N/A')) AS balanceTransfers,
    `cms_card_data`.balanceTransfers AS q_balanceTransfers ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransferFee,
    `cms_card_data`.balanceTransferFee AS q_balanceTransferFee ,
    REPLACE(cms_cards.creditNeeded, '@@creditNeeded@@', CASE cms_card_data.creditNeeded
                WHEN 0 THEN CONVERT("No Credit Check" USING latin1)
                WHEN 1 THEN CONVERT("Bad Credit" USING latin1)
                WHEN 2 THEN CONVERT("Fair Credit" USING latin1)
                WHEN 3 THEN CONVERT("Good Credit" USING latin1)
                WHEN 4 THEN CONVERT("Excellent Credit" USING latin1)
            END
    ) AS creditNeeded,
	REPLACE(cms_cards.balanceTransferIntroApr, '@@balanceTransferIntroApr@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroApr, 'N/A')) AS intro_balance_transfer_apr,
	REPLACE(cms_cards.balanceTransferIntroAprPeriod, '@@balanceTransferIntroAprPeriod@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroAprPeriod, 'N/A')) AS intro_balance_transfer_apr_period,
    `cms_card_data`.creditNeeded AS `q_creditNeeded`,
    `cms_product_links`.`url` AS `termsLink`
FROM
    cms_cards
INNER JOIN
    cms_card_details
ON
    (cms_cards.cardId = cms_card_details.cardId)
INNER JOIN
     cms_card_data
ON
    (cms_card_details.cardId = cms_card_data.cardId)
INNER JOIN
	cms_card_page_map
ON
	(cms_card_data.cardId = cms_card_page_map.cardId)
INNER JOIN
	cms_card_ranks
ON
	(cms_cards.cardId = cms_card_ranks.card_id)
INNER JOIN
	cms_merchants
ON
	(cms_cards.merchant = cms_merchants.merchantid)
INNER JOIN
	cms_card_category_ranks cccr
USING
	(card_category_id)
LEFT OUTER JOIN
	cms_product_links
ON
	(cms_card_details.cardId = cms_product_links.product_id AND cms_product_links.link_type_id = 4)
WHERE
	cccr.card_category_context_id = %d
AND
	cccr.card_category_id = %d
AND
    cms_cards.deleted != 1
AND
    cms_cards.active = 1
AND
    cms_card_details.cardDetailVersion = -1
ORDER BY cms_card_ranks.card_rank, cccr.card_category_rank
SQL
);


define('SQL_LOAD_CARDS_BY_CAT_NOT_IN_MATCHES',
<<<SQL
SELECT DISTINCT
	`cms_cards`.`cardId` ,
    `cms_cards`.`applyByPhoneNumber` ,
    `cms_cards`.`cardTitle` ,
    `cms_card_details`.`cardDetailText` ,
    `cms_cards`.`imagePath` ,
    `cms_cards`.`url` ,
    `cms_card_details`.`cardIntroDetail`,
    `cms_card_details`.`cardLink`,
	`cms_merchants`.`merchantname` as merchant,
    DATE(`cms_cards`.`dateCreated`) as dateCreated,   
    REPLACE(cms_cards.introApr, '@@introApr@@', cms_card_data.introApr) AS introApr,
    `cms_card_data`.`introApr` AS q_introApr,
    REPLACE(cms_cards.regularApr, '@@regularApr@@', cms_card_data.regularApr) AS regularApr,
    `cms_card_data`.regularApr AS q_regularApr ,
    REPLACE(cms_cards.introAprPeriod, '@@introAprPeriod@@', cms_card_data.introAprPeriod) AS introAprPeriod,
    `cms_card_data`.introAprPeriod AS q_introAprPeriod ,
    REPLACE(cms_cards.annualFee, '@@annualFee@@', cms_card_data.annualFee) AS annualFee,
    `cms_card_data`.annualFee AS q_annualFee ,
    REPLACE(cms_cards.monthlyFee, '@@monthlyFee@@', cms_card_data.monthlyFee) AS monthlyFee,
    `cms_card_data`.monthlyFee AS q_monthlyFee ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'N/A')) AS balanceTransfers,
    `cms_card_data`.balanceTransfers AS q_balanceTransfers ,
    REPLACE(cms_cards.balanceTransfers, '@@balanceTransfers@@', IF(cms_card_data.balanceTransfers = 1, 'Yes', 'No')) AS balanceTransferFee,
    `cms_card_data`.balanceTransferFee AS q_balanceTransferFee ,
    REPLACE(cms_cards.creditNeeded, '@@creditNeeded@@', CASE cms_card_data.creditNeeded
                WHEN 0 THEN CONVERT("No Credit Check" USING latin1)
                WHEN 1 THEN CONVERT("Bad Credit" USING latin1)
                WHEN 2 THEN CONVERT("Fair Credit" USING latin1)
                WHEN 3 THEN CONVERT("Good Credit" USING latin1)
                WHEN 4 THEN CONVERT("Excellent Credit" USING latin1)
            END
    ) AS creditNeeded,
	REPLACE(cms_cards.balanceTransferIntroApr, '@@balanceTransferIntroApr@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroApr, 'N/A')) AS intro_balance_transfer_apr,
	REPLACE(cms_cards.balanceTransferIntroAprPeriod, '@@balanceTransferIntroAprPeriod@@', IF(cms_card_data.balanceTransfers = 1 AND cms_card_data.balanceTransferIntroApr != '999.00', cms_card_data.balanceTransferIntroAprPeriod, 'N/A')) AS intro_balance_transfer_apr_period,
    `cms_card_data`.creditNeeded AS `q_creditNeeded` 
FROM 
    cms_cards
INNER JOIN 
    cms_card_details 
ON 
    (cms_cards.cardId = cms_card_details.cardId)
INNER JOIN 
     cms_card_data 
ON 
    (cms_card_details.cardId = cms_card_data.cardId)
INNER JOIN 
	cms_card_page_map
ON
	(cms_card_data.cardId = cms_card_page_map.cardId)
INNER JOIN 
	cms_card_ranks 
ON
	(cms_cards.cardId = cms_card_ranks.card_id)
INNER JOIN
	cms_merchants
ON
	(cms_cards.merchant = cms_merchants.merchantid)
INNER JOIN 
	cms_card_category_ranks cccr
USING 
	(card_category_id)
WHERE
	cccr.card_category_context_id = %d
AND
	cccr.card_category_id = %d
AND
    `cms_cards`.`cardId` NOT IN (%s)
AND 
    cms_cards.deleted != 1
AND
    cms_cards.active = 1
AND 
    cms_card_details.cardDetailVersion = -1
ORDER BY 
	cms_card_ranks.card_rank, cccr.card_category_rank
LIMIT %d
SQL
);
