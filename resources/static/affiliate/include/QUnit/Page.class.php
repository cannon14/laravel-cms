<?
class QUnit_Page
{
    
    //call all page initialisation procedures
    function init_page() {
        QUnit_Page::set_displayed_message_levels();
        QUnit_Page::session_start();
        QUnit_Page::put_headers();
        QUnit_Page::start_timer();
        QUnit_Page::init_adodb();
        QUnit_Page::init_root_path();
        QUnit_Page::main_includes();
    }

    //--------------------------------------------------------------------------

    function init_root_path() {
        if (!isset($GLOBALS['RootPath'])) {
            $GLOBALS['RootPath'] = BASEDIR;
        }
    }

    //--------------------------------------------------------------------------

    function main_includes() {
        QUnit_Global::includeClass('QUnit_Templates');
        QUnit_Global::includeClass('QCore_RecordSet');
        QUnit_Global::includeClass('QCore_Settings');
        QUnit_Global::includeClass('QCore_Sql_DBUnit');
        QUnit_Global::includeClass('QUnit_Help_Help');
        QUnit_Global::includeClass('QCore_History');
        QUnit_Global::includeClass('QUnit_Messager');
    }
    
    //--------------------------------------------------------------------------

    function init_adodb() {
        require_once(BASEDIR . '/adodb/adodb.inc.php');
        define('ADODB_DIR', BASEDIR . '/adodb/');
    }
    
    //--------------------------------------------------------------------------

    function start_timer() {
        // start time for computing of how long does it take to generate the page
        $GLOBALS['start_time'] = microtime();
    }
    
    //--------------------------------------------------------------------------

    function end_timer() {
        // start time for computing of how long does it take to generate the page
        $GLOBALS['end_time'] = microtime();
    }
    
    //--------------------------------------------------------------------------

    function getTimeGenerated() {
        $diff = microtime_diff($GLOBALS['start_time'], $GLOBALS['end_time']);
        return round($diff, 3);
    }
    
    //--------------------------------------------------------------------------

    function put_headers() {
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // expires in the past
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
        header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache"); 
    }

    //--------------------------------------------------------------------------

    function session_start() {
        if(!headers_sent())
          session_start();
    }
    
    //--------------------------------------------------------------------------

    function set_displayed_message_levels() {
        error_reporting(E_ALL ^ E_NOTICE);
    }
    
    //--------------------------------------------------------------------------

    function process_class($moduleName, $defaultModule = '') {

        if(!strlen($moduleName)) {
            // assign default module
            $moduleName = $defaultModule;
        }
        if($moduleName == 'notImplemented') {
            echo "<br><center>This function is not yet implemented</center>";
            $moduleName = "";
        }
        
        if($moduleName != '') {
            if(is_object($moduleObj = QUnit_Global::newObj($moduleName)))
            {
              return $moduleObj->process();
            } else {
                return false;
            }
        } else {
            echo 'No module selected.';
            return false;
        }

    }
}

?>
