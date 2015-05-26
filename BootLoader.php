<?php namespace n3tw0rk\phpfeather;

spl_autoload_register( function( $class )
{
	if( BootLoader::application( $class ) )
	{
		return;
	}
	
	BootLoader::framework( $class );
} );

/**
 * Boot Loader Class
 * 
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class BootLoader
{
	const FRAMEWORK_NS = 'n3tw0rk\\phpfeather\\';
	
	public static function application( $class )
	{
		if( empty( $_SERVER[ 'APPLICATION_NS' ] ) )
		{
			return false;
		}

		return self::load( $class, $_SERVER[ 'APPLICATION_NS' ], 
			$_SERVER[ 'DOCUMENT_ROOT' ] );
	}
	
	public static function framework( $class )
	{
		return self::load( $class, self::FRAMEWORK_NS,  __DIR__ . '/' );
	}
	
	protected static function load( $class, $namespace, $directory )
	{
		$size = strlen( $namespace );

		if( 0 !== strncmp( $namespace, $class, $size ) )
		{
			return false;
		}

		$relative = substr( $class, $size );
		
		$file = $directory . '/' . str_replace( '\\', '/', $relative ) . '.php';

		if( file_exists( $file ) )
		{
			require_once( $file );
			return true;
		}

		return false;
	}
}
