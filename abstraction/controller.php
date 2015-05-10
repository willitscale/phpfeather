<?php namespace n3tw0rk\phpfeather\Abstraction;

use n3tw0rk\phpfeather\System\Application;

/**
 *	Controller Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Controller extends System
{
	protected $controller;
	protected $action;

	public function __construct()
	{
		parent::__construct();
		
		$this->controller = Application::getControllerString();
		$this->action = Application::getActionString();
		
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
