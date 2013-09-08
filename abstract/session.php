<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	Session
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_Session
{

	abstract public function start();
	
	abstract public function exist( $key = null );
	
	abstract public function get( $key = null );
	
	abstract public function set( $key = null, $value, $encrypt = false );
	
	abstract public function delete( $key = null );
	
	abstract public function destroy();
	
	abstract public function id();

}
