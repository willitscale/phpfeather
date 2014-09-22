<?php

namespace uk\co\n3tw0rk\phpfeather\drivers\connection;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstraction/connection.php' );
include_once( 'drivers/results/mongodb.php' );
include_once( 'exceptions/database.php' );

use uk\co\n3tw0rk\phpfeather\exceptions as EXCEPTIONS;
use uk\co\n3tw0rk\phpfeather\abstraction as ABSTRACTION;

class PHPF_MongodbDriver extends ABSTRACTION\PHPF_Connection
{
	protected $databaseInstance = null;

	public function connect()
	{
		if( !class_exists( 'MongoClient' ) )
		{
			throw new EXCEPTIONS\PHPF_DatabaseException( MONGO_DB_NOT_INSTALLED );
		}
		
		$connectionString = 'mongodb://';
		
		if( !empty( $this->user ) && !empty( $this->pass ) )
		{
			$connectionString .= $this->user . ':' . $this->pass . '@';
		}
		
		$connectionString .= $this->host;
		
		if( !empty( $this->port ) )
		{
			$connectionString .= ':' . $this->port;
		}

		if( !empty( $this->extr ) && is_array( $this->extr ) && array_key_exists( 'connection_string', $this->extr ) )
		{
			$connectionString = $this->extr[ 'connection_string' ];
		}
		
		try
		{
			$this->connection = new \MongoClient( $connectionString );
		}
		catch( Exception $exception )
		{
			throw new DatabaseException( INVALID_DB_CREDENTIALS );
		}
		
		try
		{
			$this->databaseInstance = $this->connection->selectDB( $this->data );
		}
		catch( Exception $exception )
		{
			throw new DatabaseException( DATABASE_NOT_EXISTS );
		}
		
		$this->connected = true;
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
		return $this->databaseInstance->command( $params );
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
		return null;
	}
	
	public function id()
	{
		return $this->connection->insert_id;
	}
}