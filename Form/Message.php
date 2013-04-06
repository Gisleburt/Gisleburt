<?php



	namespace Gisleburt\Form;

	use Gisleburt\Tools\AbstractClass;

	/**
	 * A message for forms or form elements
	 * @author Daniel Mason
	 */
	class Message extends AbstractClass{

		const TYPE_ERROR = 'error';
		const TYPE_INFO  = 'info';

		protected $type;

		protected $message;

		public function __construct(array $config = array()) {
			parent::__construct($config);
		}

		public function getMessage() {
			return $this->message;
		}

		public function getType() {
			return $this->type;
		}

	}