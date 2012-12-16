<?php

	namespace Gisleburt\Tools;

	class Autoloader {

		public static $incDirs;
		
		public static function psr0($classname) {
			
			$classname = ltrim($classname, '\\');
			$filename  = '';
			$namespace = '';
			if ($lastNsPos = strripos($classname, '\\')) {
				$namespace = substr($classname, 0, $lastNsPos);
				$classname = substr($classname, $lastNsPos + 1);
				$filename  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
			}
			$filename .= str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
			
			if(is_readable($filename)) {
				require $filename;
				return;
			}
			
			foreach(self::$incDirs as $dir) {
				$file = $dir.DIRECTORY_SEPARATOR.$filename;
				if(is_readable($file))
					require $file;
			}
		}
		
	}