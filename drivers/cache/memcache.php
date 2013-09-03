<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/cached.php' );

class MemcacheDriver extends Cached
{

	public function __construct( $attributes = array() )
	{
		if( !class_exists( 'Memcache' ) )
			throw new CacheException( INVALID_MEMCACHED );
			
		if( !array_key_exists( 'host', $attributes ) )
			throw new CacheException( INVALID_CACHE_HOST );
	
		if( !array_key_exists( 'port', $attributes ) )
			throw new CacheException( INVALID_CACHE_PORT );

		$this->attributes = $attributes;
	}
	
	public function connect()
	{
		$this->object = memcache_connect( $this->attributes[ 'host' ], $this->attributes[ 'port' ] );
	}
	
	public function disconnect()
	{
	}
	
	public function set()
	{
	}
	
	public function remove()
	{
	}
	
	public function exists()
	{
	}
	
	public function flush()
	{
	}

}
