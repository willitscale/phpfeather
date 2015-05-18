<?php

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

/**
 *	Session Library
 *
 *	@version 0.0.1
 *	@package libraries\sessions
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_Sessions
{
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
	public function init()
	{
		global $session;
		
		$driverName = 'php';

		if( array_key_exists( 'type', $session ) )
		{
			$driverName = $session[ 'type' ];
		}

		$path = SYSTEM\PHPF_Application::getPath( DRIVER_SES_DIR, strtolower( $driverName ) );

		require_once( $path );

		try
		{
			$class = ucfirst( $driverName ) . 'Driver';
			$this->driver = new $class();
		}
		catch( Exception $e )
		{
			throw new EXCEPTIONS\PHPF_SessionException( sprintf( DRIVER_NOT_EXIST, $driverName ) );
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
