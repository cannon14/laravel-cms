<?php
define('BASEDIR', realpath(dirname(realpath(__FILE__)) . '/..'));
//ini_set('include_path', BASEDIR . '/pear');

/**
* include file in which exists the class
*
* @author 	Viktor Zeman
* @since 	Version 0.1a
* @return
*/

class QUnit_Global {
	
	/**
	* Return created object
	*
	* @author 	Viktor Zeman
	* @param	string Name of a class to create,
	* @param    next parameters are optionals and are sent as arguments to object constructor
	* @return	object Created object
	*/
	public static function newObj($class) {
		if (!class_exists($class)) QUnit_Global::includeClass($class);
		if (func_num_args() > 1) {
			$arg_list = func_get_args();
			$str_arg_list = '$arg_list[1]';
			for ($i = 2; $i < count($arg_list); $i++) $str_arg_list .= ', $arg_list[' . $i . ']';
			eval("\$obj = new $class($str_arg_list);");
			return $obj;
		} else {
			return new $class;
		}
	}

	public static function includeClass($class_name) {
		if (class_exists($class_name)) {
			return true;
		}
		$fileName = QUnit_Global::existsClass($class_name);
		if(!$fileName) {
			foreach (debug_backtrace() as $stackElement) {
				echo sprintf("At line %s, file %s\n", $stackElement['line'], $stackElement['file']);
			}

			die(sprintf('Fatal Error: Class %s is missing', $class_name));
		}

		include_once($fileName);
		return true;
	}

	public static function existsClass($className) {
		$fileName = QUnit_Global::_getFileName($className);
       
		if(!is_file($fileName)) {
			$fileName = QUnit_Global::_getFileNameCaseInsensitive($className);
		}
		return $fileName;
	}

	private static function _getRelativeClassPath($className) {
		$classPath = explode('_', $className);
		return implode('/', $classPath);
	}

	private static function _getFileName($className) {
		return BASEDIR . '/' . QUnit_Global::_getRelativeClassPath($className) . '.class.php';
	}

	function _getFileNameCaseInsensitive($className) {
		$fileNames = glob(BASEDIR . '/' . sql_regcase(QUnit_Global::_getRelativeClassPath($className)) 
		             . '.class.php');
		if(!$fileNames) {
            return false;
		}
        return $fileNames[0];
	}
}

function newobj_unserialized($className) {
	QUnit_Global::newObj($className);

}
