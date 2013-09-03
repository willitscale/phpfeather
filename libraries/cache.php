<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

@include_once( 'exceptions/cache.php' );

class Cache
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
			$this->createInstance( $local, $attributes );
	}
	
	public function createInstance( $name = null, $attributes = array() )
	{
		if( is_null( $name ) )
			$name = 'default';
		
		if( !is_array( $attributes ) )
			throw new CacheException( INVALID_ATTRIBUTES );

		$path = Application::getPath( DRIVER_CACHE_DIR, strtolower( $attributes[ 'driver' ] ) );

		@include_once( $path );

		try
		{
			$class = sprintf( '%sDriver', ucfirst( $attributes[ 'driver' ] ) );
			
			$this->instances[ $name ] = new $class( $attributes );
		}
		catch( Exception $e )
		{
			throw new Exception( sprintf( DRIVER_NOT_EXIST, $attributes[ 'driver' ] ) );
		}
		
		$this->instances[ $name ]->connect();
		
		$this->currentInstance = $name;
	}
	
	public function setCurrentInstance( $instanceName = null )
	{
		if( !isset( $instanceName ) || is_null( $instanceName ) || !array_key_exists( $instanceName ) )
			return 0;
		
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
