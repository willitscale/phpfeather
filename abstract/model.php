<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/system.php' );

abstract class Model extends System
{

	public function __construct()
	{
		parent::__construct();
	}

}
