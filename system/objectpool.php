<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	Object Pool	
 *
 *	@version 0.0.1
 *	@package phpfeather\system
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_ObjectPool
{
	/**
	 *	@access private
	 *	@var PHPF_ObjectPool
	 */
	private static $instance = null;

	/**
	 *	@access private
	 *	@var Array
	 */
	private static $modelPool = array();

	/**
	 *	@access private
	 *	@var Array
	 */
	private static $libraryPool = array();

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

	public function &getModel( $model = null )
	{
		if( is_null( $model ) || !array_key_exists( $model, self::$modelPool ) )
			return self::$null;

		return self::$modelPool[ $model ];
	}
	
	public function &addModel( $name = null, &$model = null )
	{
		if( !isset( $name ) || !isset( $model ) || !( $model instanceof PHPF_Model ) )
			return self::$null;

		self::$modelPool[ $name ] = $model;

		return self::$modelPool[ $name ];
	}
	
	public function &getLibrary( $library = null )
	{
		if( !isset( $library ) || !array_key_exists( $library, self::$libraryPool ) )
			return self::$null;

		return self::$libraryPool[ $library ];
	}
	
	public function &addLibrary( $name = null, &$library = null )
	{
		if( !isset( $name ) || !isset( $library ) )
			return self::$null;

		self::$libraryPool[ $name ] = $library;

		return self::$libraryPool[ $name ];
	}

	public static function &instance()
	{
		if( is_null( self::$instance ) || 
			!( self::$instance instanceof PHPF_ObjectPool ) )
			self::$instance = new PHPF_ObjectPool();

		return self::$instance;
	}

}
