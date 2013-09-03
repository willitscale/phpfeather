<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

class ObjectPool
{

	private static $instance = null;

	public static function &instance()
	{
		if( is_null( ObjectPool::$instance ) || 
			!( ObjectPool::$instance instanceof ObjectPool ) )
			ObjectPool::$instance = new ObjectPool();
		return ObjectPool::$instance;
	}

	private static $modelPool = array();
	private static $libraryPool = array();
	private static $null = null;

	private function __construct(){}
	private function __clone(){}

	public function &getModel( $model = null )
	{
		if( !isset( $model ) || is_null( $model ) || !array_key_exists( $model, ObjectPool::$modelPool ) )
			return ObjectPool::$null;
		return ObjectPool::$modelPool[ $model ];
	}
	
	public function &addModel( $name = null, &$model = null )
	{
		if( is_null( $name ) || !isset( $name ) || is_null( $model ) || !isset( $model ) || !( $model instanceof Model ) )
			return ObjectPool::$null;
		ObjectPool::$modelPool[ $name ] = $model;
		return ObjectPool::$modelPool[ $name ];
	}
	
	public function &getLibrary( $library = null )
	{
		if( !isset( $library ) || is_null( $library ) || !array_key_exists( $library, ObjectPool::$libraryPool ) )
			return ObjectPool::$null;
		return ObjectPool::$libraryPool[ $library ];
	}
	
	public function &addLibrary( $name = null, &$library = null )
	{
		if( is_null( $name ) || !isset( $name ) || is_null( $library ) || !isset( $library ) )
			return ObjectPool::$null;
		ObjectPool::$libraryPool[ $name ] = $library;
		return ObjectPool::$libraryPool[ $name ];
	}

}
