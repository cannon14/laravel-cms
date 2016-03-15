<?PHP
// check php version, if not 4, bomb out immediately.
// PHP_VERSION in format X.X.X.
// - mz 11/2/07
$phpVersion = explode('.', PHP_VERSION);

//if($phpVersion[0] != 4)
//{
//   trigger_error('<br>CMS only works on PHP 4!.  You are running version '.PHP_VERSION.'!! ... YOU FAIL!!<br><br>', E_USER_ERROR);
//}

require_once('global.php');

csCore_Import::importClass("csCore_UI_uiEngine");
csCore_Import::importClass('csCore_Authentication_authentication');

$uiEngine = new csCore_UI_uiEngine();

$uiEngine->setDefaultModule("CMS_view_splash");

if(!isset($_REQUEST["mod"])) $_REQUEST["mod"] = '';

$embed = isset($_REQUEST['embed']) ? true : false;
$uiEngine->processModule($_REQUEST["mod"], $embed);

?>