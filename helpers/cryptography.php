<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	CRYPTOGRAPHY
 *
 *	@version 0.0.1
 *	@package phpfeather\helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_CRYPTOGRAPHY
{

	private static $HASH_ALGORITHM = 'sha256';
	private static $ITERATIONS = 1000;
	private static $SALT_BYTES = 128;
	private static $HASH_BYTES = 128;

	public static function &ENCRYPT()
	{
	}
	
	public static function &DECRYPT()
	{
	
	}
	
	public static function &HASH( $value, $salt, $algorithm )
	{
		$hashLength = strlen( hash( self::$HASH_ALGORITHM, '', TRUE ) );

		$blockCount = ceil( self::$HASH_BYTES / $hashLength );

		$output = '';
		for( $i = 1; $i <= $blockCount; $i++ )
		{
			$last = $salt . pack( 'N', $i );
			$last = $xorsum = hash_hmac( $algorithm, $last, $value, true );

			for( $j = 1; $j < $count; $j++ )
				$xorsum ^= ( $last = hash_hmac( $algorithm, $last, $value, true ) );

			$output .= $xorsum;
		}

		$hash = base64_encode( bin2hex( substr( $output, 0, self::$HASH_BYTES ) ) );

		return $hash;
	}
	
	public static function &GENERATE_SALT( $bytes = self::$SALT_BYTES )
	{
		$bytes = ( int ) $bytes;
	
		$salt = base64_encode( mcrypt_create_iv( $bytes, 
			MCRYPT_DEV_URANDOM ) );

		return $salt;
	}
	
	public static function COMPARE( $value, $salt, $hash )
	{
		return ( self::HASH( $value, $salt ) === $hash );
	}
}
