<?php namespace n3tw0rk\phpfeather\Libraries\Cookies\Drivers;

use n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies;

/**
 *	PHP Driver
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Cookies\Drivers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Browser extends Cookies
{

	public function exist( $key )
	{
		return array_key_exists( $key, $_COOKIE );
	}
	
	public function get( $key )
	{
		if( $this->exist( $key ) )
		{
			return $_COOKIE[ $key ];
		}

		return null;
	}
	
	public function set( $key, $value, $expiry = 0, $encrypt = null )
	{
		if( null == $expiry )
		{
			if( array_key_exists( 'expiry', $this->config ) )
			{
				$expiry = $this->config[ 'expiry' ];
			}
			else
			{
				$expiry = 0;
			}
		}

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

		setcookie( $key, $value, $expiry );
	}
	
	public function delete( $key = null )
	{
		unset( $_COOKIE[ $key ] );
		setcookie( $key, null, time() - 3600 );
	}
	
	public function destroy()
	{
	}
}
