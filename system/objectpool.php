<?php namespace n3tw0rk\phpfeather\System;

use n3tw0rk\phpfeather\Abstraction\Model;

/**
 *	Object Pool	
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\system
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class ObjectPool
{
	/**
	 *	@access private
	 *	@var n3tw0rk\phpfeather\system\ObjectPool
	 */
	private static $instance = null;

	/**
	 *	@access private
	 *	@var Array
	 */
	private static $libraryPool = [];

	/**
	 *	@access private
	 *	@var Array
	 */
	private static $restPool = [];

	/**
	 *	@access private
	 *	@var Array
	 */
	private static $workerPool = [];

	/**
	 *	@access private
	 *	@var Array
	 */
	private static $configPool = [];

	/**
	 *	@access private
	 *	@var null
	 */
	private static $null = null;

	/**
	 *	@access private
	 */
	private function __construct(){}

	/**
	 *	@access private
	 */
	private function __clone(){}

	public static function &getWorker( $worker = null )
	{
		if( empty( $worker ) || !array_key_exists( $worker, self::$workerPool ) )
		{
			return self::$null;
		}

		return self::$workerPool[ $worker ];
	}
	
	public static function &addWorker( $name = null, &$worker = null )
	{
		if( empty( $name ) || empty( $worker ) || !( $worker instanceof Worker ) )
		{
			return self::$null;
		}

		self::$workerPool[ $name ] = $worker;

		return self::$workerPool[ $name ];
	}

	public static function &getConfig( $config = null )
	{
		if( empty( $config ) || !array_key_exists( $config, self::$configPool ) )
		{
			return self::$null;
		}

		return self::$configPool[ $config ];
	}
	
	public static function &addConfig( $name = null, &$config = null )
	{
		if( empty( $name ) || empty( $config )  )
		{
			return self::$null;
		}

		self::$configPool[ $name ] = $config;

		return self::$configPool[ $name ];
	}
	
	public static function &getLibrary( $library = null )
	{
		if( empty( $library ) || !array_key_exists( $library, self::$libraryPool ) )
		{
			return self::$null;
		}

		return self::$libraryPool[ $library ];
	}
	
	public static function &addLibrary( $name = null, &$library = null )
	{
		if( empty( $name ) || empty( $library ) )
		{
			return self::$null;
		}

		self::$libraryPool[ $name ] = $library;

		return self::$libraryPool[ $name ];
	}

	public static function getRest( $rest = null )
	{
		if( empty( $rest ) || !array_key_exists( $rest, self::$restPool ) )
		{
			return self::$null;
		}

		return self::$restPool[ $rest ];
	}

	public static function &addRest( $name = null, &$rest = null )
	{
		if( empty( $name ) || empty( $rest ) )
		{
			return self::$null;
		}

		self::$restPool[ $name ] = $library;

		return self::$restPool[ $name ];
	}

	public static function &instance()
	{
		if( empty( self::$instance ) || !( self::$instance instanceof ObjectPool ) )
		{
			self::$instance = new ObjectPool();
		}

		return self::$instance;
	}
}
