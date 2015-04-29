<?php namespace n3tw0rk\phpfeather\abstraction;

require_once( 'abstraction/controller.php' );
require_once( 'abstraction/rest.php' );

use n3tw0rk\phpfeather\system\Application;

/**
 *	Restful Controller Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class RestfulController extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Default HTTP init method
	 */
	public function init()
	{
		$name = Application::getUrlParam( 2 );
		$id = Application::getUrlParam( 3 );
		$rest = Application::getRest( $name );

		if( empty( $_SERVER[ 'REQUEST_METHOD' ] ) )
		{
			// TODO: Throw Exception
		}

		if( !empty( $id ) )
		{
			$rest->setID( $id );
		}

		$method = '_' . $_SERVER[ 'REQUEST_METHOD' ];

		$rest->$method( $id );
	}

	/**
	 * Default shell init method
	 */
	public function __init(){}
}
