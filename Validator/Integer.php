<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests that a given value is an integer
	 */
	class Integer extends Validator
	{

		const ERROR_NOT_INTEGER = 'Needs to be a whole number';
		const ERROR_TOO_LARGE = 'Needs to be smaller';

		public function test($value) {
			$result = $value == (int)$value;
			if(!$result) {
				$this->error = self::ERROR_NOT_INTEGER;
				if($value > (int)$value
						|| $value < (int)$value)
					$this->error = self::ERROR_TOO_LARGE;
			}
			return $result;
		}

	}
