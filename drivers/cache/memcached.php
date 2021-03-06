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

/**
 *	Memcached Driver
 *
 *	@version 0.0.1
 *	@package uk\co\n3tw0rk\phpfeather\drivers\cache
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_MemcachedDriver extends ABSTRACTION\PHPF_Cached
{
	private $prefix = "";
	private $suffix = "";

	public function __construct( $attributes = array() )
	{
		if( !class_exists( 'Memcached' ) )
		{
			throw new EXCEPTIONS\PHPF_CacheException( INVALID_MEMCACHED );
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

		if( !empty( $this->attributes[ 'prefix' ] ) )
		{
			$this->prefix = $this->attributes[ 'prefix' ];
		}

		if( !empty( $this->attributes[ 'suffix' ] ) )
		{
			$this->suffix = $this->attributes[ 'suffix' ];
		}
	}
	
	public function connect()
	{
		$this->object = new \Memcached();
		$this->object->addServer( $this->attributes[ 'host' ], $this->attributes[ 'port' ] );
	}
	
	public function disconnect()
	{
		unset( $this->object );
	}
	
	public function set( $key, $value, $expiry = 86400 )
	{
		return $this->object->set( $this->prefix . $key . $this->suffix, serialize( $value ), $expiry );
	}
	
	public function remove( $key )
	{
		return $this->object->delete( $this->prefix . $key . $this->suffix );
	}
	
	public function exists( $key )
	{
		return ( false !== $this->object->get( $this->prefix . $key . $this->suffix ) );
	}
	
	public function get( $key )
	{
		$data = $this->object->get( $this->prefix . $key . $this->suffix );

		if( false === $data )
		{
			return null;
		}
		
		return unserialize( $data );
	}
	
	public function flush()
	{
		return $this->object->flush();
	}
	
	public function replace( $key, $value, $expiry = 86400 )
	{
		return $this->object->replace( $this->prefix . $key . $this->suffix, $value );
	}

}
