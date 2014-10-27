<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstraction/system.php' );

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;


/**
 *	Controller
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_Controller extends PHPF_System
{
	protected $controller;
	protected $action;

	public function __construct()
	{
		parent::__construct();
		$this->controller = SYSTEM\PHPF_Application::getControllerString();
		$this->action = SYSTEM\PHPF_Application::getActionString();
		
		$this->params[ 'title' ] = 'Title';
		$this->params[ 'controller' ] = $this->controller;
		$this->params[ 'action' ] = $this->action;
	}

	/**
	 * Default HTTP init method
	 */
	abstract public function init();

	/**
	 * Default shell init method
	 */
	abstract public function __init();
}
