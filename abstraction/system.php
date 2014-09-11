<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;

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
	/**
	 *
	 */
	public function __construct()
	{
		SYSTEM\PHPF_Application::autoLoad( $this );
	}
	/**
	 * Model Method
	 *
	 * @param 
	 * @param 
	 * @return void
	 */
	public function model( $model = null, $local = null )
	{
		if( is_null( $local ) )
		{
			$local = strtolower( $model );
		}
		$this->{$local} = SYSTEM\PHPF_Application::getModel( $model );
	}

	public function library( $library = null, $local = null )
	{
		if( is_null( $local ) )
		{
			$local = strtolower( $library );
		}
		$this->{$local} = SYSTEM\PHPF_Application::getLibrary( $library );
	}

	public function view( $view = null, &$params = array() )
	{
		return SYSTEM\PHPF_Application::getView( $view, $params );
	}

	public function helper( $helper = null )
	{
		return SYSTEM\PHPF_Application::getHelper( $helper );
	}
	
	public function render( $view = null, &$params = array() )
	{
		print( SYSTEM\PHPF_Application::getView( $view, $params ) );
	}

}
