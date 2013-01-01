<?php

	namespace Gisleburt\Validator;

	/**
	 *
	 * @author Daniel Mason
	 */

	class Validator
	{

		/**
		 * Why wasn't the tested value valid
		 * @var string
		 */
		protected $error;

		/**
		 * Sub validators
		 * @var Validator[]
		 */
		public $validators;

		public function __construct(array $validators) {
			foreach($validators as $validator)
				$this->addValidator($validator);
		}

		/**
		 * Add a validator to the end of the list
		 * @param Validator $validator
		 */
		public function addValidator(Validator $validator) {
			$this->validators[] = $validator;
		}

		/**
		 * Remove all validators and just use this one
		 * @param Validator $validator
		 */
		public function setValidator(Validator $validator) {
			$this->validators = array();
			$this->addValidator($validator);
		}

		public function validate($value) {
			foreach($this->validators as $validator) {
				$valid = $validator->validate($value);
				if(!$valid) {
					$this->error = $validator->getError();
					break;
				}
			}
			return $valid;
		}

		/**
		 * Returns the last error (if any)
		 * @return string
		 */
		public function getError() {
			return $this->error;
		}
	}
