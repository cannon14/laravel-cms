<?php

require_once('global.php');
require_once('product_links/ProductLinksController.php');

$action = trim($_REQUEST['action']);
$productLinksController = new ProductLinksController();

if (!empty($action)) {

	switch ($action) {

		case 'websiteAutocomplete':
			$results = $productLinksController->getWebsitesForAutocomplete($_REQUEST['term']);
			echo($results);
			break;

		case 'getOne':
			$results = $productLinksController->getProductLink($_REQUEST['productLinkId']);
			echo($results);
			break;

		case 'add':
			$results = $productLinksController->addProductLink($_REQUEST);
			echo($results);
			break;

		case 'edit':
			$results = $productLinksController->editProductLink($_REQUEST);
			echo($results);
			break;

		case 'delete':
			$results = $productLinksController->deleteProductLink($_REQUEST['productLinkId']);
			echo($results);
			break;

		case "testLink":
			$results = $productLinksController->getTestLink($_REQUEST['linkId'], $_REQUEST['networkId']);
			echo ($results);
			break;
	}
}
