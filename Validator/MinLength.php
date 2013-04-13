<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests if a value is a float
	 */
	class MinLength extends Validator
	{

		const ERROR_INVALID = 'Too short';

		protected $errorMessage = self::ERROR_INVALID;

		protected $minLength;

		public function __construct(array $config = array()) {

			if(!array_key_exists('minLength', $config))
				throw new Exception('Tried to created a MinLength Validator without a minLength');

			parent::__construct($config);

			$this->errorMessage = "Too short, must be $this->minLength letters long";
		}

		public function test($value) {
			if(!$valid = strlen($value) >= $this->minLength)
				$this->error = $this->errorMessage;
			return $valid;
		}

	}
