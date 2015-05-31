<?php namespace n3tw0rk\phpfeather\Libraries\Sessions\Drivers;

use n3tw0rk\phpfeather\Libraries\Sessions\Abstraction\Session;

/**
 *	PHP Driver
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Sessions\Drivers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHP extends Session
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
	
	public function set( $key = null, $value, $encrypt = null )
	{
		if( null == $encrypt )
		{
			if( array_key_exists( 'encrypt', $this->config ) )
			{
				$encrypt = $this->config[ 'encrypt' ];
			}
			else
			{
				$encrypt = false;
			}
		}
		
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
