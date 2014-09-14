<?php

namespace uk\co\n3tw0rk\phpfeather\drivers\session;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstract/session.php' );

class PHPF_MemcachedDriver extends PHPF_Session
{

}
