<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/session.php' );

class PHPF_CookieDriver extends PHPF_Session
{

}
