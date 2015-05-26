<?php namespace n3tw0rk\phpfeather\Libraries\Database\Drivers\Connection;

use n3tw0rk\phpfeather\Libraries\Database\Abstraction\Connection;
use n3tw0rk\phpfeather\Libraries\Database\Exceptions\DatabaseException;
use n3tw0rk\phpfeather\Libraries\Database\Drivers\Results\MySQLi AS Results;

class MySQLi extends Connection
{
	/**
	 * Connect Method
	 *
	 * @throws DatabaseException
	 */
	public function connect()
	{
		if( !class_exists( 'mysqli' ) )
		{
			throw new DatabaseException( MYSQLI_NOT_INSTALLED );
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
		return new Results( $this->connection->query( 
			call_user_func_array( array( $this, 'queryString' ), $params ) ) );
	}
	
	public function exec()
	{
		$params = func_get_args();

		$table = array_shift( $params );
		
		if( !empty( $params ) )
		{
			$params = call_user_func_array( array( $this, 'queryString' ), $params );
		}
		else
		{
			$params = '';
		}

		$results = new \StdClass();

		$results->query = 'CALL ' . $table . '(' . $params . ');';

		$this->connection->multi_query( $results->query );

		$results->returned = array();

		do
		{
			$result = $this->connection->store_result();
			if( $result )
			{
				$multiResult = new Results( $result );
				$results->returned []= $multiResult->current();
				$result->free();
			}
		}
		while( $this->connection->more_results() &&
				$this->connection->next_result() );

		if( empty( $params ) )
		{
			$results->out = array();
		}
		else
		{
			$results->out = $this->query( 'SELECT ' . $params )->current();
		}

		return $results;
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
