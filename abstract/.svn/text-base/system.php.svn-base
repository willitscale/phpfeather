<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

abstract class System
{

	public function __construct()
	{
		Application::autoLoad( $this );
	}

	public function model( $model = null, $local = null )
	{
		if( is_null( $local ) )
			$local = strtolower( $model );
		$this->{$local} = Application::getModel( $model );
	}

	public function library( $library = null, $local = null )
	{
		if( is_null( $local ) )
			$local = strtolower( $library );
		$this->{$local} = Application::getLibrary( $library );
	}

	public function view( $view = null, &$params = array() )
	{
		return Application::getView( $view, $params );
	}

	public function helper( $helper = null )
	{
		return Application::getHelper( $helper );
	}
	
	public function render( $view = null, &$params = array() )
	{
		print( Application::getView( $view, $params ) );
	}

}
