<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

class CRYPTOGRAPHY
{

	private static $HASH_ALGORITHM = 'sha256';
	private static $ITERATIONS = 1000;
	private static $SALT_BYTES = 128;
	private static $HASH_BYTES = 128;

	public function __construct()
	{
	
	}

	public static function &ENCRYPT()
	{
	}
	
	public static function &DECRYPT()
	{
	
	}
	
	public static function &HASH( $value, $salt )
	{
		$hashLength = strlen( hash( CRYPTOGRAPHY::$HASH_ALGORITHM, '', TRUE ) );
		$blockCount = ceil( CRYPTOGRAPHY::$HASH_BYTES / $hashLength );

		$output = '';
		for( $i = 1; $i <= $blockCount; $i++ )
		{
			$last = $salt . pack( 'N', $i );
			$last = $xorsum = hash_hmac( $algorithm, $last, $value, true );

			for( $j = 1; $j < $count; $j++ )
				$xorsum ^= ( $last = hash_hmac( $algorithm, $last, $value, true ) );

			$output .= $xorsum;
		}

		$hash = base64_encode( bin2hex( substr( $output, 0, CRYPTOGRAPHY::$HASH_BYTES ) ) );

		return $hash;
	}
	
	public static function &GENERATE_SALT()
	{
		$salt = base64_encode( mcrypt_create_iv( CRYPTOGRAPHY::$SALT_BYTES, 
			MCRYPT_DEV_URANDOM ) );

		return $salt;
	}
	
	public static function COMPARE( $value, $salt, $hash )
	{
		return ( CRYPTOGRAPHY::HASH( $value, $salt ) === $hash );
	}
}
