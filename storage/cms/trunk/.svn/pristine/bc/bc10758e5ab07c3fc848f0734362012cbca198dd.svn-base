<?php

csCore_Import::importClass('CMS_libs_PartnerWebsites');
csCore_Import::importClass('CMS_libs_LinkTypes');
csCore_Import::importClass('CMS_libs_DeviceTypes');
csCore_Import::importClass('CMS_libs_ProductLinks');
csCore_Import::importClass('CMS_libs_PartnerAccountTypes');
csCore_Import::importClass('CMS_libs_DefaultNetworkKeys');

class ProductLinksController {

	/**
	 * Supplies list of partner websites for autocomplete input (card edit page product link modal)
	 *
	 * @param $term
	 *
	 * @return array    partner websites
	 */
	public function getWebsitesForAutocomplete($term) {

		$results = array();
		$emptySet = array('value' => -1, 'label' => 'No Website Found');

		if (is_numeric($term)) {
			$rs = CMS_libs_PartnerWebsites::getSite($term);
		} else {
			$rs = CMS_libs_PartnerWebsites::getSitesByName($term);
		}

		if (!$rs->EOF) {
			while (!$rs->EOF) {
				$label = $rs->fields['name'] . " (" . $rs->fields['website_id'] . ")";
				$results[] = array('value' => $rs->fields['website_id'], 'label' => $label);
				$rs->MoveNext();
			}
		} else {
			$results[] = $emptySet;
		}

		return json_encode($results);
	}

	/**
	 * Finds product link by linkId to populate card edit page product link modal for editing
	 *
	 * @param $productLinkId
	 *
	 * @return ProductLink
	 */
	public function getProductLink($productLinkId) {

		$rs = CMS_libs_ProductLinks::getProductLinkById($productLinkId);

		if (!$rs) {
			$result = array('msg' => 'Could not find product link.');
		} else {
			$result = array('msg' => 'success',
				'link_id' => $rs['link_id'],
				'product_id' => $rs['product_id'],
				'link_type_id' => $rs['link_type_id'],
				'link_type_name' => $rs['link_type_name'],
				'device_type_id' => $rs['device_type_id'],
				'website_id' => $rs['website_id'],
				'website_name' => $rs['website_name'],
				'account_type_id' => $rs['account_type_id'],
				'url' => $rs['url']);
		}

		return json_encode($result);
	}

	/**
	 * Saves new product link to database
	 *
	 * @param $request
	 *
	 * @return ProductLink
	 */
	public function addProductLink($request) {

		$productId = trim($request['pl_productId']);
		$linkTypeName = trim($request['pl_link_type']);
		$websiteId = trim($request['pl_websiteId']);
		$deviceTypeId = trim($request['pl_device_type']);
		$url = trim(strip_tags($request['pl_url']));
		$username = trim($request['pl_username']);

		// set up link type information
		$linkType = CMS_libs_LinkTypes::getLinkTypeByName($linkTypeName);
		$linkTypeId = $linkType->fields['link_type_id'];

		// get device type name for table
		$deviceType = CMS_libs_DeviceTypes::getDeviceTypeById($deviceTypeId);
		$deviceTypeName = $deviceType->fields['name'];

		// set up account type information
		if ($linkTypeName != 'account') {
			$accountTypeId = null;
			$accountTypeName = '';
		} else {
			$accountTypeId = trim($request['pl_account_type']);
			$accountType = CMS_libs_PartnerAccountTypes::getAccountTypeById($accountTypeId);
			$accountTypeName = $accountType->fields['account_type'];
		}

		// check that product link is unique for link/device type
		$plUnique = $this->linkAndDeviceTypeUnique($linkTypeName, $productId, $linkTypeId, $deviceTypeId,
														$accountTypeId, $websiteId);

		if ($plUnique) {
			if ($linkTypeName != 'website') {
				$websiteId = null;
			}

			// set up create product link params
			$params = array(
				'product_id' => $productId,
				'link_type_id' => $linkTypeId,
				'device_type_id' => $deviceTypeId,
				'website_id' => $websiteId,
				'account_type_id' => $accountTypeId,
				'url' => $url,
				'updated_by' => $username
			);

			$productLink = CMS_libs_ProductLinks::addProductLink($params);

			if ($productLink) {
				$result = array('msg' => 'success',
					'product_link_id' => $productLink,
					'link_type_name' => $linkTypeName,
					'device_type_name' => $deviceTypeName,
					'website_id' => $websiteId,
					'account_type_name' => $accountTypeName,
					'url' => $url);
			} else {
				$result = array('msg' => 'There was an error saving the product link.');
			}
		} else {
			$result = array('msg' => 'A product link with the specified link/device type configuration already exists.');
		}

		return json_encode($result);

	}

	/**
	 * Updates an existing product link
	 *
	 * @param $request
	 *
	 * @return ProductLink
	 */
	public function editProductLink($request) {

		$linkId = trim($request['product_link_id']);
		$productId = trim($request['pl_productId']);
		$linkTypeName = trim($request['pl_link_type']);
		$websiteId = trim($request['pl_websiteId']);
		$deviceTypeId = trim($request['pl_device_type']);
		$url = trim(strip_tags($request['pl_url']));
		$username = trim($request['pl_username']);

		// set up link type information
		$linkType = CMS_libs_LinkTypes::getLinkTypeByName($linkTypeName);
		$linkTypeId = $linkType->fields['link_type_id'];

		// get device type name for table
		$deviceType = CMS_libs_DeviceTypes::getDeviceTypeById($deviceTypeId);
		$deviceTypeName = $deviceType->fields['name'];

		// set up account type information
		if ($linkTypeName != 'account') {
			$accountTypeId = null;
			$accountTypeName = '';
		} else {
			$accountTypeId = trim($request['pl_account_type']);
			$accountType = CMS_libs_PartnerAccountTypes::getAccountTypeById($accountTypeId);
			$accountTypeName = $accountType->fields['account_type'];
		}

		$plUnique = $this->linkAndDeviceTypeUnique($linkTypeName, $productId, $linkTypeId, $deviceTypeId,
														$accountTypeId, $websiteId, $linkId);
		$defaultLinkChanged = $this->defaultLinkTypeChanged($linkTypeName, $deviceTypeName, $linkId);

		if (!$defaultLinkChanged) {
			if ($plUnique) {
				if ($linkTypeName != 'website') {
					$websiteId = null;
				}

				// set up edit product link params
				$params = array(
					'product_id' => $productId,
					'link_type_id' => $linkTypeId,
					'device_type_id' => $deviceTypeId,
					'website_id' => $websiteId,
					'account_type_id' => $accountTypeId,
					'url' => $url,
					'updated_by' => $username
				);

				$productLink = CMS_libs_ProductLinks::updateProductLink($linkId, $params);

				if ($productLink != -1) {
					$result = array('msg' => 'success',
						'product_link_id' => $linkId,
						'link_type_name' => $linkTypeName,
						'device_type_name' => $deviceTypeName,
						'website_id' => $websiteId,
						'account_type_name' => $accountTypeName,
						'url' => $url);
				} else {
					$result = array('msg' => 'There was an error updating the product link.');
				}
			} else {
				$result = array('msg' => 'A product link with the specified link/device type configuration already exists.');
			}
		} else {
			$result = array('msg' => 'Only the URL may be updated for the default link type.');
		}

		return json_encode($result);
	}

	/**
	 * Deletes a product link (unless it is the default).
	 *
	 * @param $productLinkId
	 *
	 * @return string
	 */
	public function deleteProductLink($productLinkId) {

		// check that product link is not default (card/desktop)
		$productLink = CMS_libs_ProductLinks::getProductLinkById($productLinkId);
		$linkType = strtolower($productLink['link_type_name']);
		$deviceType = strtolower($productLink['device_type_name']);

		if ($linkType == 'card' && $deviceType == 'desktop') {
			$result = array('msg' => 'The default product link cannot be deleted, only edited.');
		} else {
			$rs = CMS_libs_ProductLinks::deleteProductLink($productLinkId);

			if (!$rs) {
				$result = array('msg' => 'Failed to delete product link.');
			} else {
				$result = array('msg' => 'success');
			}
		}

		return json_encode($result);
	}

	public function getTestLink($linkId, $networkId) {

		$productLinks = new CMS_libs_ProductLinks();
		$url = $productLinks->getTestLink($linkId, $networkId);

		$response = array(
			'msg' => 'success',
			'url' => $url,
		);

		return json_encode($response);

	}


	private function linkAndDeviceTypeUnique($linkTypeName, $productId, $linkTypeId, $deviceTypeId, $accountTypeId,
											 $websiteId, $linkId = null) {

		if ($linkTypeName == 'card' || $linkTypeName == 'terms') {
			$productLinks = CMS_libs_ProductLinks::getProductLinksByLinkTypeIdAndDeviceTypeId($productId, $linkTypeId, $deviceTypeId);
			if (count($productLinks) != 0 && $productLinks[0]['link_id'] != $linkId) {
				return false;
			}
		}
		if ($linkTypeName == 'account') {
			$productLinks = CMS_libs_ProductLinks::getAccountProductLinks($productId, $linkTypeId, $deviceTypeId, $accountTypeId);
			if (count($productLinks) != 0 && $productLinks[0]['link_id'] != $linkId) {
				return false;
			}
		}
		if ($linkTypeName == 'website') {
			$productLinks = CMS_libs_ProductLinks::getWebsiteProductLinks($productId, $linkTypeId, $deviceTypeId, $websiteId);
			if (count($productLinks) != 0 && $productLinks[0]['link_id'] != $linkId) {
				return false;
			}
		}

		return true;
	}

	private function defaultLinkTypeChanged($newLinkTypeName, $newDeviceTypeName, $linkId) {

		$productLinks = CMS_libs_ProductLinks::getProductLinkById($linkId);
		$oldDeviceTypeName = strtolower($productLinks['device_type_name']);
		$oldLinkTypeName = strtolower($productLinks['link_type_name']);
		if ($oldLinkTypeName == 'card' && $oldDeviceTypeName == 'desktop') {
			if ($oldLinkTypeName != $newLinkTypeName || $oldDeviceTypeName != $newDeviceTypeName) {
				return true;
			}
		}

		return false;
	}
}
