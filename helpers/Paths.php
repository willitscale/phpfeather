<?php namespace n3tw0rk\phpfeather\Helpers;

use n3tw0rk\phpfeather\exceptions\ApplicationException;

/**
 *	Paths Helper
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Paths
{
	const EXT = '.php';
	
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

		throw new ApplicationException( INVALID_FILE_REQUESTED );
	}

	/**
	 * Application Method
	 * 
	 * @return String
	 */
	public static function application()
	{
		return $_SERVER[ 'DOCUMENT_ROOT' ];
	}
	
	/**
	 * Framework Method
	 * 
	 * @return String
	 */
	public static function framework()
	{
		return str_replace( 'Helpers', '', __DIR__ );
	}
}