<?php
	/**
	 * Form containing a set of form elements
	 */

	namespace Gisleburt\Form;

	use Gisleburt\LazyData\Exception;
	use Gisleburt\Tools\AbstractClass;
	use Gisleburt\Tools\Tools;

	class Form extends AbstractClass {

		/**
		 * @var Element[]
		 */
		protected $formElements = array();

		/**
		 * Run the generate function immediately after the constructor
		 * @var bool default True
		 */
		protected $autoGenerate = true;

		/**
		 * Add a hidden element with the form name
		 * @var bool
		 */
		protected $addFormNameElement = true;

		/**
		 * The name of this form
		 * @var string
		 */
		protected $formName;

		/**
		 * Create a new form
		 * @param array $config
		 */
		public function __construct(array $config = array()) {
			parent::__construct($config);

			$this->formName = get_called_class();

			if($this->addFormNameElement)
				$this->addElement(new Element(array(
					'name'  => 'FormName',
					'value' => $this->formName,
				)));
			if($this->autoGenerate)
				$this->generate();
		}

		/**
		 * This function should contain all of the form elements
		 * @return null
		 */
		public function generate() {

		}

		/**
		 * Adds an element to the form
		 * @param Element $formElement
		 * @return $this
		 */
		public function addElement(Element $formElement) {
			$this->formElements[$formElement->getName()] = $formElement;
			return $this;
		}

		public function addElements(array $formElements) {
			foreach($formElements as $formElement)
				$this->addElement($formElement);
			return $this;
		}

		/**
		 * @param $name string The name of the desired element
		 * @return Element
		 * @throws \Gisleburt\LazyData\Exception
		 */
		public function getElement($name) {
			if(array_key_exists($name, $this->formElements))
				return $this->formElements[$name];
			throw new Exception("Form Element '$name' not found in Form '$this->formName'");
		}

		/**
		 * Validates the form
		 * @return bool
		 */
		public function isValid() {

			$valid = true;

			foreach($this->formElements as $formElement)
				if(!$formElement->isValid())
					$valid = false;

			return $valid;

		}

		/**
		 * Was the form data received
		 * @param $data array Optional, Data to check for form data, if not supplied $_REQUEST is used
		 * @return bool
		 */
		public function wasReceived($data = array()) {
			if($data)
				return $data['formName'] == $this->formName;
			else
				return Tools::request('formName') == $this->formName;
		}

		/**
		 * Gets the value of the named element
		 * @param $elementName
		 * @param bool $checkRequest
		 * @return mixed
		 */
		public function getValue($elementName, $checkRequest = true) {
			return $this->getElement($elementName)->getValue($checkRequest);
		}

		/**
		 * Returns a keyed array of all form values of the format field => value
		 * @param bool $checkRequest
		 * @return array
		 */
		public function getValues($checkRequest = true) {
			$values = [];
			foreach($this->formElements as $element)
				$values[$element->getName()] = $element->getValue();
			return $values;
		}

		/**
		 * Returns the last error, if any
		 * @param $elementName
		 * @return string
		 */
		public function getError($elementName) {
			return $this->getElement($elementName)->getError();
		}

		/**
		 * Returns an array of all of the errors in one list, if any
		 * @return array
		 */
		public function getErrors() {
			$errors = [];
			foreach($this->formElements as $element) {
				if($error = $element->getError())
					$errors[] = $error;
			}
			return $errors;
		}

		/**
		 * Set the error message for a given element
		 * @param $element
		 * @param $message
		 * @return $this
		 */
		public function setError($element, $message) {
			$this->getElement($element)->setError($message);
			return $this;
		}

	}