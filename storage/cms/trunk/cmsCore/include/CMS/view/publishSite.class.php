<?php
/**
 *
 * ClickSuccess, L.P.
 * March 30, 2006
 *
 * Authors:
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 *
 * @package CMS_View
 */
csCore_Import::importClass('CMS_libs_SiteCompiler');
csCore_Import::importClass('CMS_libs_SiteComponents');
csCore_Import::importClass('CMS_libs_SitePublisher');
csCore_Import::importClass('CMS_libs_Sites');
csCore_Import::importClass('CMS_pages_cmsRestrictedPage');

class CMS_view_publishSite extends CMS_pages_cmsRestrictedPage
{
	function process()
	{
		if(isset($_REQUEST['publish']) && $_REQUEST['publish'] == 1){
			$this->publishSite();
			return;
		}
		$this->getSites();
		$this->addContent('publish_site');
	}

	function getRequiredPermissions()
	{
		return array('CMS_ccbuildPublish');
	}

	function getSites()
	{
		$sites = CMS_libs_Sites::getCcbuildSites();
		$this->assignValue('sites', $sites);
	}

	function getSite($id)
	{
		$site = CMS_libs_Sites::getSite($id);
		return $site;
	}

		function _debugStamp($descriptor)
		{
		static $ts = null;

		/* set true to enable time stamp debugging */
		if (false) {
			if ($ts === null)
				$ts = time();
			echo sprintf('%s%3.0f</p>', $descriptor, (time() - $ts));
			$ts = time();
		}
		}

	function publishSite()
	{
			// FA 0026148 - Kvikkendierty style benchmarking
			$this->_debugStamp("[START] - publishSite() - ");

		foreach($_REQUEST['site'] as $id){
			$compiler = new CMS_libs_SiteCompiler($id);
			$compiler->displaySiteStructure();
			$compiledSite = $compiler->getCompiledSite();

			$this->assignValue("name", $compiledSite->get("siteName"));
			$this->assignValue("tree", $compiledSite->displayStructure('HTML'));

//			$articles = $compiledSite->displayUpdatedArticles($_REQUEST['fullPublish']);
//			$this->assignValue("articles", $articles);

			$publisher = new CMS_libs_SitePublisher($compiledSite);
			if($publisher->build())
				_setSuccess('Site Built');

			$this->bufferContent('show_published_sites');

			echo $this->getBufferedOutput();
			$this->outputBuffer = '';

		}

			// FA 0026148 - Kvikkendierty style benchmarking
			$this->_debugStamp("[_END_] - publishSite() - ");
	}
}
