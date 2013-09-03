<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'system/objectpool.php' );

include_once( 'abstract/controller.php' );
include_once( 'abstract/model.php' );
include_once( 'abstract/activedataobject.php' );

class Application
{

	private static $action;
	private static $controller;

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

	public static function init( $controller = null, $action = null )
	{

		Application::autoHelpers();
	
		$controller = Application::getControllerString( $controller );
	
		$object = Application::getController( $controller );

		unset( $controller );
		
		$action = Application::getActionString( $action );
		
		if( 1 == Application::canAccessAction( $object, $action ) )
			$object->$action();
		
		unset( $action );
		unset( $object );

	}
	
	public static function autoHelpers()
	{
		
		global $helpers;
		
		foreach( $helpers AS $helper )
			Application::getHelper( $helper );
	
	}
	
	public static function getControllerString( $controller = null )
	{

		if( isset( Application::$controller ) )
			return Application::$controller;
	
		if( is_null( $controller ) || 0 >= sizeof( $controller ) )
			$controller = Application::getUrlParam( 1 );

		if( is_null( $controller ) )
			$controller = DEFAULT_CONTROLLER;
		
		return ( Application::$controller = $controller );

	}
	
	public static function getActionString( $action = null )
	{

		if( isset( Application::$action ) )
			return Application::$action;

		if( is_null( $action ) )
			$action = Application::getUrlParam( 2 );

		if( is_null( $action ) )
			$action = DEFAULT_ACTION;
		
		return ( Application::$action = $action );

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
	
		if( in_array( $action, Application::$magicMethods ) )
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
		return ObjectPool::instance();
	}

	public function getPath( $formattedURI, $suffix )
	{
	
		if( file_exists( $path=sprintf( $formattedURI, './', $suffix ) ) )
			return $path;
	
		if( file_exists( $path=sprintf( $formattedURI, Application::basePath(), $suffix ) ) )
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

		$objectPool = Application::objectPool();

		if( !is_null( $objectPool->getLibrary( $library ) ) )
			return $objectPool->getLibrary( $library );

		
		$path = Application::getPath( LIBRARY_DIR, strtolower( $library ) );

		@include_once( $path );

		try
		{
			$object = new $library();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
				Application::exceptionHandler( $e );
			throw new Exception( sprintf( LIBRARY_NOT_EXIST, $library ) );
		}

		return $objectPool->addLibrary( $library, $object );

	}

	public static function &getModel( $model = null )
	{

		if( !isset( $model ) || is_null( $model ) )
			throw new Exception( INVALID_MODEL );

		$objectPool = Application::objectPool();

		if( !is_null( $objectPool->getModel( $model ) ) )
			return $objectPool->getModel( $model );

		$path = Application::getPath( MODEL_DIR, strtolower( $model ) );

		@include_once( $path );

		try
		{
			$object = new $model();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
				Application::exceptionHandler( $e );
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

		$path = Application::getPath( HELPER_DIR, strtolower( $helper ) );

		@include_once( $path );

	}

	public static function &getView( $view = null, &$flags = array() )
	{
		if( !isset( $view ) || is_null( $view ) )
			throw new Exception( INVALID_VIEW );

		$path = Application::getPath( VIEW_DIR, strtolower( $view ) );

		if( is_object( $flags ) )
			$flags = Application::objectToArray( $flags );

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

		$path = Application::getPath( CONTROLLER_DIR, strtolower( $controller ) );

		@include_once( $path );

		try
		{
			$object = new $controller();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
				Application::exceptionHandler( $e );
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
			$object->$key = Application::arrayToObject( $val );

		return $object;
	}

	public static function &objectToArray( $object )
	{
		$array = array();

		if( !is_object( $object ) )
			return $object;

		foreach( $object AS $key => $val )
			$array[ $key ] = Application::objectToArray( $val );

		return $array;
	}

	public static function getUrlParam( $param = 0 )
	{
		if( !isset( $param ) || 0 >= $param-- )
			return null;

		if( !is_array( Application::$urlParams ) )
		{
		
			global $mapping;
			
			$args = $_GET[ 'args' ];

			if( array_key_exists( $args, $mapping ) )
				$args = $mapping[ $args ];

			foreach( explode( '/', $args ) AS $val )
				if( '' !== $val )
					Application::$urlParams[] = $val;
		}

		unset( $args );
		
		if( !is_array( Application::$urlParams ) )
			Application::$urlParams = array();
		
		if( !array_key_exists( $param, Application::$urlParams ) )
			return null;

		return Application::$urlParams[ $param ];
	}

	public static function exceptionHandler(Exception $e)
	{
		printf( "<pre>LayerException : <br />\n%s\n%s</pre>", $e->getMessage(), $e->getTraceAsString() );
	}


}
