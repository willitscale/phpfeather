<?php namespace n3tw0rk\phpfeather\Helpers;

/**
 *	Cryptogrpahy Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Cryptogrpahy
{
	const HASH_ALGORITHM = 'sha256';
	const ITERATIONS = 1000;
	const SALT_BYTES = 128;
	const HASH_BYTES = 128;

	public static function &encrypt()
	{
	}
	
	public static function &decrypt()
	{
	
	}
	
	public static function &hash( $value, $salt, $algorithm )
	{
		$hashLength = strlen( hash( self::HASH_ALGORITHM, '', TRUE ) );

		$blockCount = ceil( self::HASH_BYTES / $hashLength );

		$output = '';
		for( $i = 1; $i <= $blockCount; $i++ )
		{
			$last = $salt . pack( 'N', $i );
			$last = $xorsum = hash_hmac( $algorithm, $last, $value, true );

			for( $j = 1; $j < $count; $j++ )
				$xorsum ^= ( $last = hash_hmac( $algorithm, $last, $value, true ) );

			$output .= $xorsum;
		}

		$hash = base64_encode( bin2hex( substr( $output, 0, self::HASH_BYTES ) ) );

		return $hash;
	}
	
	public static function &salt( $bytes = self::SALT_BYTES )
	{
		$bytes = ( int ) $bytes;
	
		$salt = base64_encode( mcrypt_create_iv( $bytes, 
			MCRYPT_DEV_URANDOM ) );

		return $salt;
	}
	
	public static function compare( $value, $salt, $hash )
	{
		return ( self::hash( $value, $salt ) === $hash );
	}
}
