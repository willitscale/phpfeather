<?php namespace n3tw0rk\phpfeather\Libraries\Cache;

use n3tw0rk\phpfeather\System as SYSTEM;
use n3tw0rk\phpfeather\Exceptions\Cache as CacheException;

/**
 *	Cache Library
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Cache
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Cache
{
	/** */
	private $instances = array();

	/** */
	private $currentInstance;
	
	/**
	 * Constructor Sub-Routine
	 */
	public function __construct()
	{
		$this->autoloadCaches();
	}
	
	/**
	 * Autoload Caches Method
	 *
	 * @return Mixed
	 */
	public function autoloadCaches()
	{
		global $cached;

		foreach( $cached AS $local => $attributes )
		{
			$this->createInstance( $local, $attributes );
		}
	}
	
	/**
	 * Create Instance Method
	 *
	 * @param String
	 * @param Array
	 * @return Mixed
	 */
	public function createInstance( $name = null, $attributes = array() )
	{
		if( empty( $name ) )
		{
			$name = 'default';
		}
		
		if( !is_array( $attributes ) )
		{
			throw new CacheException( INVALID_ATTRIBUTES );
		}

		if( !array_key_exists( 'driver', $attributes ) )
		{
			throw new CacheException( INVALID_CACHE_DRIVER );
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
			throw new CacheException( sprintf( DRIVER_NOT_EXIST, $attributes[ 'driver' ] ) );
		}
		
		$this->instances[ $name ]->connect();
		
		$this->currentInstance = $name;
	}
	
	/**
	 * Set Current Instance Method
	 *
	 * @param String
	 * @return Mixed
	 */
	public function setCurrentInstance( $instanceName = null )
	{
		if( !empty( $instanceName ) || !array_key_exists( $instanceName ) )
		{
			return 0;
		}

		$this->currentInstance = $instanceName;
		
		return 1;
	}
	
	/**
	 * Get Method
	 *
	 * @return Mixed
	 */
	public function get()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'get' ), $params );
	}
	
	/**
	 * Set Method
	 *
	 * @return Mixed
	 */
	public function set()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'set' ), $params );
	}
	
	/**
	 * Exists Method
	 *
	 * @return Mixed
	 */
	public function exists()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'exists' ), $params );
	}
	
	/**
	 * Flush Method
	 *
	 * @return Mixed
	 */
	public function flush()
	{
		$params = func_get_args();
		return call_user_func_array( array( $this->instances[ $this->currentInstance ], 'flush' ), $params );
	}
}
