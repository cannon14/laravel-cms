<?php

/**
 *
 * ClickSuccess, L.P.
 * March 15, 2006
 *
 * Authors:
 * Viktor Zeman
 *
 * Initial Class Design.
 *
 *
 * Patrick J. Mizer
 * <patrick@clicksuccess.com>
 *
 * Added singleton instance support 4/10/2006.
 *
 */

define('BASEDIR', realpath(dirname(realpath(__FILE__)) . '/..'));
ini_set('include_path', BASEDIR . '/pear');

class csCore_import
{

	public static function instanciateObject($class)
	{

		if (!class_exists($class)) csCore_Import::importClass($class);
		if (func_num_args() > 1) {
			$arg_list = func_get_args();
			$str_arg_list = '$arg_list[1]';
			for ($i = 2; $i < count($arg_list); $i++) $str_arg_list .= ', $arg_list[' . $i . ']';
			eval("\$obj = new $class($str_arg_list);");

			return $obj;
		} else {
			if (class_exists($class)) {
				//echo $class;
				return new $class;
			}
		}
	}

	public static function instanciateSingleton($class)
	{
		$inst_name = "_SINGLETON_" . strtoupper($class);
		// added this session_id() check to avoid a warning.  - mz
		if (!session_id()) {
			session_start();
		}

		if (!isset($_SESSION[$inst_name])) {
			$_SESSION[$inst_name] = self::instanciateObject($class);
			//echo "creating object";
		}

		return $_SESSION[$inst_name];
	}

	public static function importClass($class_name)
	{
		if (class_exists($class_name)) {
			return true;
		}
		$fileName = csCore_import::existsClass($class_name);
		if (!$fileName) {
			foreach (debug_backtrace() as $stackElement) {
				_setMessage("At line " . $stackElement['line'] . " file " . $stackElement['file']);
			}

			_setMessage('Fatal Error: Class ' . $class_name . ' is missing', true);

			return false;
		}

		require_once($fileName);

		return true;
	}

	public static function importLang($fileName)
	{
		$fileName = strtolower($fileName);
		if (!$fileName) {
			foreach (debug_backtrace() as $stackElement) {
				_setMessage("At line " . $stackElement['line'] . " file " . $stackElement['file']);
			}

			_setMessage('Fatal Error: File ' . $fileName . ' is missing', true);

			return false;
		}

		require_once(LANG_PATH . $fileName);

		return true;
	}

	public static function existsClass($className)
	{
		$fileName = csCore_import::_getFileName($className);

		if (!is_file($fileName)) {
			$fileName = csCore_import::_getFileNameCaseInsensitive($className);
		}

		return $fileName;
	}

	private static function _getRelativeClassPath($className)
	{
		$classPath = explode('_', $className);

		return implode('/', $classPath);
	}

	private static function _getFileName($className)
	{
		return BASEDIR . '/' . csCore_import::_getRelativeClassPath($className) . '.class.php';
	}

	private static function _getFileNameCaseInsensitive($className)
	{
		$fileNames = glob(BASEDIR . '/' . sql_regcase(csCore_import::_getRelativeClassPath($className))
		. '.class.php');
		if (!$fileNames) {
			return false;
		}

		return $fileNames[0];
	}
}