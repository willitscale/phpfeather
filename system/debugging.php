<?php namespace n3tw0rk\phpfeather\system;

/**
 *	Debugging Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\system
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Debugging
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
