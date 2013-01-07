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

			require_once "{$config['includeDir']}/Smarty.class.php";

			$this->smarty = new \Smarty();

			if(array_key_exists('configDir', $config))
				$config['configDirs'][] = $config['configDir'];

			if(array_key_exists('pluginDir', $config))
				$config['pluginDirs'][] = $config['pluginDir'];

			if(array_key_exists('templateDir', $config))
				$config['templateDirs'][] = $config['templateDir'];

			foreach($config['configDirs'] as $dir)
				$this->smarty->addConfigDir($dir);

			foreach($config['pluginsDirs'] as $dir)
				$this->smarty->addPluginsDir($dir);

			foreach($config['templateDirs'] as $dir)
				$this->smarty->addTemplateDir($dir);

			$this->smarty->setCacheDir($config['cacheDir']);

			$this->smarty->setCompileDir($config['compileDir']);

			$this->smarty->error_reporting = E_ERROR;

			$this->smarty->muteExpectedErrors();

			$this->config = $config;

		}

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null) {
			$this->smarty->assign($name, $value);
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

			$this->smarty->display($template);

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

	}
