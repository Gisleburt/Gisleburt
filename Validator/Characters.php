<?php

	namespace Gisleburt\Validator;

	/**
	 * Tests against a set of given characters
	 */
	class Characters extends Regex
	{

		const ERROR_INVALID = 'Contains invalid characters';

		const CHARS_LOWER_CASE = 'a-z';
		const CHARS_UPPER_CASE = 'A-Z';
		const CHARS_NUMBERS = '1-9';
		const CHARS_SPACE = '\ ';
		const CHARS_UNDERSCORE = '_';

		public function __construct(array $characters) {

			if(!$characters)
				throw new \Exception('No characters were defined');

			foreach($characters as $character) {
				$this->regex .= $character;
			}
			$this->regex = "/^[$this->regex]+$/";

		}

	}
