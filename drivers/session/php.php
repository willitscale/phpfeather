<?php

namespace uk\co\n3tw0rk\phpfeather\drivers\session;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstract/session.php' );

class PHPF_PhpDriver extends PHPF_Session
{
	
	public function start()
	{
		session_start();
	}
	
	public function exist( $key = null )
	{
		return array_key_exists( $key, $_SESSION );
	}
	
	public function get( $key = null )
	{
		if( $this->exist( $key ) )
		{
			return $_SESSION[ $key ];
		}
		return null;
	}
	
	public function set( $key = null, $value, $encrypt = false )
	{
		if( $encrypt )
		{
			$value = 'encryptedValue';
		}

		$_SESSION[ $key ] = $value;
	}
	
	public function delete( $key = null )
	{
		unset( $_SESSION[ $key ] );
	}
	
	public function destroy()
	{
		return session_destroy();
	}
	
	public function id()
	{
		return session_id();
	}

}
