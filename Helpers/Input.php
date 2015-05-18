<?php namespace n3tw0rk\phpfeather\Helpers;

use n3tw0rk\phpfeather\system\Application;

/**
 *	Input Helper
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Input
{
	/**
	 * @access private
	 * @var unknown
	 */
	private static $urlParams = null;

	/**
	 * Terminal Method
	 * 
	 * @access public
	 * @return boolean
	 */
	public static function terminal()
	{
		return array_key_exists( 'TERM', $_SERVER );
	}

	/**
	 * Get Param Method
	 * 
	 * @access public
	 * @param number $param
	 * @return NULL|Ambigous <NULL, \n3tw0rk\phpfeather\helpers\unknown>
	 */
	public static function getParam( $param = 0 )
	{
		if( self::terminal() )
		{
			return self::getShellParam( $param );
		}
		else
		{
			return self::getUrlParam( $param );
		}
	}
	
	/**
	 * Get Shell Param Method
	 * 
	 * @access public
	 * @param number $param
	 * @return NULL
	 */
	public static function getShellParam( $param = 0 )
	{
		if( empty( $param ) )
		{
			return null;
		}
	
		if( $param >= $_SERVER[ 'argc' ] )
		{
			return null;
		}
	
		return $_SERVER[ 'argv' ][ $param ];
	}

	/**
	 * Get URL Param Method
	 * 
	 * @access public
	 * @param number $param
	 * @return NULL|\n3tw0rk\phpfeather\helpers\unknown
	 */
	public static function getUrlParam( $param = 0 )
	{
		if( empty( $param-- ) )
		{
			return null;
		}
	
		if( !is_array( self::$urlParams ) )
		{
	
			$routing = Application::getConfig( 'Routing' );
			
			$args = '';
	
			if( array_key_exists( 'u', $_GET ) )
			{
				$args = $_GET[ 'u' ];
			}
	
			foreach( $routing AS $from => $to )
			{
				if( preg_match( $from, $args ) )
				{
					$args = preg_replace( $from, $to, $args );
				}
			}
	
			foreach( explode( '/', $args ) AS $val )
			{
				if( '' !== $val )
				{
					self::$urlParams[] = $val;
				}
			}
		}
	
		unset( $args );
	
		if( !is_array( self::$urlParams ) )
		{
			self::$urlParams = [];
		}
	
		if( !array_key_exists( $param, self::$urlParams ) )
		{
			return null;
		}
	
		return self::$urlParams[ $param ];
	}
}