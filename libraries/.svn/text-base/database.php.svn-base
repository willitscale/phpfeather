<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

@include_once( 'exceptions/database.php' );
	
class Database
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
			$this->createInstance( $local, $attributes );
	}
	
	public function createInstance( $name = null, $attributes = array() )
	{
		if( is_null( $name ) )
			$name = 'default';
		
		if( !is_array( $attributes ) || 0 >= sizeof( $attributes ) )
			throw new DatabaseException( INVALID_DB_ATTRIBUTES );
		
		if( !array_key_exists( 'driver', $attributes ) )
			throw new DatabaseException( INVALID_DB_DRIVER );
		
		if( !array_key_exists( 'user', $attributes ) )
			throw new DatabaseException( INVALID_DB_USER );
		
		if( !array_key_exists( 'pass', $attributes ) )
			throw new DatabaseException( INVALID_DB_PASS );
		
		if( !array_key_exists( 'data', $attributes ) )
			throw new DatabaseException( INVALID_DB_DATA );
		
		if( !array_key_exists( 'host', $attributes ) )
			throw new DatabaseException( INVALID_DB_HOST );
		
		if( !array_key_exists( 'port', $attributes ) )
			throw new DatabaseException( INVALID_DB_PORT );

		$path = Application::getPath( DRIVER_DB_DIR, strtolower( $attributes[ 'driver' ] ) );

		@include_once( $path );

		try
		{
			$class = sprintf( '%sDriver', ucfirst( $attributes[ 'driver' ] ) );
			
			$this->instances[ $name ] = new $class( $attributes[ 'host' ], $attributes[ 'user' ], $attributes[ 'pass' ], 
				$attributes[ 'data' ], $attributes[ 'port' ] );
		}
		catch( Exception $e )
		{
			throw new Exception( sprintf( DRIVER_NOT_EXIST, $attributes[ 'driver' ] ) );
		}
		
		$this->instances[ $name ]->connect();
		
		$this->currentInstance = $name;
	}
	
	public function query()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'query' ), $params );
	}
	
	public function queryString()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'queryString' ), $params );
	}
	
	public function setCurrentInstance( $instanceName = null )
	{
		if( !isset( $instanceName ) || is_null( $instanceName ) || !array_key_exists( $instanceName ) )
			return 0;
		
		$this->currentInstance = $instanceName;
		
		return 1;
	}
	
	public function error()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'error' ), $params );
	}
	
	public function id()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'id' ), $params );
	}
	
	public function info()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'info' ), $params );
	}

}