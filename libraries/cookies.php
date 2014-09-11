<?php

namespace uk\co\n3tw0rk\phpfeather\libraries;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

class PHPF_Cookies
{

	public function __construct()
	{
	
		$this->init();
	
	}
	
	public function init()
	{
		global $cookie;
	}
	
	public function get( $key = null )
	{
	
	}
	
	public function set( $key = null, $value, $expiry = DAY )
	{
	
	}
	
	public function delete( $key = null )
	{
	}
	
	public function destroy()
	{
	}
	
	public function encrypt( $data, $type )
	{
	}
	
	public function compress( $data )
	{
	
	}

}
