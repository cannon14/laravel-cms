<?php
/**
 * 
 * ClickSuccess, L.P.
 * March 27, 2006
 * 
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 * 
 * @package CMS_View
 */ 
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_libs_SiteCompiler');
csCore_Import::importClass('CMS_libs_SiteToXML3');
csCore_Import::importClass('CMS_libs_SiteToXML2');
csCore_Import::importClass('CMS_libs_SiteToXML');
class CMS_view_exportXml extends CMS_pages_cmsRestrictedPage
{
	function process()
	{
		
		if($_REQUEST['export'] == 1){
			$id = $_REQUEST['site'];			
			$compiler = new CMS_libs_SiteCompiler($id);
            $compiledSite =& $compiler->getCompiledSite();
			
			$this->exportSiteFullStructure($compiledSite);
			$this->exportSite($compiledSite);
		}
		$this->getSites();
		$this->addContent('exportXml');
	}
	
	function getRequiredPermissions()
    {
    	return array('CMS_xmlExports');	
    } 
	
	function getSites()
	{
		
		$sites = CMS_libs_Sites::getAllSites();
		$this->assignValue('sites', $sites);
	}
	
	function getSite($id)
	{
		$site = CMS_libs_Sites::getSite($id);
		return $site;
	}
	
	function exportSite(&$compiledSite){
		$includeInactive = $_REQUEST['includeInactive'];
		
		$this->assignValue("tree", $compiledSite->displayStructure('XML'));
		
		//$writer = new CMS_libs_SiteToXML($compiledSite);
		$writer = new CMS_libs_SiteToXML2($compiledSite);
		$writer->build($includeInactive);
		CMS_libs_History::write($this->auth->username, "Exported XML " . $id);
		
	}
	
	function exportSiteFullStructure(&$compiledSite){
        $this->assignValue("tree", $compiledSite->displayStructure('XML'));
        
        $writer = new CMS_libs_SiteToXML3($compiledSite);
        $writer->build();
        CMS_libs_History::write($this->auth->username, "Exported XML " . $id);
        
        $result = `sudo /rtControl/sync/xmlDataFeedSync`;
        print $result?
              _setSuccess("Successfully Exported Affiliate XML Documents"):
              _setMessage('No Affiliate XML Documents Exported', true);
	}
}
?>