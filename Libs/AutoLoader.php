<?php

class AutoLoader {

	protected static $folders = array();

	/**
	* AutoLoader::addFolder('/path/to/my_classes/');
	* AutoLoader::addFolder(array('/path/to/my_classes/','/more_classes/over/here/'));
	* @param mixed $folder string, full path to a folder containing class files, or array of paths.
	*/
	public static function addFolder($folder) {
		if ( ! is_array($folder)) {
			$folder = array($folder);
		}
		self::$folders = array_merge(self::$folders, $folder);
	}

	public static function load($class_name) {
		foreach (self::$folders as $folder) {
			$file = $folder . DIRECTORY_SEPARATOR . $class_name . '.php';
			if (file_exists($file)) {
				require_once $file;
				return;
			}
		}
	}
	
	public static function customAutoloader($className) {
		self::addFolder(array(API_PATH  . 'Controllers',
					API_PATH . 'Models',
					API_PATH . 'Libs',
		));
		self::load($className);
	}

}
