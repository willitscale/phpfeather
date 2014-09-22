<?php

namespace uk\co\n3tw0rk\phpfeather\drivers\connection;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstraction/connection.php' );
include_once( 'drivers/results/mysqli.php' );

use uk\co\n3tw0rk\phpfeather\abstraction as ABSTRACTION;
use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;

class PHPF_MysqliDriver extends ABSTRACTION\PHPF_Connection
{
	public function connect()
	{
		if( !class_exists( 'mysqli' ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( MYSQLI_NOT_INSTALLED );
		}
		
		$this->connection = new \mysqli( $this->host, $this->user, 
			$this->pass, $this->data, $this->port );

		if( 0 !== @$this->connection->connect_errno )
		{
			throw new DatabaseException( INVALID_DB_CREDENTIALS );
		}
		else
		{
			$this->connected = true;
		}
	}

	public function disconnect()
	{
		if( $this->connected )
		{
			$this->connection->close();
		}
	}

	public function query()
	{
		$params = func_get_args();
		return new MysqliResults( $this->connection->query( 
			call_user_func_array( array( $this, 'queryString' ), $params ) ) );
	}

	public function info()
	{
		return $this->connection->info;
	}

	public function error()
	{
		return $this->connection->error;
	}
	
	public function escape( $string )
	{
		return $this->connection->real_escape_string( $string );
	}
	
	public function id()
	{
		return $this->connection->insert_id;
	}
}
