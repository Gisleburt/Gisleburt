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
		 * Variables to be given to the template
		 * @var stdClass
		 */
		protected $view;

		/**
		 * The action trying to be called
		 * @var string
		 */
		protected $actionAttempted;

		/**
		 * Which action was actually called
		 * @var string
		 */
		protected $actionCalled;

		/**
		 * Global router object
		 * @var Router
		 */
		protected $router;
		
		public function __construct(array $uriParameters = null) {
			global $router, $login;
			$this->router = $router;
			$this->view = new \stdClass();
			$this->view->login = $login;
			$this->uriParameters = $uriParameters;
			$controllerNameExploded = explode('\\', get_called_class());
			$this->controllerName = array_pop($controllerNameExploded);
		}
		
		/**
		 * Display the appropriate template file
		 */
		protected function _display($action) {

			// Probably not the right way to do this
			global $template;

			// Get the template appropriate template
			$templateFile = $this->_getTemplate($action);

			// Assign the view parameters to the template
			$template->assign(get_object_vars($this->view));

			// Display the template
			$template->display($templateFile);

			exit;

		}

		public function callAction($action) {

			$this->actionAttempted = $action;

			if(method_exists($this, $action.'Action'))
				$actionToCall = $action;
			else
				$actionToCall = 'index';

			if(!method_exists($this, $actionToCall.'Action'))
				throw new \Exception("No Index action and could not start action: $action");

			$this->actionCalled = $actionToCall;

			$this->{$actionToCall.'Action'}();

			$this->_display($actionToCall);
		}
		
		/**
		 * Gets the location of the file to be displayed.
		 * Relative or absolute file can be used to override automated functionality
		 * @param string $file
		 */
		protected function _getTemplate($file) {
			$file = ucfirst($file);
			$file = "$this->controllerName/$file.tpl";
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

			// TODO: Really need to make this more comprehensive

		}
		
	}