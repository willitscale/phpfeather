<?php namespace n3tw0rk\phpfeather\drivers\cache;

include_once( 'abstraction/cached.php' );
include_once( 'exceptions/cache.php' );

use n3tw0rk\phpfeather\abstraction\Cached;
use n3tw0rk\phpfeather\exceptions\CacheException;

/**
 *	Memcache Driver Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\drivers\cache
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class MemcacheDriver extends Cached
{

	public function __construct( $attributes = array() )
	{
		if( !class_exists( 'Memcache' ) )
		{
			throw new CacheException( INVALID_MEMCACHE );
		}

		if( !array_key_exists( 'host', $attributes ) )
		{
			throw new CacheException( INVALID_CACHE_HOST );
		}

		if( !array_key_exists( 'port', $attributes ) )
		{
			throw new CacheException( INVALID_CACHE_PORT );
		}

		$this->attributes = $attributes;
	}
	
	public function connect()
	{
		$this->object = new Memcache;
		$this->object->connect( $this->attributes[ 'host' ], $this->attributes[ 'port' ] );
	}
	
	public function disconnect()
	{
		$this->object->close();
	}
	
	public function set( $key, $value, $expiry = 86400 )
	{
		return $this->object->set( $key, serialize( $value ), $expiry );
	}
	
	public function remove( $key )
	{
		return $this->object->delete( $key );
	}
	
	public function exists( $key )
	{
		return ( false !== $this->object->get( $key ) );
	}
	
	public function flush()
	{
		return $this->object->flush();
	}
	
	public function replace( $key, $value, $expiry = 86400 )
	{
		return $this->object->replace( $key, $value );
	}
}
