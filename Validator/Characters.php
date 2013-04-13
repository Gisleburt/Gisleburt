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

		public function __construct(array $config = array()) {

			if(!array_key_exists('characters', $config))
				throw new \Exception('No characters were defined');

			// The info we want to pass to the parent
			$config['pattern'] = '';

			// The info we're given
			$config['characters'] = (array)$config['characters'];
			foreach($config['characters'] as $character)
				$config['pattern'] .= $character;

			$config['pattern'] = "/^[{$config['pattern']}]+$/";

			parent::__construct($config);

		}

	}
