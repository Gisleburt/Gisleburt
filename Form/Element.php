<?php


	namespace Gisleburt\Form;


	use Gisleburt\Tools\AbstractClass;
	use Gisleburt\Tools\Tools;
	use Gisleburt\Validator\Validator;

	/**
	 * Represents any input element
	 * @package Gisleburt\Form
	 */

	class Element extends  AbstractClass {

		/**
		 * The type of input element
		 * @var
		 */
		protected $type = 'text';

		/**
		 * @var String
		 */
		protected $name;

		/**
		 * @var mixed
		 */
		protected $value;

		/**
		 * @var \Gisleburt\Validator\Validator $validator
		 */
		protected $validator;

		/**
		 * @var \Gisleburt\Form\Message
		 */
		protected $message;

		/**
		 * Construct a form element. Form elements _must_ have a name
		 * @param array $config
		 * @throws Exception
		 */
		public function __construct(array $config = array()) {
			//$this->ignoreSettings[] = 'type';
			parent::__construct($config);

			$this->validator = new Validator();

			if(array_key_exists('required', $config))
				$this->setRequired($config['required']);

			if(array_key_exists('validator', $config))
				$this->addValidator($config['validator']);

			if(array_key_exists('validators', $config))
				$this->addValidators($config['validators']);

			if(!$this->name || !is_string($this->name))
				throw new Exception('Form Elements must have a name');
		}

		/**
		 * Get the name of this form element
		 * @return String
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * Set the value of this element
		 * @param $value
		 * @return $this
		 */
		public function setValue($value) {
			$this->value = $value;
			return $this;
		}

		/**
		 * Checks current value of this element. If this variable was sent
		 * in a user request (get, post, header) it will overwrite the current
		 * value of the element first. To disable this set checkRequest to false
		 * @param bool $checkRequest Set to false to prevent overwriting with user request
		 * @return mixed
		 */
		public function getValue($checkRequest = true) {
			if($checkRequest)
				$request = Tools::request($this->name);
			if(isset($request))
				$this->value = $request;
			return $this->value;
		}

		//
		// Validation
		//

		/**
		 * Checks if the form is valid
		 * @return mixed
		 */
		public function isValid() {
			$valid = $this->validator->validate($this->getValue());
			if(!$valid)
				$this->message = new Message(array(
					'message' => $this->validator->getError(),
					'type' => Message::TYPE_ERROR
				));
			return $valid;
		}

		/**
		 * Add a validator
		 * @param Validator $validator
		 * @return $this
		 */
		public function addValidator(Validator $validator) {
			$this->validator->addValidator($validator);
			return $this;
		}

		/**
		 * Add multiple validators
		 * @param \Gisleburt\Validator\Validator[] $validators
		 * @return $this
		 */
		public function addValidators(array $validators) {
			foreach($validators as $validator)
				$this->addValidator($validator);
			return $this;
		}

		/**
		 * Set whether this input is required for validation
		 * @param $required
		 * @return $this
		 */
		public function setRequired($required) {
			$this->validator->setRequired($required);
			return $this;
		}

		/**
		 * Is this input required for validation
		 * @return bool
		 */
		public function isRequired() {
			return $this->validator->isRequired();
		}

		/**
		 * Returns the last error if there were any
		 * @return string
		 */
		public function getError() {
			return $this->validator->getError();
		}

		/**
		 * Sets the error message for this element
		 * @param $message
		 * @return $this
		 */
		public function setError($message) {
			$this->validator->setError($message);
			return $this;
		}

	}