<?php

/**
 * Cardmatch Autoloader
 * @author Kenneth Skertchly
 * @copyright 2013
 */ 
class Cardmatch_Autoloader {

	public static function load($class) {

		$class = str_replace("_","/", $class).'.php';

		$includePaths = explode(PATH_SEPARATOR, get_include_path());
		//print_r($includePaths); exit;
		$exists = false;
		foreach($includePaths as $path) {
			$classPath = $path . '/' . $class;
			//echo $classPath;
			if(file_exists($classPath)) $exists = true;
		}

		if(!$exists) {
			return false;
		}


		return require_once($class);
	}
}
