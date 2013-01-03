<?php

	namespace Gisleburt\Validator;

	/**
	 *
	 * @author Daniel Mason
	 */

	class Validator
	{

		const ERROR_REQUIRED = 'This is required';

		/**
		 * Why wasn't the tested value valid
		 * @var string
		 */
		protected $error;

		/**
		 * @var bool Is the value required
		 */
		protected $isRequired = false;

		/**
		 * A record of all errors since the validator was created
		 * @var array
		 */
		protected $record = array();

		/**
		 * Sub validators
		 * @var Validator[]
		 */
		public $validators;

		public function __construct(array $validators = array()) {
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

		/**
		 * Validate the given value
		 * @param $value
		 * @return mixed
		 */
		final public function validate($value) {

			$this->error = null;
			$valid = true;

			if($this->isRequired && !$value) {
				$this->error = self::ERROR_REQUIRED;
				$valid = false;
			}
			elseif(is_array($this->validators)) {
				foreach($this->validators as $validator) {
					$valid = $validator->test($value);
					if(!$valid) {
						$this->error = $validator->getError();
						break;
					}
				}
			}

			$this->record[] = $this->getError();
			return $valid;

		}

		/**
		 * Returns the last error (if any)
		 * @return string
		 */
		public function getError() {
			return $this->error;
		}

		/**
		 * Is the value required?
		 * @param bool $isRequired
		 */
		public function setRequired($isRequired = true) {
			$this->isRequired = $isRequired;
		}

		/**
		 * Checks to see if there were ever any errors
		 * @return bool
		 */
		public function hasRecordedError() {
			foreach($this->record as $record) {
				if($record)
					return true;
			}
			return false;
		}

	}
