<?php namespace n3tw0rk\phpfeather\Libraries\Database\Abstraction;

/**
 *	Connection Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Database\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Connection
{
	const SANITIZER = 'n3tw0rk\\phpfeather\\Libraries\\Database\\Helpers\\Sanitizer';

	protected $host;
	protected $user;
	protected $pass;
	protected $data;
	protected $port;
	protected $extra;
	
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

	/**
	 * Constructor Sub-Routine
	 * 
	 * @param array
	 * @return void
	 */
	public function __construct( $attr = [] )
	{
		$this->host = $attr[ 'host' ];
		$this->user = $attr[ 'user' ];
		$this->pass = $attr[ 'pass' ];
		$this->data = $attr[ 'data' ];
		$this->port = $attr[ 'port' ];
		$this->extra = $attr[ 'extra' ];
	}

	/**
	 * Query String Method
	 * 
	 * @access public
	 * @return String
	 */
	public function queryString()
	{
		$args = func_get_args();
		return forward_static_call_array( array( self::SANITIZER, 'qprintf' ), $args );
	}

	/**
	 * Test Connection Method
	 * 
	 * @access public
	 * @return void
	 */
	public function testConnection()
	{
		if( !$this->connected )
		{
			$this->connect();
		}
	}
}
