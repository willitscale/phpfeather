<?php

namespace uk\co\n3tw0rk\phpfeather\system;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

class PHPF_Debugging
{

	public static function init()
	{
		if( !defined( 'APPLICATION_RELEASE' ) )
		{
			die( 'ENVIRONMENT NOT DEFINED!' );
		}

		switch( APPLICATION_RELEASE )
		{
		        case TESTING :
		        {
		                error_reporting( E_ALL | ~E_NOTICE | ~E_WARNING );
		                ini_set( 'display_errors', '1' );
		                break;
		        }
		        case PRODUCTION :
		        {
		        	    error_reporting( ~E_ALL );
		                ini_set( 'display_errors', '0' );
		                break;
		        }
		        case DEVELOPMENT :
		        default :
		        {
		                error_reporting( E_ALL );
		                ini_set( 'display_errors', '1' );
		                break;
		        }
		}
	}

}
