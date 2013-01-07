<?php

	namespace Gisleburt\Templates;

	/**
	 * Smarty Template Engine wrapper
	 */
	class Smarty implements TemplateEngine
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
			require_once $config['twigDir'].'/Autoloader.php';
			\Twig_Autoloader::register();

			$loader = new \Twig_Loader_Filesystem($config['templateDirs']);
			$this->twig = new \Twig_Environment($loader, array(
				'cache' => $config['compileDir'],
				'debug' => $config['devmode'],
			));

		}

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null) {
			$this->templateVariables[$name] = $value;
		}

		/**
		 * Set the template that will be used
		 * @param $template
		 * @return void
		 * @internal param string $name Name of the template file
		 */
		public function setTemplate($template) {
			$this->template = $template;
		}

		/**
		 * Display the chosen template.
		 * @param $template string (optional) Override previously set template for this action only
		 * @throws \Exception
		 * @return void
		 */
		public function display($template = null) {
			if(!isset($template)) {
				if(isset($this->template))
					$template = $this->template;
				else
					throw new \Exception('No template was set');
			}

			echo $this->twig->render($template, $this->templateVariables);
		}

		/**
		 * Compiles the template and returns the result as a string
		 * @param $template string (optional) Override previously set template for this action only
		 * @throws \Exception
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


	}