<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'system/objectpool.php' );
include_once( 'abstract/controller.php' );
include_once( 'abstract/model.php' );
include_once( 'abstract/activedataobject.php' );

/**
 *	Application	
 *
 *	@version 0.0.1
 *	@package phpfeather\system
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_Application
{

	private static $action;
	private static $controller;

	/**
	 *	List of Magic Methods
	 *
	 *	@access private
	 *	@var Array
	 */
	private static $magicMethods = array( 
		'__construct', 
		'__destruct', 
		'__call', 
		'__callStatic', 
		'__get', 
		'__set', 
		'__isset', 
		'__unset', 
		'__sleep', 
		'__wakeup', 
		'__toString', 
		'__invoke', 
		'__set_state', 
		'__clone' );

	private static $urlParams = null;

	/**
	 *	Init Method
	 *
	 *	@access public
	 *	@param String
	 *	@param String
	 */
	public static function init( $controller = null, $action = null )
	{
		self::autoHelpers();
	
		$controller = self::getControllerString( $controller );
	
		$object = self::getController( $controller );

		unset( $controller );
		
		$action = self::getActionString( $action );
		
		if( 1 == self::canAccessAction( $object, $action ) )
			$object->$action();
		
		unset( $action );
		unset( $object );
	}
	
	public static function autoHelpers()
	{
		
		global $helpers;
		
		foreach( $helpers AS $helper )
			self::getHelper( $helper );
	
	}
	
	public static function getControllerString( $controller = null )
	{

		if( isset( self::$controller ) )
			return self::$controller;
	
		if( is_null( $controller ) || 0 >= sizeof( $controller ) )
			$controller = self::getUrlParam( 1 );

		if( is_null( $controller ) )
			$controller = DEFAULT_CONTROLLER;
		
		return ( self::$controller = $controller );

	}
	
	public static function getActionString( $action = null )
	{

		if( isset( self::$action ) )
			return self::$action;

		if( is_null( $action ) )
			$action = self::getUrlParam( 2 );

		if( is_null( $action ) )
			$action = DEFAULT_ACTION;
		
		return ( self::$action = $action );

	}
	
	public static function autoLoad( $instance = null )
	{

		if( !( $instance instanceof System ) )
			return 0;
		
		global $autoload;
		
		foreach( $autoload AS $local => $library )
			$instance->library( $library, $local );

	}

	private static function canAccessAction( $controller = null, $action = null )
	{

		if( is_null( $controller ) || is_null( $action ) )
			return 0;
	
		if( in_array( $action, self::$magicMethods ) )
			return 0;

		if( !method_exists( $controller, $action ) )
			return 0;

		$reflection = new ReflectionMethod( $controller, $action );
		if( $reflection->isPrivate() )
			return 0;

		return 1;
	}

	public static function &objectPool()
	{
		return PHPF_ObjectPool::instance();
	}

	public function getPath( $formattedURI, $suffix )
	{
	
		if( file_exists( $path=sprintf( $formattedURI, './', $suffix ) ) )
			return $path;
	
		if( file_exists( $path=sprintf( $formattedURI, self::basePath(), $suffix ) ) )
			return $path;

		if( file_exists( $path=sprintf( $formattedURI, sprintf( '%s/', FRAMEWORK_PATH ), $suffix ) ) )
			return $path;

		throw new Exception( INVALID_FILE_REQUESTED );

	}
	
	public static function basePath()
	{
		return str_replace( DEFAULT_INDEX, '', $_SERVER[ 'SCRIPT_FILENAME' ] );
	}

	public static function &getLibrary( $library = null )
	{

		if( !isset( $library ) || is_null( $library ) )
			throw new Exception( INVALID_LIBRARY );

		$objectPool = self::objectPool();

		if( !is_null( $objectPool->getLibrary( $library ) ) )
			return $objectPool->getLibrary( $library );

		
		$path = self::getPath( LIBRARY_DIR, strtolower( $library ) );

		@include_once( $path );

		try
		{
			$object = new $library();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
				self::exceptionHandler( $e );
			throw new Exception( sprintf( LIBRARY_NOT_EXIST, $library ) );
		}

		return $objectPool->addLibrary( $library, $object );

	}

	public static function &getModel( $model = null )
	{

		if( !isset( $model ) || is_null( $model ) )
			throw new Exception( INVALID_MODEL );

		$objectPool = self::objectPool();

		if( !is_null( $objectPool->getModel( $model ) ) )
			return $objectPool->getModel( $model );

		$path = self::getPath( MODEL_DIR, strtolower( $model ) );

		@include_once( $path );

		try
		{
			$object = new $model();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
				self::exceptionHandler( $e );
			throw new Exception( sprintf( MODEL_NOT_EXIST, $controller ) );
		}

		if( !( $object instanceof Model ) )
			throw new Exception( INVALID_MODEL );

		return $objectPool->addModel( $model, $object );

	}
	
	public static function getHelper( $helper )
	{

		if( !isset( $helper ) || is_null( $helper ) )
			throw new Exception( INVALID_HELPER );

		$path = self::getPath( HELPER_DIR, strtolower( $helper ) );

		@include_once( $path );

	}

	public static function &getView( $view = null, &$flags = array() )
	{
		if( !isset( $view ) || is_null( $view ) )
			throw new Exception( INVALID_VIEW );

		$path = self::getPath( VIEW_DIR, strtolower( $view ) );

		if( is_object( $flags ) )
			$flags = self::objectToArray( $flags );

		if( isset( $flags ) && is_array( $flags ) )
			foreach( $flags AS $key => $val )
				$$key = $val;

		ob_start();
		include( $path );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public static function &getController( $controller = null )
	{
	
		if( !isset( $controller ) || is_null( $controller ) )
			throw new Exception( INVALID_CONTROLLER );

		$path = self::getPath( CONTROLLER_DIR, strtolower( $controller ) );

		@include_once( $path );

		try
		{
			$object = new $controller();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
				self::exceptionHandler( $e );
			throw new Exception( sprintf( CONTROLLER_NOT_EXIST, $controller ) );
		}

		if( !( $object instanceof Controller ) )
			throw new Exception( INVALID_CONTROLLER );

		return $object;
	}

	public static function &arrayToObject( $array )
	{
		$object = new stdClass;

		if( !is_array( $array ) )
			return $array;

		foreach( $array AS $key => $val )
			$object->$key = self::arrayToObject( $val );

		return $object;
	}

	public static function &objectToArray( $object )
	{
		$array = array();

		if( !is_object( $object ) )
			return $object;

		foreach( $object AS $key => $val )
			$array[ $key ] = self::objectToArray( $val );

		return $array;
	}

	public static function getUrlParam( $param = 0 )
	{
		if( !isset( $param ) || 0 >= $param-- )
			return null;

		if( !is_array( self::$urlParams ) )
		{
		
			global $mapping;
			
			$args = $_GET[ 'args' ];

			if( array_key_exists( $args, $mapping ) )
				$args = $mapping[ $args ];

			foreach( explode( '/', $args ) AS $val )
				if( '' !== $val )
					self::$urlParams[] = $val;
		}

		unset( $args );
		
		if( !is_array( self::$urlParams ) )
			self::$urlParams = array();
		
		if( !array_key_exists( $param, self::$urlParams ) )
			return null;

		return self::$urlParams[ $param ];
	}

	public static function exceptionHandler(Exception $e)
	{
		printf( "<pre>LayerException : <br />\n%s\n%s</pre>", $e->getMessage(), $e->getTraceAsString() );
	}


}
