<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	Cached Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Cached
{
	/**
	 * @access protected
	 * @var unknown
	 */
	protected $attributes;
	
	/**
	 * @access protected
	 * @var unknown
	 */
	protected $object;

	/**
	 * Connect Method
	 * 
	 * @access
	 * @abstract
	 * @return void
	 */
	public abstract function connect();

	/**
	 * Disconnect Method
	 * 
	 * @access
	 * @abstract
	 * @return void
	 */
	public abstract function disconnect();

	/**
	 * Set Method
	 * 
	 * @access
	 * @abstract
	 * @param String $key
	 * @param Mixed $value
	 * @param int $expiry
	 * @return boolean
	 */
	public abstract function set( $key, $value, $expiry = 86400 );
	
	/**
	 * Get Method
	 * 
	 * @access
	 * @abstract
	 * @param String $key
	 * @return Mixed
	 */
	public abstract function get( $key );
	
	/**
	 * Remove Method
	 * 
	 * @access
	 * @abstract
	 * @param String $key
	 * @return 
	 */
	public abstract function remove( $key );
	
	/**
	 * Exists Method
	 * 
	 * @access
	 * @abstract
	 * @param String $key
	 * @return boolean
	 */
	public abstract function exists( $key );

	/**
	 * Flush Method
	 * 
	 * @access
	 * @abstract
	 * @return void
	 */
	public abstract function flush();
	
	/**
	 * Replace Method
	 * 
	 * @access
	 * @abstract
	 * @param String $key
	 * @param Mixed $value
	 * @param int $expiry
	 * @return 
	 */
	public abstract function replace( $key, $value, $expiry = 86400 );
}
