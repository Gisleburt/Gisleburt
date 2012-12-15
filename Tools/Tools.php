<?php

	namespace Gisleburt\Tools;

	/**
	 * A collection of useful functions accessed as statics
	 * @author Daniel Mason
	 */

	class Tools {
		
		/**
		 * Returns the _GET value for the given key or null if not found
		 * @param string $key
		 */
		public static function get($key = null) {
			if(isset($key))
				return isset($_GET[$key]) ? $_GET[$key] : null;
			return self::arrayToObject($_GET);
		}
		
		/**
		 * Returns the _POST value for the given key or null if not found
		 * @param string $key
		 */
		public static function post($key = null) {
			if(isset($key))
				return isset($_POST[$key]) ? $_POST[$key] : null;
			return self::arrayToObject($_POST);
		}
		
		/**
		 * Returns the _GET, _POST or _COOKIE value for the given key or null if not found
		 * @param string $key
		 */
		public static function request($key = null) {
			if(isset($key))
				return isset($_REQUEST[$key])? $_REQUEST[$key] : null;
			return self::arrayToObject($_REQUEST);
		}
		
		/**
		 * Turns an array into an object
		 * @param array $array The array to convert
		 * @param number $recursionLevel How many arrays deep to go
		 * @return \stdClass
		 */
		public static function arrayToObject(array $array, $recursionLevel = 0) {
			$object = new \stdClass();
			foreach($array as $key => $item) {
				if(is_array($item) && $recursionLevel > 0)
					$item = self::arrayToObject($item, --$recursionLevel);
				$object[$key] = $item;
			}
			return $object;
		}
		
	}