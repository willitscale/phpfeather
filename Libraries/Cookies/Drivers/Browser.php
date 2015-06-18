<?php namespace n3tw0rk\phpfeather\Libraries\Cookies\Drivers;

use n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies;

/**
 *	Browser Driver
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Cookies\Drivers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Browser extends Cookies
{
	/**
	 * (non-PHPdoc)
	 * @see \n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies::exist()
	 */
	public function exist( $key )
	{
		return array_key_exists( $key, $_COOKIE );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies::get()
	 */
	public function get( $key )
	{
		if( $this->exist( $key ) )
		{
			return $_COOKIE[ $key ];
		}

		return null;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies::set()
	 */
	public function set( $key, $value, $expiry = 0, $path = null, $encrypt = null )
	{
		if( null == $expiry )
		{
			if( array_key_exists( 'expiry', $this->config ) )
			{
				$expiry = $this->config[ 'expiry' ];
			}
			else
			{
				// 1 Year
				$expiry = 31536000;
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

		if( empty( $path ) )
		{
			$path = $this->config[ 'path' ];
		}
		
		setcookie( $key, $value, time() + $expiry, $path );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies::delete()
	 */
	public function delete( $key = null, $path = null )
	{
		if( empty( $path ) )
		{
			$path = $this->config[ 'path' ];
		}

		if( !isset( $key ) )
		{
			return;
		}

		unset( $_COOKIE[ $key ] );
		
		setcookie( $key, null, time() - 3600, $this->config[ 'path' ] );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \n3tw0rk\phpfeather\Libraries\Cookies\Abstraction\Cookies::destroy()
	 */
	public function destroy( $path = null )
	{
		$all = array_keys( $_COOKIE );

		foreach( $all AS $key )
		{
			$this->delete( $key, $path );
		}
	}
}
