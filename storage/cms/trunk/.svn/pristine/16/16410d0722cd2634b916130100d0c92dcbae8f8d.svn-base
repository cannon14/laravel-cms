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
csCore_Import::importClass('CMS_libs_SiteToXML2');
csCore_Import::importClass('CMS_libs_SiteToXML');
class CMS_view_exportXmlOld extends CMS_pages_cmsRestrictedPage
{
	function process()
	{
		
		if($_REQUEST['export'] == 1){
			$this->exportSite();
		}
		$this->getSites();
		$this->addContent('exportXml');
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
	
	function exportSite(){
		$id = $_REQUEST['site'];
		
		$compiler = new CMS_libs_SiteCompiler($id);
		$compiledSite =& $compiler->getCompiledSite();
		
		$this->assignValue("tree", $compiledSite->displayStructure());
		
		$writer = new CMS_libs_SiteToXML($compiledSite);
		//$writer = new CMS_libs_SiteToXML2($compiledSite);
		$writer->build();
		
	}
}
?>