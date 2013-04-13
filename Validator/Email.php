<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests for a (vaguely) correct email address
	 */
	class Email extends Regex
	{

		const ERROR_INVALID = 'Doesn\'t appear to be a valid email address';

		public function __construct(array $config = array()) {
			$config['pattern'] = "/\b[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+[A-Z]{2,6}\b/i";
			parent::__construct($config);
		}

	}
