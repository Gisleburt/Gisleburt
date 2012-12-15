<?php

	namespace Gisleburt\Tools;

	/**
	 * Finds the requested controller
	 * @author Daniel Mason
	 */
	class Router {
		
		protected $requestUri;
		
		protected $controllerName;
		 
		protected $actionName;
		
		public function __construct() {
			$this->requestUri = $_SERVER['REQUEST_URI'];
		}
		
		/**
		 * Analyse a request to get the controller, action and any parameters
		 * @param string $uri
		 */
		public function analyseRequest($uri = null) {
			
			if(!$uri)
				$uri = $this->requestUri;
			
			$request = explode('?', $uri);
			$rawParameters = explode('/', $request[0]);
			array_shift($rawParameters); // First element will be empty as string starts with /
			
			// Controller
			$this->controllerName = array_shift($rawParameters);
			if(!$this->controllerName)
				$this->controllerName = 'index';
			
			// Action
			$this->actionName = array_shift($rawParameters);
			if(!$this->actionName)
				$this->actionName = 'index';
			
			// Fix names
			$this->controllerName = ucwords($this->controllerName);
			$this->actionName     = ucwords($this->actionName);
			
		}
		
		/**
		 * Tries to load the requested controller
		 */
		public function loadController() {
			if($this->controllerName && $this->actionName) {
				try {
					$this->controller = new $this->controllerName($this->parameters);
					$this->controller->{$this->actionName}();
				}
				catch(LazyData_Exception $e) {
					// TODO: We need to come back here
				}
			}
		}
				
	}