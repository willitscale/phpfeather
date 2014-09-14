<?php

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstract/nosqlconnection.php' );

class PHPF_MongoDBDriver extends PHPF_NoSQLConnection
{

	public function __construct()
	{
	}

	public function connect()
	{
	}

	public function disconnect()
	{
	}

	public function query()
	{
	}

	public function info()
	{
	}

	public function error()
	{
	}
	
	public function id()
	{
	}

}
