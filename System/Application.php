<?php namespace n3tw0rk\phpfeather\System;

use n3tw0rk\phpfeather\Abstraction as Abstraction;
use n3tw0rk\phpfeather\Exceptions as Exception;
use n3tw0rk\phpfeather\Libraries\HTTP\Helpers as Helpers;

/**
 *	Application	Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\System
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Application
{
	const DEFAULT_CONTROLLER = 'Index';

	const DEFAULT_ACTION = 'init';

	const SHELL_DEFAULT_ACTION = '__init';

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

	/**
	 *	Init Method
	 *
	 *	@access public
	 *	@param String
	 *	@param String
	 */
	public static function init( $controller = null, $action = null )
	{
		self::base();
	
		$controller = self::getControllerString( $controller );
	
		$object = self::getController( $controller );

		unset( $controller );

		if( !( $object instanceof Abstraction\RestfulController ) )
		{
			$action = self::getActionString( $action );
		
			if( 1 == self::canAccessAction( $object, $action ) )
			{
				echo $object->$action();
			}
		}
		else
		{
			echo $object->init();
		}
		
		unset( $action );
		unset( $object );
	}
	
	protected static function base()
	{
		$config = self::getConfig( 'Application' );
		
		if( array_key_exists( 'namespace', $config ) )
		{
			$_SERVER[ 'APPLICATION_NS' ] = $config[ 'namespace' ] . '\\';
		}
	}
	
	/**
	 * Get Config Method
	 * 
	 * @param String $config
	 * @return Array
	 */
	public static function getConfig( $config )
	{
		$data = ObjectPool::getConfig( $config );
		
		if( !empty( $data ) )
		{
			return $data;
		}

		$path = Helpers\Paths::path( 'Config/' . $config );

		$data = require_once( $path );
		
		ObjectPool::addConfig( $config, $data );
		
		return $data;
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

		if( empty( $controller ) )
		{
			$controller = Helpers\Input::getParam( 1 );
		}

		// Don't permit invalid controller calls
		if( preg_match( '/[^A-Za-z0-9]+/', $controller ) )
		{
			$controller = null;
		}
		
		if( empty( $controller ) )
		{
			$controller = self::DEFAULT_CONTROLLER;
		}
		
		return ( self::$controller = $controller );
	}
	
	public static function getActionString( $action = null )
	{
		if( isset( self::$action ) )
		{
			return self::$action;
		}

		if( empty( $action ) )
		{
			$action = Helpers\Input::getParam( 2 );
		}

		// Don't permit invalid action calls
		if( preg_match( '/[^A-Za-z0-9]+/', $action ) )
		{
			$action = null;
		}

		if( empty( $action ) )
		{
			if( Helpers\Input::terminal() )
			{
				$action = self::SHELL_DEFAULT_ACTION;
			}
			else
			{
				$action = self::DEFAULT_ACTION;	
			}
		}

		return ( self::$action = $action );
	}
	
	public static function autoLoad( $instance = null )
	{
		if( !( $instance instanceof Abstraction\System ) )
		{
			return;
		}

		$autoload = self::getConfig( 'Autoload' );
		
		foreach( $autoload AS $local => $library )
		{
			$instance->library( $library, $local );
		}
	}
	
	public static function inject( $instance = null )
	{
		if( !( $instance instanceof Abstraction\Controller ) )
		{
			return;
		}

		$vial = self::getConfig( 'Injectors' );
		
		foreach( $vial AS $local => $worker )
		{
			$instance->worker( $worker, $local );
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
	
	/**
	 * Get Library Method
	 *
	 * @return uk\co\n3tw0rk\phpfeather\Abstraction\Library
	 */
	public static function &getLibrary( $library = null )
	{
		if( empty( $library ) )
		{
			throw new Exception\ApplicationException( INVALID_LIBRARY );
		}

		$object = ObjectPool::getLibrary( $library );

		if( !empty( $object ) )
		{
			return $object;
		}

		try
		{
			$object = new $library;
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
			{
				self::exceptionHandler( $e );
			}
			throw new Exception\ApplicationException( sprintf( LIBRARY_NOT_EXIST, $library ) );
		}

		return ObjectPool::addLibrary( $library, $object );
	}

	/**
	 * Get Model Method
	 * 
	 * @param string $model
	 * @throws Exception\ApplicationException
	 * @return Abstraction\Model
	 */
	public static function &getModel( $model = null )
	{
		if( empty( $model ) )
		{
			throw new Exception\ApplicationException( INVALID_MODEL );
		}

		try
		{
			$model = "n3tw0rk\\phpfeather\\Models\\" . $model;
			$object = new $model;
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
			{
				self::exceptionHandler( $e );
			}
			throw new Exception\ApplicationException( sprintf( MODEL_NOT_EXIST, $model ) );
		}

		if( !( $object instanceof Abstraction\Model ) )
		{
			throw new Exception\ApplicationException( INVALID_MODEL );
		}

		return $object;
	}

	/**
	 * Get Model Method
	 * 
	 * @param string $model
	 * @throws Exception\ApplicationException
	 * @return Abstraction\Model
	 */
	public static function &getWorker( $worker = null )
	{
		if( empty( $worker ) )
		{
			throw new Exception\ApplicationException( INVALID_WORKER );
		}

		$object = ObjectPool::getWorker( $worker );

		if( !empty( $object ) )
		{
			return $object;
		}


		$worker = $_SERVER[ 'APPLICATION_NS' ] . "Workers\\" . $worker;
		@$object = new $worker;
		
		
		if( empty( $object ) )
		{
			$worker = "n3tw0rk\\phpfeather\\Workers\\" . $worker;
			@$object = new $worker;
		}

		if( empty( $object ) ||
			!( $object instanceof Abstraction\Worker ) )
		{
			throw new Exception\ApplicationException( INVALID_WORKER );
		}

		return $object;
	}

	/**
	 * Get View Method
	 * 
	 * @param string $view
	 * @param unknown $flags
	 * @throws Exception\ApplicationException
	 * @return string
	 */
	public static function &getView( $view = null, &$flags = [] )
	{
		if( empty( $view ) )
		{
			throw new Exception\Application( INVALID_VIEW );
		}

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
		require( Helpers\Paths::path( 'Views/' . $view ) );
		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}

	public static function &getController( $controller = null )
	{
		if( empty( $controller ) )
		{
			throw new Exception\ApplicationException( INVALID_CONTROLLER );
		}

		$object = null;

		$controller = $_SERVER[ 'APPLICATION_NS' ] . "Controllers\\" . $controller;
		$object = new $controller;

		if( empty( $object ) )
		{
			$controller = "n3tw0rk\\phpfeather\\Controllers\\" . $controller;
			@$object = new $controller;
		}

		if( empty( $object ) || 
			!( $object instanceof Abstraction\Controller ) )
		{
			throw new Exception\ApplicationException( INVALID_CONTROLLER );
		}

		return $object;
	}

	public static function &getRest( $rest = null )
	{
		if( empty( $rest ) )
		{
			throw new Exception\ApplicationException( INVALID_REST ) ;
		}

		$path = self::getPath( REST_DIR, strtolower( $rest ) );

		require_once( $path );

		$object = null;

		try
		{
			$object  = new $rest;
		}
		catch( Exception $e )
		{
			if( APPLICATION_RELEASE == DEVELOPMENT )
			{
				self::exceptionHandler( $e );
			}

			throw new Exception\ApplicationException( sprintf( REST_NOT_EXIST, $controller ) );
		}

                if( !( $object instanceof Abstraction\Rest ) )
                {
                        throw new Exception\ApplicationException( INVALID_REST );
                }

                return $object;
	}

	public static function exceptionHandler( \Exception $e )
	{
		printf( "<pre>LayerException : <br />\n%s\n%s</pre>", $e->getMessage(), $e->getTraceAsString() );
	}
}
