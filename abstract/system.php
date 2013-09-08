<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	System
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_System
{

	public function __construct()
	{
		PHPF_Application::autoLoad( $this );
	}

	public function model( $model = null, $local = null )
	{
		if( is_null( $local ) )
			$local = strtolower( $model );
		$this->{$local} = PHPF_Application::getModel( $model );
	}

	public function library( $library = null, $local = null )
	{
		if( is_null( $local ) )
			$local = strtolower( $library );
		$this->{$local} = PHPF_Application::getLibrary( $library );
	}

	public function view( $view = null, &$params = array() )
	{
		return PHPF_Application::getView( $view, $params );
	}

	public function helper( $helper = null )
	{
		return PHPF_Application::getHelper( $helper );
	}
	
	public function render( $view = null, &$params = array() )
	{
		print( PHPF_Application::getView( $view, $params ) );
	}

}
