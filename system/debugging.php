<?php namespace uk\co\n3tw0rk\phpfeather\system;

class PHPF_Debugging
{
	public static function init()
	{
		if( !defined( 'APPLICATION_RELEASE' ) )
		{
			define( 'APPLICATION_RELEASE', DEVELOPMENT );
		}

		$reporting = E_ALL | ~E_NOTICE | ~E_WARNING;
		$display = '1';
		
		switch( APPLICATION_RELEASE )
		{
	        case PRODUCTION :
	        {
	                $reporting = E_ALL;
	                ini_set( 'display_errors', '0' );
	                break;
	        }
	        case TESTING :
	        {
	                error_reporting(  );
	                ini_set( 'display_errors', '1' );
	                break;
	        }
	        case DEVELOPMENT :
	        default :
	        {
	                $reporting = E_ALL;
	                break;
			}
		}
	}
}
