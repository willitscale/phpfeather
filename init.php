<?php

namespace uk\co\n3tw0rk\phpfeather;

error_reporting( E_ALL );

ini_set( 'display_errors', '1' );

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

require_once( 'config/constants.php' );

require_once( APPLICATION_PATH . 'config/local.php' );

require_once( 'system/application.php' );

require_once( 'system/debugging.php' );

require_once( 'exceptions/application.php' );

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

( new PHPF_INIT() );

class PHPF_INIT
{
	public function __construct()
	{
		self::init();
	}

	private static function init()
	{
		try
		{
			SYSTEM\PHPF_Debugging::init();
			SYSTEM\PHPF_Application::init();
		}
		catch( EXCEPTIONS\PHPF_ApplicationException $exception )
		{
			self::debug( $exception );
		}
		catch( \Exception $exception )
		{
			self::debug( $exception );
		}
	}

	private static function debug( $exception )
	{
		switch( APPLICATION_RELEASE )
		{
			case DEVELOPMENT : 
				printf( '<pre>%s</pre>', $exception->getMessage() );
				break;
	
			case TESTING : 
			case PRODUCTION : 
				include_once( 'static/html/404.html' );
				break;
		}
	}
}
