<?php

namespace uk\co\n3tw0rk\phpfeather\system;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

require_once( 'system/objectpool.php' );

require_once( 'abstraction/controller.php' );
require_once( 'abstraction/model.php' );

require_once( 'exceptions/application.php' );

use uk\co\n3tw0rk\phpfeather\abstraction as ABSTRACTION;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

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
	/** */
	private static $action;
	
	/** */
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
		{
			$object->$action();
		}

		unset( $action );
		unset( $object );
	}
	
	public static function autoHelpers()
	{
		global $helpers;
		
		foreach( $helpers AS $helper )
		{
			self::getHelper( $helper );
		}
	}
	
	/**
	 * Get Controller String Method
	 *
	 * @param 
	 * @return void
	 */
	public static function getControllerString( $controller = null )
	{
		if( isset( self::$controller ) )
		{
			return self::$controller;
		}


		if( array_key_exists( 'TERM', $_SERVER ) || array_key_exists( 'TERM', $_SERVER ) )
		{
			if( empty( $controller ) )
			{
				$controller = self::getShellParam( 1 );
			}
		}
		else
		{
			if( empty( $controller ) )
			{
				$controller = self::getUrlParam( 1 );
			}
		}

		if( is_null( $controller ) )
		{
			$controller = DEFAULT_CONTROLLER;
		}
		
		return ( self::$controller = $controller );
	}
	
	public static function getActionString( $action = null )
	{
		if( isset( self::$action ) )
		{
			return self::$action;
		}

		if( array_key_exists( 'TERM', $_SERVER ) || array_key_exists( 'TERM', $_SERVER ) )
		{
			if( empty( $action ) )
			{
				$action = self::getShellParam( 2 );
			}

			if( empty( $action ) )
			{
				$action = SHELL_DEFAULT_ACTION;
			}
		}
		else
		{
			if( empty( $action ) )
			{
				$action = self::getUrlParam( 2 );
			}

			if( empty( $action ) )
			{
				$action = DEFAULT_ACTION;
			}
		}

		return ( self::$action = $action );
	}
	
	public static function autoLoad( $instance = null )
	{
		if( !( $instance instanceof ABSTRACTION\PHPF_System ) )
		{
			return 0;
		}

		global $autoload;
		
		foreach( $autoload AS $local => $library )
		{
			$instance->library( $library, $local );
		}
	}

	private static function canAccessAction( $controller = null, $action = null )
	{
		if( is_null( $controller ) || is_null( $action ) )
		{
			return 0;
		}

		if( in_array( $action, self::$magicMethods ) )
		{
			return 0;
		}

		if( !method_exists( $controller, $action ) )
		{
			return 0;
		}

		$reflection = new \ReflectionMethod( $controller, $action );
		if( $reflection->isPrivate() )
		{
			return 0;
		}

		return 1;
	}

	public static function &objectPool()
	{
		return PHPF_ObjectPool::instance();
	}

	public static function getPath( $formattedURI, $suffix )
	{

		if( file_exists( $path=sprintf( $formattedURI, sprintf( '%s/', APPLICATION_PATH ), $suffix ) ) )
		{
			return $path;	
		}

		if( file_exists( $path=sprintf( $formattedURI, sprintf( '%s/', PHP_FEATHER ), $suffix ) ) )
		{
			return $path;	
		}

		if( file_exists( $path=sprintf( $formattedURI, self::basePath(), $suffix ) ) )
		{
			return $path;
		}
		
		if( file_exists( $path=sprintf( $formattedURI, './', $suffix ) ) )
		{
			return $path;	
		}
		
		throw new EXCEPTIONS\PHPF_ApplicationException( INVALID_FILE_REQUESTED );
	}
	
	/**
	 * Base Path Method
	 *
	 * @return String
	 */
	public static function basePath()
	{
		return str_replace( DEFAULT_INDEX, '', $_SERVER[ 'SCRIPT_FILENAME' ] );
	}
	
	/**
	 * Base Path Method
	 *
	 * @return uk\co\n3tw0rk\phpfeather\abstraction\PHPF_Library
	 */
	public static function &getLibrary( $library = null )
	{
		if( empty( $library ) )
		{
			throw new EXCEPTIONS\PHPF_ApplicationException( INVALID_LIBRARY );
		}

		$objectPool = self::objectPool();
		
		if( !empty( $objectPool->getLibrary( $library ) ) )
		{
			return $objectPool->getLibrary( $library );
		}
		
		$path = self::getPath( LIBRARY_DIR, strtolower( $library ) );

		include_once( $path );
		
		$library = LIBRARY_PREFIX . $library;
		
		try
		{
			$object = new $library();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
			{
				self::exceptionHandler( $e );
			}
			throw new EXCEPTIONS\PHPF_ApplicationException( sprintf( LIBRARY_NOT_EXIST, $library ) );
		}

		return $objectPool->addLibrary( $library, $object );
	}

	public static function &getModel( $model = null )
	{
		if( empty( $model ) )
		{
			throw new PHPF_ApplicationException( INVALID_MODEL );
		}

		$objectPool = self::objectPool();

		if( !is_null( $objectPool->getModel( $model ) ) )
		{
			return $objectPool->getModel( $model );
		}

		$path = self::getPath( MODEL_DIR, strtolower( $model ) );

		require_once( $path );

		try
		{
			$object = new $model();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
			{
				self::exceptionHandler( $e );
			}
			throw new EXCEPTIONS\PHPF_ApplicationException( sprintf( MODEL_NOT_EXIST, $controller ) );
		}

		if( !( $object instanceof ABSTRACTION\PHPF_Model ) )
		{
			throw new EXCEPTIONS\PHPF_ApplicationException( INVALID_MODEL );
		}

		return $objectPool->addModel( $model, $object );
	}
	
	public static function getHelper( $helper )
	{

		if( empty( $helper ) )
		{
			throw new EXCEPTIONS\PHPF_ApplicationException( INVALID_HELPER );
		}

		$path = self::getPath( HELPER_DIR, strtolower( $helper ) );

		include_once( $path );
	}

	public static function &getView( $view = null, &$flags = array() )
	{
		if( empty( $view ) )
		{
			throw new EXCEPTIONS\PHPF_ApplicationException( INVALID_VIEW );
		}

		$path = self::getPath( VIEW_DIR, strtolower( $view ) );

		if( is_object( $flags ) )
		{
			$flags = self::objectToArray( $flags );
		}

		if( isset( $flags ) && is_array( $flags ) )
		{
			foreach( $flags AS $key => $val )
			{
				$$key = $val;
			}
		}

		ob_start();
		include( $path );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public static function &getController( $controller = null )
	{
		if( !isset( $controller ) || is_null( $controller ) )
		{
			throw new PHPF_ApplicationException( INVALID_CONTROLLER );
		}

		$path = self::getPath( CONTROLLER_DIR, strtolower( $controller ) );

		include_once( $path );

		try
		{
			$object = new $controller();
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
			{
				self::exceptionHandler( $e );
			}
			throw new PHPF_ApplicationException( sprintf( CONTROLLER_NOT_EXIST, $controller ) );
		}

		if( !( $object instanceof ABSTRACTION\PHPF_Controller ) )
		{
			throw new EXCEPTIONS\PHPF_ApplicationException( INVALID_CONTROLLER );
		}

		return $object;
	}

	public static function &arrayToObject( $array )
	{
		$object = new stdClass;

		if( !is_array( $array ) )
		{
			return $array;
		}

		foreach( $array AS $key => $val )
		{
			$object->$key = self::arrayToObject( $val );
		}

		return $object;
	}

	public static function &objectToArray( $object )
	{
		$array = array();

		if( !is_object( $object ) )
		{
			return $object;
		}

		foreach( $object AS $key => $val )
		{
			$array[ $key ] = self::objectToArray( $val );
		}

		return $array;
	}
	
	public static function getShellParam( $param = 0 )
	{
		if( empty( $param ) )
		{
			return null;
		}

		if( $param >= $_SERVER[ 'argc' ] )
		{
			return null;
		}

		return $_SERVER[ 'argv' ][ $param ];
	}

	public static function getUrlParam( $param = 0 )
	{
		if( empty( $param-- ) )
		{
			return null;
		}

		if( !is_array( self::$urlParams ) )
		{
		
			global $mapping;
			
			$args = '';

			if( array_key_exists( 'u', $_GET ) )
			{
				$args = $_GET[ 'u' ];
			}

			foreach( $mapping AS $from => $to )
			{
				if( false !== stripos( $args, $from ) )
				{
					$args = str_ireplace( $from, $to, $args );
				}
			}

			foreach( explode( '/', $args ) AS $val )
			{
				if( '' !== $val )
				{
					self::$urlParams[] = $val;
				}
			}
		}

		unset( $args );
		
		if( !is_array( self::$urlParams ) )
		{
			self::$urlParams = array();
		}
		
		if( !array_key_exists( $param, self::$urlParams ) )
		{
			return null;
		}

		return self::$urlParams[ $param ];
	}

	public static function exceptionHandler(Exception $e)
	{
		printf( "<pre>LayerException : <br />\n%s\n%s</pre>", $e->getMessage(), $e->getTraceAsString() );
	}


}
