<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests if a value is a float
	 */
	class Float extends Validator
	{

		const ERROR_NOT_FLOAT = 'Needs to be a number';

		public function test($value) {
			$result = $value == (float)$value;
			if(!$result)
				$this->error = self::ERROR_NOT_FLOAT;

			return $result;
		}

	}
