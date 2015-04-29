<?php namespace n3tw0rk\phpfeather\system;

require_once( 'config/constants.php' );
require_once( APPLICATION_PATH . 'config/local.php' );
require_once( 'system/application.php' );
require_once( 'system/debugging.php' );
require_once( 'exceptions/application.php' );

use n3tw0rk\phpfeather\exceptions\ApplicationException;
use n3tw0rk\phpfeather\system\Debugging;
use n3tw0rk\phpfeather\system\Application;

/**
 *	Init Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\system
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Init
{
	public function __construct()
	{
		self::init();
	}

	private static function init()
	{
		try
		{
			Debugging::init();
			Application::init();
		}
		catch( ApplicationException $exception )
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