<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/system.php' );

/**
 *	Controller
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Controller extends System
{

	protected $params = array();
	protected $controller;
	protected $action;

	public function __construct()
	{
		parent::__construct();
		$this->controller = PHPF_Application::getControllerString();
		$this->action = PHPF_Application::getActionString();
		
		$this->params[ 'title' ] = 'Title';
		$this->params[ 'controller' ] = $this->controller;
		$this->params[ 'action' ] = $this->action;
	}

	abstract public function init();
}
