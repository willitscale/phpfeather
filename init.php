<?php

error_reporting( E_ALL );

ini_set( 'display_errors', '1' );

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

define( 'FRAMEWORK_PATH', $_SERVER[ 'DOCUMENT_ROOT' ] . '/', true );

require_once( FRAMEWORK_PATH . 'config/constants.php' );
require_once( FRAMEWORK_PATH . 'config/local.php' );
require_once( FRAMEWORK_PATH . 'system/application.php' );
require_once( FRAMEWORK_PATH . 'system/debugging.php' );

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
			PHPF_Debugging:init();
			PHPF_Application::init();
		}
		catch( Exception $exception )
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
