<?php

namespace uk\co\n3tw0rk\phpfeather\drivers\cache;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstraction/cached.php' );
include_once( 'exceptions/cache.php' );

use uk\co\n3tw0rk\phpfeather\abstraction as ABSTRACTION;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

class PHPF_MemcacheDriver extends ABSTRACTION\PHPF_Cached
{

	public function __construct( $attributes = array() )
	{
		if( !class_exists( 'Memcache' ) )
		{
			throw new EXCEPTIONS\PHPF_CacheException( INVALID_MEMCACHE );
		}

		if( !array_key_exists( 'host', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_CacheException( INVALID_CACHE_HOST );
		}

		if( !array_key_exists( 'port', $attributes ) )
		{
			throw new EXCEPTIONS\PHPF_CacheException( INVALID_CACHE_PORT );
		}

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
