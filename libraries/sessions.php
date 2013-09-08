<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	Session Exception
 *
 *	@version 0.0.1
 *	@package libraries\exceptions
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_Sessions
{

	private $driver;

	public function __construct()
	{
		$this->init();
	}

	public function init()
	{
		global $session;
		
		$driverName = 'php';
		if( array_key_exists( 'type', $session ) )
			$driverName = $session[ 'type' ];
		
		$path = PHPF_Application::getPath( DRIVER_SES_DIR, strtolower( $driverName ) );

		@include_once( $path );

		try
		{
			$class = sprintf( '%sDriver', ucfirst( $driverName ) );
			$this->driver = new $class();
		}
		catch( Exception $e )
		{
			throw new Exception( sprintf( DRIVER_NOT_EXIST, $driverName ) );
		}
		
		$this->driver->start();
	
	}
	
	public function exist( $key = null )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'exist' ), $params );
	}
	
	public function get( $key = null )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'get' ), $params );
	}
	
	public function set( $key = null, $value, $encrypt = false )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'set' ), $params );
	}
	
	public function delete( $key = null )
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'delete' ), $params );
	}
	
	public function destroy()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->driver, 'destroy' ), array() );
	}
	
	public function id()
	{
		return call_user_func_array( array( $this->driver, 'id' ), array() );
	}

}
