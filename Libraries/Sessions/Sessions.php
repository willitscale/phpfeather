<?php namespace n3tw0rk\phpfeather\Libraries\Sessions;

use n3tw0rk\phpfeather\System\Application;
use n3tw0rk\phpfeather\Libraries\Sessions\Exceptions AS Exceptions;

/**
 *	Session Library
 *
 *	@version 0.0.1
 *	@package n3tw0rk\phpfeather\Libraries\Sessions
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Sessions
{
	const SESSION_EXCEPTION = 'n3tw0rk\\phpfeather\\Libraries\\Sessions\\Exceptions\\';
	const SESSION_DRIVER = 'n3tw0rk\\phpfeather\\Libraries\\Sessions\\Drivers\\';

	/** */
	private $driver;
	
	/**
	 * Constructor Sub-Routine
	 */
	public function __construct()
	{
		$this->init();
	}
	
	/**
	 * Init Method
	 *
	 * @return void
	 */
	protected function init()
	{
		$session = Application::getConfig( 'Session' );

		$driver = 'php';
		if( array_key_exists( 'driver', $session ) )
		{
			$driver = $session[ 'driver' ];
		}

		try
		{
			$class = self::SESSION_DRIVER . $driver;
			$this->driver = new $class;
		}
		catch( Exception $e )
		{
			throw new Exceptions\SessionDriver;
		}
		
		$this->driver->start();
	}
	
	/**
	 * Exist Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function exist( $key = null )
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
	public function get( $key = null )
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
	public function set( $key = null, $value, $encrypt = false )
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
	public function delete( $key = null )
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
		return call_user_func_array( array( $this->driver, 'destroy' ), array() );
	}
	
	/**
	 * ID Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function id()
	{
		return call_user_func_array( array( $this->driver, 'id' ), array() );
	}
}
