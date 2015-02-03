<?php

namespace uk\co\n3tw0rk\phpfeather\libraries;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'exceptions/database.php' );

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

/**
 *	Database Library
 *
 *	@version 0.0.1
 *	@package libraries\database
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_Database
{

	private $instances = array();
	private $currentInstance;

	public function __construct()
	{
		$this->autoloadDatabases();
	}

	public function autoloadDatabases()
	{
		global $database;

		foreach( $database AS $local => $attributes )
		{
			$this->createInstance( $local, $attributes );
		}
	}
	
	public function createInstance( $name = null, $attributes = array() )
	{
		if( is_null( $name ) )
		{
			$name = 'default';
		}

		if( empty( $attributes ) || !is_array( $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_ATTRIBUTES );
		}

		if( !array_key_exists( 'driver', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_DRIVER );
		}

		if( !array_key_exists( 'user', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_USER );
		}

		if( !array_key_exists( 'pass', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_PASS );
		}

		if( !array_key_exists( 'data', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_DATA );
		}

		if( !array_key_exists( 'host', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_HOST );
		}

		if( !array_key_exists( 'port', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_PORT );
		}

		if( !array_key_exists( 'test', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_TEST );
		}

		if( !array_key_exists( 'extr', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_EXTRAS );
		}

		$path = SYSTEM\PHPF_Application::getPath( DRIVER_DB_DIR, strtolower( $attributes[ 'driver' ] ) );

		include_once( $path );

		try
		{
			$class = CONNECTION_DRIVER_PREFIX . ucfirst( $attributes[ 'driver' ] ) . 'Driver';
			
			$this->instances[ $name ] = new $class( $attributes[ 'host' ], $attributes[ 'user' ], $attributes[ 'pass' ], 
				$attributes[ 'data' ], $attributes[ 'port' ], $attributes[ 'extr' ] );
		}
		catch( Exception $e )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( sprintf( DRIVER_NOT_EXIST, $attributes[ 'driver' ] ) );
		}
		
		$this->currentInstance = $name;
		
		if( $attributes[ 'test' ] )
		{
			$this->testConnection();
		}
	}
	
	public function query()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'query' ), $params );
	}
	
	public function exec()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'exec' ), $params );
	}
	
	public function queryString()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'queryString' ), $params );
	}
	
	public function setCurrentInstance( $instanceName = null )
	{
		if( empty( $instanceName ) || !array_key_exists( $instanceName ) )
		{
			return 0;
		}

		$this->currentInstance = $instanceName;
		
		return 1;
	}
	
	public function error()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'error' ), $params );
	}
	
	public function id()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'id' ), $params );
	}
	
	public function info()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'info' ), $params );
	}
	
	public function testConnection()
	{
		$this->instances[ $this->currentInstance ]->testConnection();
	}

}