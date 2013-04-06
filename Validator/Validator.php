<?php

	namespace Gisleburt\Validator;

	/**
	 *
	 * @author Daniel Mason
	 */

	class Validator
	{

		const ERROR_REQUIRED = 'This information is required';

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
		 * What should the required message be
		 * @var string
		 */
		protected $requiredMessage = self::ERROR_REQUIRED;

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
		 * @return $this
		 */
		public function addValidator(Validator $validator) {
			$this->validators[] = $validator;
			return $this;
		}

		/**
		 * Remove all validators and just use this one
		 * @param Validator $validator
		 * @return $this
		 */
		public function setValidator(Validator $validator) {
			$this->validators = array();
			$this->addValidator($validator);
			return $this;
		}

		/**
		 * Tests the validity of a value
		 * Note: default validator always returns true
		 * @param $value mixed
		 * @return bool
		 */
		public function test($value) {
			return true;
		}

		/**
		 * Validate the given value
		 * @param $value
		 * @return mixed
		 */
		final public function validate($value) {

			$this->error = null;
			$valid = true;

			if($this->isRequired && !preg_replace('/\s/', '', $value)) {
				$this->error = self::ERROR_REQUIRED;
				$valid = false;
			}
			elseif(!$this->test($value)) {
				// Note: This only matters for extended validators
				$this->error = $this->requiredMessage;
				$valid = false;
			}
			elseif(is_array($this->validators)) {
				foreach($this->validators as $validator) {
					$valid = $validator->validate($value);
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
		 * @return $this
		 */
		public function setRequired($isRequired = true) {
			$this->isRequired = $isRequired;
			return $this;
		}

		/**
		 * Is this value required or will an empty value do?
		 * @return bool
		 */
		public function isRequired() {
			return $this->isRequired;
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

		/**
		 * Sets the error message for this element
		 * Note: Does not invalidate the element
		 * @param string $message
		 * @return $this
		 */
		public function setError($message) {
			$this->error = $message;
			return $this;
		}

	}
