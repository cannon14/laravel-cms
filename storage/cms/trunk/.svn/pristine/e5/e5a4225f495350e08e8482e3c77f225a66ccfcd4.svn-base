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
csCore_Import::importClass('CMS_libs_Pages');
csCore_Import::importClass('CMS_libs_MerchantServices');
csCore_Import::importClass('CMS_libs_SiteCatalyst');
csCore_Import::importClass('CMS_libs_SiteCatalystMerchantService');
csCore_Import::importClass('CMS_libs_SiteCatalystIndividualCards');
csCore_Import::importClass('CMS_libs_SiteCatalystPages');

class CMS_view_sitecatalyst extends CMS_pages_cmsRestrictedPage
{
	var $messages;
	
	function process()
   {      
      $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';      
      
        if($action == 'saveData')
        {           
         $postData = isset($_POST) ? $_POST : array();
         $this->processUpdate($postData);
		}
      
      // get site specific data
		if(isset($_REQUEST['site']))
      {  
         $site = CMS_libs_Sites::getSite($_POST['site']);
         $type = isset($_POST['type']) ? $_POST['type'] : '';         
         $siteId = $site->fields['siteId'];
         $detailId = isset($_POST['detail_id']) ? $_POST['detail_id'] : '';         
         
         switch($type)
         {
            case 'issuerpages':              
               $this->assignValue('issuerpages', CMS_libs_Pages::getSiteCatalystIssuerPageAttributesBySite($siteId));
               $this->assignValue('pageVars', CMS_libs_SiteCatalystPages::getPageVarValues($detailId));
            break;
            case 'categorypages':               
               $this->assignValue('categorypages', CMS_libs_Pages::getSiteCatalystCategoryPageAttributesBySite($siteId));
               $this->assignValue('pageVars', CMS_libs_SiteCatalystPages::getPageVarValues($detailId));
            break;
            case 'creditcards':
               $this->assignValue('cards', CMS_libs_Cards::getCardsBySite($site->fields['siteId'], 'GROUP BY c.cardId ORDER BY cd.cardLink ASC'));
               $this->assignValue('pageVars', CMS_libs_SiteCatalystIndividualCards::getPageVarValues($detailId));
            break;
            case 'merchantservices':
               $this->assignValue('merchantservices', CMS_libs_MerchantServices::getIndividualMerchantServicesBySite($siteId));
               // get site catalyst page variables               
               $this->assignValue('pageVars', CMS_libs_SiteCatalystMerchantService::getPageVarValues($detailId));                                     
            break;            
            default:
               $this->assignValue('issuerpages', CMS_libs_Pages::getSiteCatalystIssuerPageAttributesBySite($siteId));
               $this->assignValue('pageVars', CMS_libs_SiteCatalystPages::getPageVarValues($detailId));
            break;
         }			
		}
      		
      
        $this->assignValue('siteCatalystVariables', $this->getSiteCatalystVariables());				
		$this->assignValue('sites', CMS_libs_Sites::getAllSites());
		$this->assignValue('messages', $this->messages);
		$this->addContent('hbx');
	}
	
	function getRequiredPermissions()
    {
    	return array('CMS_hbx');	
    }	
   
   /**
    * Returns all Site Catalyst variables for a given page id
    * @param int siteId
    * @author mz
    * @return result set of Site Catalyst variables
    **/
   function getSiteCatalystVariables()
   {
      $elements = CMS_libs_SiteCatalyst::getSiteCatalystVariables();
      return $elements;      
   }   
	
	function changeData($type)
   {
		if($type=='creditcards' || $type='')
      {
         $this->assignValue('cards', $data);
      }	
	}
	
   /**
    * Extracts the site catalyst page vars and values from the post array.
    * @author mz
    * @param $fid - only needed to pass to the saveData() method
    * @param $postData - a copy of the $_POST array
    **/
	function processUpdate($postData)
   {
      $detailId = $postData['detail_id'];
      $scPageVarData = array();
         
      foreach($postData as $key=>$val)
      {
         if(substr($key, 0, strlen(SITECATALYST_VAR_ID_PREFIX)) == SITECATALYST_VAR_ID_PREFIX)
         {                              
            $varName = end(explode('_', $key));
            $scPageVarData[$varName] = $val;
         }         
      }        
      
      switch($postData['type'])
      {
         case 'issuerpages':              
            CMS_libs_SiteCatalystPages::savePageVarData($detailId, $scPageVarData);
         break;
         case 'categorypages':               
            CMS_libs_SiteCatalystPages::savePageVarData($detailId, $scPageVarData);
         break;
         case 'creditcards':
            CMS_libs_SiteCatalystIndividualCards::savePageVarData($detailId, $scPageVarData);
         break;
         case 'merchantservices':         
            CMS_libs_SiteCatalystMerchantService::savePageVarData($detailId, $scPageVarData);
         break;            
         default:
            trigger_error('Invalid page type.',E_USER_ERROR);
         break;
      }		
      
		$this->messages[] = 'Site Catalyst data successfully updated.';
      
		return;
	}	
}
?>