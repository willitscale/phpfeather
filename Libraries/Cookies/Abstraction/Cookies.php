<?php namespace n3tw0rk\phpfeather\Libraries\Cookies\Abstraction;

/**
 *	Cookies Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Cookies\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Cookies
{
	protected $config;
	
	public function __construct( $config )
	{
		$this->config = $config;
	}
	
	abstract public function exist( $key );
	
	abstract public function get( $key );
	
	abstract public function set( $key, $value, $expiry = null, $encrypt = false );
	
	abstract public function delete( $key );
	
	abstract public function destroy();
}
