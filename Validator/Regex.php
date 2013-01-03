<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests if a value is a float
	 */
	class Regex extends Validator
	{

		protected $regex;

		const ERROR_INVALID = 'Doesn\'t appear to be correct';

		public function __construct(array $pattern) {
			$this->regex = $pattern;
		}

		public function test($value) {
			$result = preg_match($this->regex,$value);
			if(!$result)
				$this->error = self::ERROR_INVALID;
			return $result;
		}

	}
