<?php

	namespace Gisleburt\Validator;

	use Gisleburt\Form\Element;

	/**
	 * Tests against a set of given characters
	 */
	class MatchElement extends Validator
	{

		const ERROR_INVALID = 'Elements did not match';

		protected $errorMessage = self::ERROR_INVALID;

		protected $element;

		public function __construct(array $config = array()) {
			parent::__construct($config);

			if(!array_key_exists('element', $config))
				throw new Exception('Tried to created a MatchElement Validator without an element to match against');

			$this->element = $config['element'];

			if(array_key_exists('elementName', $config))
				$this->errorMessage = "{$config['elementName']} did not match";

		}

		/**
		 * Tests that the given value matches the value in a given element
		 * @param mixed $value
		 * @return bool
		 */
		public function test($value) {
			if(!($valid = $value == $this->element->getValue()))
				$this->error = $this->errorMessage;
			return $valid;
		}

	}
