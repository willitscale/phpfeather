<?php namespace n3tw0rk\phpfeather\Libraries\Cookies;

use n3tw0rk\phpfeather\System\Application;
use n3tw0rk\phpfeather\Libraries\Cookies\Exceptions AS Exceptions;

/**
 *	Cookies Library
 *
 *	@version 0.0.1
 *	@package n3tw0rk\phpfeather\Libraries\Sessions
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Cookies
{
	const COOKIES_DRIVER = 'n3tw0rk\\phpfeather\\Libraries\\Cookies\\Drivers\\';

	public function __construct()
	{
		$this->init();
	
	}
	
	public function init()
	{
		$cookies = Application::getConfig( 'Cookies' );

		$driver = 'Browser';
		
		if( array_key_exists( 'driver', $cookies ) )
		{
			$driver = $cookies[ 'driver' ];
		}

		try
		{
			$class = self::COOKIES_DRIVER . $driver;
			$this->driver = new $class( $cookies );
		}
		catch( Exception $e )
		{
			throw new Exceptions\CookiesDriver;
		}
			
	}
	
	/**
	 * Exist Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function exists( $key )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'exist' ), $params );
	}
	
	/**
	 * Get Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function get( $key )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'get' ), $params );
	}
	
	/**
	 * Set Method
	 *
	 * @param String
	 * @param String
	 * @param bool
	 * @return Mixed
	 */
	public function set( $key, $value, $expiry = 0, $encrypt = false )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'set' ), $params );
	}
	
	/**
	 * Delete Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function delete( $key )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'delete' ), $params );
	}
	
	/**
	 * Destroy Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function destroy()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'destroy' ), $params );
	}

}
