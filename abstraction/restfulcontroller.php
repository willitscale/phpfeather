<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

require_once( 'abstraction/controller.php' );
require_once( 'abstraction/rest.php' );

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;


/**
 *	Controller
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_RestfulController extends PHPF_Controller
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
		$name = SYSTEM\PHPF_Application::getUrlParam( 2 );
		$id = SYSTEM\PHPF_Application::getUrlParam( 3 );
		$rest = SYSTEM\PHPF_Application::getRest( $name );

		if( empty( $_SERVER[ 'REQUEST_METHOD' ] ) )
		{
			// Throw Exception ?
		}

		$method = '_' . $_SERVER[ 'REQUEST_METHOD' ];

		$rest->$method( $id );
	}

	/**
	 * Default shell init method
	 */
	public function __init(){}
}
