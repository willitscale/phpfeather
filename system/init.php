<?php namespace uk\co\n3tw0rk\phpfeather\system;

require_once( 'config/constants.php' );
require_once( APPLICATION_PATH . 'config/local.php' );
require_once( 'system/application.php' );
require_once( 'system/debugging.php' );
require_once( 'exceptions/application.php' );

use uk\co\n3tw0rk\phpfeather\exceptions\PHPF_ApplicationException;
use uk\co\n3tw0rk\phpfeather\system\PHPF_Debugging;
use uk\co\n3tw0rk\phpfeather\system\PHPF_Application;

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
			PHPF_Debugging::init();
			PHPF_Application::init();
		}
		catch( PHPF_ApplicationException $exception )
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