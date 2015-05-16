<?php namespace n3tw0rk\phpfeather\Libraries\Database\Drivers\Connection;

use n3tw0rk\phpfeather\Libraries\Database\Exceptions\Database as DatabaseException;
use n3tw0rk\phpfeather\Libraries\Database\Abstraction\Connection;

class Mongodb extends Connection
{
	/**
	 * Connect Method
	 *
	 * @throws DatabaseException
	 */
	public function connect()
	{
		if( !class_exists( 'MongoClient' ) )
		{
			throw new DatabaseException( MONGO_DB_NOT_INSTALLED );
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
	
	public function exec(){}

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