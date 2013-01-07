<?php

	namespace Gisleburt\Templates;

	/**
	 * Smarty Template Engine wrapper
	 */
	class Php implements TemplateEngine
	{

		/**
		 * Smarty object
		 * @var \Smarty
		 */
		protected $smarty;

		/**
		 * The template to use unless otherwise stated
		 * @var string
		 */
		protected $template;

		/**
		 * Variables to be assigned to the template
		 * @var array
		 */
		protected $templateVars = array();

		/**
		 * Configuration
		 * @var array
		 */
		protected $config;

		public function __construct(array $config = array()) {
			if($config)
				$this->initialise($config);
		}

		/**
		 * Any initialisation should be done here
		 * @param $config array
		 */
		public function initialise(array $config) {

			$this->config = $config;

		}

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null) {
			$this->templateVars[$name] = $value;
		}

		/**
		 * Set the template that will be used
		 * @param $name string Name of the template file
		 */
		public function setTemplate($template) {
			$this->template = $template;
		}

		/**
		 * Display the chosen template.
		 * @param $template string (optional) Override previously set template for this action only
		 */
		public function display($template = null) {
			if(!isset($template)) {
				if(isset($this->template))
					$template = $this->template;
				else
					throw new \Exception('No template was set');
			}

			extract($this->templateVars);
			require $this->getTemplate($template);

		}

		/**
		 * Compiles the template and returns the result as a string
		 * @param $template string (optional) Override previously set template for this action only
		 * @return string
		 */
		public function fetch($template = null) {
			if(!isset($template)) {
				if(isset($this->template))
					$template = $this->template;
				else
					throw new \Exception('No template was set');
			}
			return $this->smarty->fetch($template);
		}

		protected function getTemplate($template) {
			$failedDirs = array();
			foreach($this->config['templateDirs'] as $dir) {
				if(is_readable("$dir/$template"))
					return "$dir/$template";
				$failedDirs[] = $dir;
			}
			throw new \Exception("Template '$template' not found in: ".implode(', ', $failedDirs));
		}



	}
