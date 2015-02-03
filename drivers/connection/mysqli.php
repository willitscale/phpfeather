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
use uk\co\n3tw0rk\phpfeather\drivers\results AS RESULTS;

class PHPF_MysqliDriver extends ABSTRACTION\PHPF_Connection
{

	/**
	 * Connect Method
	 *
	 * @throws PHPF_DatabaseException
	 */
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
			throw new EXCEPTIONS\PHPF_DatabaseException( INVALID_DB_CREDENTIALS );
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
		return new RESULTS\PHPF_MysqliResults( $this->connection->query( 
			call_user_func_array( array( $this, 'queryString' ), $params ) ) );
	}
	
	public function exec()
	{
		$params = func_get_args();

		$table = array_shift( $params );
		$params = call_user_func_array( array( $this, 'queryString' ), $params );

		$results = new \StdClass();
		$results->out = array();
		$results->returned = array();
		$results->query = 'CALL ' . $table . '(' . $params . ');';

		$this->connection->multi_query( $results->query );

		do
		{
			$result = $this->connection->store_result();
			if( $result )
			{
				$multiResult = new RESULTS\PHPF_MysqliResults( $result );
				$results->returned []= $multiResult->current();
				$result->free();
			}
		}
		while( $this->connection->more_results() &&
				$this->connection->next_result() );

		$results->out = $this->query( 'SELECT ' . $params )->current();

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
