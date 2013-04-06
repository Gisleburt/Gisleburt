<?php
/**
 * An Abstract class with useful features all other classes
 * can use.
 */

namespace Gisleburt\Tools;


abstract class AbstractClass {

	/**
	 * A list of properties that should not be overwritten by a config
	 * @var array
	 */
	protected $ignoreSettings = array('ignoreSettings');

	public function __construct(array $config) {
		$this->setConfig($config);
	}

	/**
	 * Set values in this object with a configuration array
	 * @param array $config
	 */
	public function setConfig(array $config) {
		foreach($config as $field => $value) {
			if(property_exists($this, $field) && !in_array($field , $this->ignoreSettings))
				$this->$field = $value;
		}
		return $this;
	}

	public static function construct(array $config) {
		$calledClass = get_called_class();
		return new $calledClass($config);
	}

}