<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

class Rand
{

	public static function hash()
	{
		return sha1( Rand::num() + '_' + Rand::num() + '_' + Rand::num() );
	}
	
	public static function num()
	{
		return mt_rand();
	}

}
