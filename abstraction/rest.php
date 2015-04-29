<?php namespace n3tw0rk\phpfeather\abstraction;

/**
 *	Rest Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Rest extends System
{
	protected $id;
	protected $child;

	abstract public function _GET();
	abstract public function _POST();
	abstract public function _DELETE();
	abstract public function _PUT();
	abstract public function _PATCH();
	
	public function setID( $id )
	{
		$this->id = $id;
	}
}
