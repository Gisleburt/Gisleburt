<?php

	namespace Gisleburt\Validator;

	use Gisleburt\LazyData\Exception;

	/**
	 * Tests if a value is a float
	 */
	class Regex extends Validator
	{

		protected $regex;

		const ERROR_INVALID = 'Doesn\'t appear to be correct';

		public function __construct(array $config = array()) {
			parent::__construct($config);
			if(!array_key_exists('pattern', $config))
				throw new Exception('Tried to created a Regex Validator without a pattern');
			$this->regex = $config['pattern'];
		}

		public function test($value) {
			$result = preg_match($this->regex,$value);
			if(!$result)
				$this->error = self::ERROR_INVALID;
			return $result;
		}

	}
