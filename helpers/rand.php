<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	RAND
 *
 *	@version 0.0.1
 *	@package phpfeather\helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_RAND
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
