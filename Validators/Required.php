<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests if a value is a float
	 */
	class Required extends Validator
	{

		const ERROR_REQUIRED = 'Required';

		public function __construct() {}

		public function validate($value) {
			$result =  $value ? true : false;
			if(!$result)
				$this->error = self::ERROR_REQUIRED;
		}

	}
