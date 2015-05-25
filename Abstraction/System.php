<?php namespace n3tw0rk\phpfeather\Abstraction;

use n3tw0rk\phpfeather\System\Application;

/**
 *	System Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class System
{
	protected $params = [];
	
	/**
	 * Constructor Sub-Routine
	 */
	public function __construct()
	{
		Application::autoLoad( $this );
	}

	/**
	 * Model Method
	 *
	 * @param String
	 * @param String
	 * @return void
	 */
	public function model( $model = null, $local = null )
	{
		if( empty( $local ) )
		{
			$local = strtolower( $model );
		}

		$this->{$local} = Application::getModel( $model );
	}

	/**
	 * Library Method
	 *
	 * @param String
	 * @param String
	 * @return void
	 */
	public function library( $library = null, $local = null )
	{
		if( empty( $local ) )
		{
			$local = strtolower( $library );
		}

		$this->{$local} = Application::getLibrary( $library );
	}

	/**
	 * Worker Method
	 *
	 * @param String
	 * @param String
	 * @return void
	 */
	public function worker( $worker = null, $local = null )
	{
		if( empty( $local ) )
		{
			$local = $worker;
		}

		$this->{$local} = Application::getWorker( $worker );
	}

	/**
	 * View Method
	 *
	 * @param String
	 * @param String
	 * @return String
	 */
	public function view( $view = null, &$params = [] )
	{
		if( empty( $params ) )
		{
			$params = $this->params;
		}
		
		return Application::getView( $view, $params );
	}

	/**
	 * Render Method
	 *
	 * @param String
	 * @param Array
	 * @return void
	 */
	public function render( $view = null, &$params = [] )
	{
		if( !is_array( $params ) )
		{
			$params = $this->params;
		}

		$params = array_merge( $this->params, $params );
		
		print( Application::getView( $view, $params ) );
	}
}

