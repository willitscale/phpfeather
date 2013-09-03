<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/system.php' );

abstract class Controller extends System
{

	protected $params = array();
	protected $controller;
	protected $action;

	public function __construct()
	{
		parent::__construct();
		$this->controller = Application::getControllerString();
		$this->action = Application::getActionString();
		
		$this->params[ 'title' ] = 'PCSPECPRO';
		$this->params[ 'controller' ] = $this->controller;
		$this->params[ 'action' ] = $this->action;
	}

	abstract public function init();
}
