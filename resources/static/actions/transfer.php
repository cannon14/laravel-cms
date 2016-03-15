<?php
/**
 * This script 
 * 		1) Registers an external visit. 
 * 		2) Registers a transaction.
 * 		3) Redirects the user to the appropriate offer. 
 * 
 * @copyright 2007 CreditCards.com
 * @author Patrick J. Mizer <patrick@creditcards.com>
 */
 require_once('global.php');
 require('pageInit.php');
 
 /* Set product ID from query string. */
 $productId 	  = $_GET['pid']; 
 
 /* Set FID (page ID). */
 $_SESSION['fid'] = TRANSFER_PAGE_ID;
 
 /* Register external visit */
 require('inboundTrafficGateway.php');
 
 /* Register transaction and redirect to offer */
 header('Location: /oc.php?'.$productId.'-1');
?>