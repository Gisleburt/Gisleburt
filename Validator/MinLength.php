<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests if a value is a float
	 */
	class MinLength extends Validator
	{

		protected $error = 'Too short';

		protected $minLength;

		public function __construct($minLength) {
			$this->minLength = $minLength;
			$this->error = "Too short, must be $minLength letters long";
		}

		public function test($value) {
			$result = strlen($value) >= $this->minLength
			if(!$result)
				$this->error = $this->error;

			return $result;
		}

	}
