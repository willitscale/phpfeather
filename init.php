<?php

error_reporting( E_ALL );
ini_set( 'display_errors', '1' );

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

@include_once( 'config/constants.php' );
@include_once( 'config/local.php' );
@include_once( 'system/application.php' );

switch( APPLICATION_RELEASE )
{

	case TESTING :
	case PRODUCTION :
		error_reporting( ~E_ALL );
		break;

	case DEVELOPMENT :
		break;

	default :
		error_reporting( E_ALL );
		ini_set( 'display_errors', '1' );
		trigger_error( 'Unable to access application.', E_USER_ERROR );
		break;
}

try
{
	Application::init();
}
catch( Exception $exception )
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
