<?php namespace n3tw0rk\phpfeather\Helpers;

/**
 *	Rand Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Rand
{
	public static function hash()
	{
		return sha1( self::num() + '_' + self::num() + '_' + self::num() );
	}
	
	public static function num()
	{
		return mt_rand();
	}
}
