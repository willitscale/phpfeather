<?php namespace n3tw0rk\phpfeather\system;

use n3tw0rk\phpfeather\abstraction\Model;

/**
 *	Object Pool	
 *
 *	@version 0.0.1
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

	public function &getWorker( $worker = null )
	{
		if( is_null( $worker ) || !array_key_exists( $worker, self::$workerPool ) )
		{
			return self::$null;
		}

		return self::$workerPool[ $worker ];
	}
	
	public function &addModel( $name = null, &$model = null )
	{
		if( !isset( $name ) || !isset( $model ) || !( $model instanceof Model ) )
		{
			return self::$null;
		}

		self::$modelPool[ $name ] = $model;

		return self::$modelPool[ $name ];
	}
	
	public function &getLibrary( $library = null )
	{
		if( !isset( $library ) || !array_key_exists( $library, self::$libraryPool ) )
		{
			return self::$null;
		}

		return self::$libraryPool[ $library ];
	}
	
	public function &addLibrary( $name = null, &$library = null )
	{
		if( !isset( $name ) || !isset( $library ) )
		{
			return self::$null;
		}

		self::$libraryPool[ $name ] = $library;

		return self::$libraryPool[ $name ];
	}

	public function getRest( $rest = null )
	{
		if( !isset( $rest ) || !array_key_exists( $rest, self::$restPool ) )
		{
			return self::$null;
		}

		return self::$restPool[ $rest ];
	}

	public function &addRest( $name = null, &$rest = null )
	{
		if( !isset( $name ) || !isset( $rest ) )
		{
			return self::$null;
		}

		self::$restPool[ $name ] = $library;

		return self::$restPool[ $name ];
	}

	public static function &instance()
	{
		if( is_null( self::$instance ) || !( self::$instance instanceof ObjectPool ) )
		{
			self::$instance = new ObjectPool();
		}

		return self::$instance;
	}

}
