<?php

	namespace Gisleburt\Tools;

	class Controller {
		
		/**
		
		/**
		 * Parameters 
		 * @var array
		 */
		protected $parameters;
		
		/**
		 * The template controller
		 * @var Smarty
		 */
		protected $smarty;
		
		/**
		 * This can be overriden to display a different template
		 * @var string
		 */
		protected $template;
		
		/**
		 * Variables to be given to the template
		 * @var stdClass
		 */
		protected $view;
		
		public function __construct(array $parameters = null) {
			
			$this->parameters = $parameters['parameters'];
			
			$this->view = new stdClass();
			
			$smartyFolder = APP_DIR.'../libs/Smarty/';
			
			require_once $smartyFolder.'Smarty.class.php';
			
			// Create an instance of the template controller
			$this->smarty = new Smarty();
			$this->smarty->setTemplateDir(APP_DIR.'templates'       )
			             ->setCompileDir($smartyFolder.'templates_c')
			             ->setCacheDir(  $smartyFolder.'cache'      )
			             ->setConfigDir( $smartyFolder.'configs'    );
			$this->smarty->error_reporting = E_ERROR;
			 
		}
		
		/**
		 * Display the appropriate template file
		 */
		protected function _display() {
			$this->template = $this->_getTemplate($this->template);
			$this->smarty->assign(get_object_vars($this->view));
			$this->smarty->display($this->template);
		}
		
		/**
		 * Gets the location of the file to be displayed.
		 * Relative or absolute file can be used to override automated functionality
		 * @param string $file
		 */
		protected function _getTemplate($file = null) {
			if(!$file)
				$file = $this->parameters['action'].'.tpl';
			if(strpos($file, '/'));
				$file = APP_DIR."Controllers/Template/{$this->parameters['controller']}/$file";
			return $file;
		}
		
	}