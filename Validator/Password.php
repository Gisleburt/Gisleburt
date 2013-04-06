<?php

	namespace Gisleburt\Validator;

	use Gisleburt\Form\Element;

	/**
	 * Tests against a set of given characters
	 */
	class Password extends Validator
	{

		const ERROR_INVALID = 'Passwords did not match';

		protected $testAgainst;

		public function __construct(Element $elementToTestAgainst) {

			$this->testAgainst = $elementToTestAgainst;

		}

		/**
		 * Tests that the given value matches the value in a given element
		 * @param mixed $value
		 * @return bool
		 */
		public function test($value) {
			return ($value == $this->testAgainst->getValue());
		}

	}
