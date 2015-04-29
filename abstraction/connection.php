<?php namespace n3tw0rk\phpfeather\abstraction;

/**
 *	Connection Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Connection
{
	protected $host;
	protected $user;
	protected $pass;
	protected $data;
	protected $port;
	protected $extras;
	
	/** Connection Resource */
	protected $connection;
	
	/** Connected Flag */
	protected $connected = false;
	
	/** Database Instance */
	protected $databaseInstance = null;

	abstract public function connect();
	abstract public function disconnect();
	
	abstract public function exec();
	abstract public function query();
	abstract public function info();
	abstract public function error();
	abstract public function id();
	
	abstract public function escape( $string );
	
	public function __construct( $host = null, $user = null, 
		$pass = null, $data = null, $port = null, $extras = null )
	{
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->data = $data;
		$this->port = $port;
		$this->extras = $extras;
	}

	public function queryString()
	{
		require_once( 'helpers/utils.php' );

		$args = func_get_args();
		return forward_static_call_array( array( 'n3tw0rk\phpfeather\helpers\UTILS', 'qprintf' ), $args );
	}
	
	public function testConnection()
	{
		if( !$this->connected )
		{
			$this->connect();
		}
	}
}
