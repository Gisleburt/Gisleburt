<?php

	namespace Gisleburt\Templates;

	/**
	 * Created by JetBrains PhpStorm.
	 * User: Daniel
	 * Date: 26/12/12
	 * Time: 05:17
	 * To change this template use File | Settings | File Templates.
	 */
	class Smarty implements TemplateInterface
	{

		/**
		 * @var \Smarty
		 */
		protected $smarty;

		/**
		 * @var string
		 */
		protected $template;


		/**
		 * Any initialisation should be done here
		 * @param $config array
		 */
		public function initialise(array $config) {
			$this->smarty = new \Smarty();
			$this->smarty->addConfigDir($config['configDir']);
			$this->smarty->addPluginsDir($config['pluginsDir']);
			$this->smarty->addPluginsDir($config['sysPluginsDir']);
			$this->smarty->setCacheDir($config['cacheDir']);
			$this->smarty->setCompileDir($config['compileDir']);
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
