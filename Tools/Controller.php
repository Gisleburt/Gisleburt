<?php

	namespace Gisleburt\Tools;

	abstract class Controller {

		/**
		 * The name of this controller (used for loading templates)
		 * @var
		 */
		protected $controllerName;

		/**
		 * Parameters 
		 * @var array
		 */
		protected $uriParameters;
		
		/**
		 * Where to find the templates
		 * @var string
		 */
		protected $templateDir;
		
		/**
		 * Variables to be given to the template
		 * @var stdClass
		 */
		protected $view;
		
		public function __construct(array $uriParameters = null) {
			$this->view = new \stdClass();
			$this->uriParameters = $uriParameters;
			$controllerNameExploded = explode('\\', get_called_class());
			$this->controllerName = array_pop($controllerNameExploded);

		}
		
		/**
		 * Display the appropriate template file
		 */
		protected function _display($action) {

			// Probably not the right way to do this
			global $smarty;

			// Get the template appropriate template
			$template = $this->_getTemplate($action);

			// Assign the view parameters to the template
			$smarty->assign(get_object_vars($this->view));

			try {
			// Display the template
			$smarty->display($template);
			}
			catch(\Exception $e) {
				echo $e->getMessage();
			}
			echo '2';

		}

		public function callAction($action) {
			if(method_exists($this, $action.'Action'))
				$actionToCall = $action;
			else
				$actionToCall = 'Index';

			if(!method_exists($this, $actionToCall.'Action'))
				throw new \Exception("No Index action and could not start action: $action");

			$this->{$actionToCall.'Action'}();

			$this->_display($action);
		}
		
		/**
		 * Gets the location of the file to be displayed.
		 * Relative or absolute file can be used to override automated functionality
		 * @param string $file
		 */
		protected function _getTemplate($file = null) {
			$file = "$this->templateDir/$this->controllerName/$file.tpl";

			if(!is_readable($file))
				throw new \Exception('Could not find template file: $file');

			return $file;

		}

		/**
		 * Look for a parameter based on _REQUEST then URI elements
		 * @param $name
		 */
		protected function _getParam($name) {

			// Check if the request key is already set
			if(isset($_REQUEST[$name]))
				return $_REQUEST[$name];

			// See if the


		}
		
	}