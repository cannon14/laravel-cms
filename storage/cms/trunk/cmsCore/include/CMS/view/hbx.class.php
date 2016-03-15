<?php
/**
 * 
 * CreditCards.com
 * 01/04/08
 * 
 * Authors:
 * Jason Huie
 * <jasonh@clicksuccess.com>
 * 
 * @package CMS_View
 */
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_libs_Cards');
csCore_Import::importClass('CMS_libs_MerchantServices');
csCore_Import::importClass('CMS_libs_Articles');
csCore_Import::importClass('CMS_libs_Hbx');

class CMS_view_hbx extends CMS_pages_cmsRestrictedPage
{
	var $messages;
	
	function process(){
		switch($_REQUEST['action']){
			case 'changeData':
				$this->changeData($_REQUEST['type']);
			case 'submitHbxData':
				$this->processUpdate($_REQUEST['site'],
									$_REQUEST['fid'],
									$_REQUEST['group'],
									$_REQUEST['class'],
									$_REQUEST['category'],
									$_REQUEST['product']);
				break;
			case 'addElement':
				$this->processAddElement($_REQUEST['type'], $_REQUEST['element']);
				break;
			default:
				break;
		}

		if(isset($_REQUEST['site'])){
			$site = CMS_libs_Sites::getSite($_REQUEST['site']);
			if($_REQUEST['type'] == 'creditcards' || $_REQUEST['type']=='')
				$this->assignValue('cards', CMS_libs_Cards::getCardsBySite($site->fields['siteId'], 'GROUP BY c.cardId ORDER BY cardTitle ASC'));
			else if($_REQUEST['type']=='articles')
				$this->assignValue('articles', CMS_libs_Articles::getArticlesBySite(	$site->fields['siteId'],
																						$site->fields['articledbhost'], 
																						$site->fields['articledbun'],
																						$site->fields['articledbpw'],
																						$site->fields['articledb'],
																						$site->fields['articletableprefix']));
			else if($_REQUEST['type'] == 'merchantservices')
				$this->assignValue('merchantservices', CMS_libs_MerchantServices::getMerchantServicesBySite($site->fields['siteId']));
			
		}
		
		$this->assignValue('hbxData', $this->getHbxData($_REQUEST['site'], $_REQUEST['item']));
		$this->assignValue('hbxElements', $this->getHbxElements());
		$this->assignValue('sites', CMS_libs_Sites::getAllSites());
		$this->assignValue('messages', $this->messages);
		$this->addContent('hbx');
	}
	
	function getRequiredPermissions()
    {
    	return array('CMS_hbx');	
    }
	
	function getHbxData($site, $item){
		if(isset($site) && isset($item))
			return CMS_libs_Hbx::getHbxDataByFid($item);
	}
	
	function getHbxElements(){
		$elements = CMS_libs_Hbx::getHbxElements();
		while($elements && !$elements->EOF){
			$return[$elements->fields['type']][] = $elements->fields;
			$elements->MoveNext();
		}
		return $return;
	}
	
	function changeData($type){
		if($type=='creditcards' || $type='')
			$data = CMS_libs_Cards::getAllCards();
		else if($type=='articles')
			$data = CMS_libs_Articles::getArticleCategories('localhost', 'root', '', 'wordpress', 'wp_');
		$this->assignValue('cards', $data);
	}
	
	function processUpdate($site, $fid, $group, $class, $category, $product){
		$params = array('site_id'		=>	$site,
						'item_fid'		=>	$fid,
						'group_name'	=>	$group,
						'class_name'	=>	$class,
						'category_name'	=>	$category,
						'product_name'	=>	$product);
		CMS_libs_Hbx::setData($params);
		$this->messages[] = 'HBX data for '.$product.' successfully added.';
		return;
	}
	
	function processAddElement($type, $element){
		if($type != null && $element != null){
			CMS_libs_Hbx::addElement($type, $element);
			$this->messages[] = $type.' '.$element.' successfully added.';
		}
		return;
	}
}
?>