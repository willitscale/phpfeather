<?php namespace n3tw0rk\phpfeather\System;

use n3tw0rk\phpfeather\Exceptions\ApplicationException;
use n3tw0rk\phpfeather\System\Debugging;
use n3tw0rk\phpfeather\System\Application;

/**
 *	Init Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\System
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
				printf( '<pre>%s</pre>', $exception->getMessage() );
				/*
		switch( APPLICATION_RELEASE )
		{
			case self::DEVELOPMENT : 
				printf( '<pre>%s</pre>', $exception->getMessage() );
				break;
	
			case self::TESTING : 
			case self::PRODUCTION : 
				include_once( 'static/html/404.html' );
				break;
		}
		*/
	}
}