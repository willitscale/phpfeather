<?php namespace n3tw0rk\phpfeather\abstraction;

/**
 *	Cached Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Cached
{
	protected $attributes;
	protected $object;

	public abstract function connect();
	public abstract function disconnect();
	public abstract function set( $key, $value, $expiry = 86400 );
	public abstract function get( $key );
	public abstract function remove( $key );
	public abstract function exists( $key );
	public abstract function flush();
	public abstract function replace( $key, $value, $expiry = 86400 );
}
