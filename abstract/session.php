<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

abstract class Session
{

	abstract public function start();
	
	abstract public function exist( $key = null );
	
	abstract public function get( $key = null );
	
	abstract public function set( $key = null, $value, $encrypt = false );
	
	abstract public function delete( $key = null );
	
	abstract public function destroy();
	
	abstract public function id();

}
