<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/connection.php' );
include_once( 'drivers/results/mysqli.php' );

class MysqliDriver extends Connection
{

	private $host;
	private $user;
	private $pass;
	private $data;
	private $port;

	public function __construct( $host = 'localhost', $user = 'root', $pass = '', $data = '', $port = 3306 )
	{
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->data = $data;
		$this->port = $port;
	}

	public function connect()
	{
		$this->connection = new mysqli( $this->host, $this->user, $this->pass, $this->data, $this->port );
		if( 0 !== @$this->connection->connect_errno )
			throw new DatabaseException( INVALID_DB_CREDENTIALS );
	}

	public function disconnect()
	{
		$this->connection->close();
	}

	public function query()
	{
		$params = func_get_args();
		return new MysqliResults( $this->connection->query( call_user_func_array( array( $this, 'queryString' ), $params ) ) );
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
