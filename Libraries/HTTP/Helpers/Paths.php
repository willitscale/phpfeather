<?php namespace n3tw0rk\phpfeather\Libraries\HTTP\Helpers;

use n3tw0rk\phpfeather\Exceptions\Application as ApplicationException;

/**
 *	Paths Helper
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\HTTP\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Paths
{
	const EXT = '.php';
	
	const INVALID_FILE_REQUESTED = 'Invalid File Requested';
	
	/**
	 * Path Method
	 * 
	 * @param String $file
	 * @throws ApplicationException
	 * @return String
	 */
	public static function path( $file )
	{
		if( file_exists( $path = self::application() . $file . self::EXT ) )
		{
			return $path;
		}

		if( file_exists( $path = self::framework() . $file . self::EXT ) )
		{
			return $path;
		}
		
		throw new ApplicationException( self::INVALID_FILE_REQUESTED );
	}

	/**
	 * Application Method
	 * 
	 * @return String
	 */
	public static function application()
	{
		return (@$_SERVER[ 'DOCUMENT_ROOT' ] ?: 
			(@$_SERVER[ 'PWD' ] ?: '.' )) . '/';
	}
	
	/**
	 * Domain Method
	 * 
	 * @return string
	 */
	public static function domain()
	{
		return $_SERVER[ 'HTTP_HOST' ]; 
	}
	
	/**
	 * URI Method
	 * 
	 * @return string
	 */
	public static function uri()
	{
		return $_SERVER[ 'REQUEST_SCHEME' ] . '://' . self::domain(); 
	}
	
	/**
	 * Framework Method
	 * 
	 * @return String
	 */
	public static function framework()
	{
		return __DIR__ . '/../../../';
	}
}
