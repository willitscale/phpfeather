<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	Session Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Session
{
	abstract public function start();
	
	abstract public function exist( $key = null );
	
	abstract public function get( $key = null );
	
	abstract public function set( $key = null, $value, $encrypt = false );
	
	abstract public function delete( $key = null );
	
	abstract public function destroy();
	
	abstract public function id();
}
