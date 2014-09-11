<?php

namespace uk\co\n3tw0rk\phpfeather\libraries;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'exceptions/cache.php' );

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

class PHPF_Cache
{
	private $instances = array();
	private $currentInstance;

	public function __construct()
	{
		$this->autoloadCaches();
	}

	public function autoloadCaches()
	{
		global $cached;
		foreach( $cached AS $local => $attributes )
		{
			$this->createInstance( $local, $attributes );
		}
	}
	
	public function createInstance( $name = null, $attributes = array() )
	{
		if( empty( $name ) )
		{
			$name = 'default';
		}
		
		if( !is_array( $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_CacheException( INVALID_ATTRIBUTES );
		}

		if( !array_key_exists( 'driver', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_CACHE_DRIVER );
		}

		$path = SYSTEM\PHPF_Application::getPath( DRIVER_CACHE_DIR, strtolower( $attributes[ 'driver' ] ) );

		include_once( $path );

		try
		{
			$class = CACHE_DRIVER_PREFIX . ucfirst( $attributes[ 'driver' ] ) . 'Driver';
			
			$this->instances[ $name ] = new $class( $attributes );
		}
		catch( Exception $e )
		{
			throw new EXCEPTIONS\PHPF_CacheException( sprintf( DRIVER_NOT_EXIST, $attributes[ 'driver' ] ) );
		}
		
		$this->instances[ $name ]->connect();
		
		$this->currentInstance = $name;
	}
	
	public function setCurrentInstance( $instanceName = null )
	{
		if( !empty( $instanceName ) || !array_key_exists( $instanceName ) )
		{
			return 0;
		}

		$this->currentInstance = $instanceName;
		
		return 1;
	}
	
	public function get()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'get' ), $params );
	}
	
	public function set()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'set' ), $params );
	}
	
	public function exists()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'exists' ), $params );
	}
	
	public function flush()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'flush' ), $params );
	}

}
