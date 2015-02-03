<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

require_once( 'helpers/utils.php' );

/**
 *	Connection
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_Connection
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
		$args = func_get_args();
		return forward_static_call_array( array( 'uk\co\n3tw0rk\phpfeather\helpers\PHPF_UTILS', 'qprintf' ), $args );
	}
	
	public function testConnection()
	{
		if( !$this->connected )
		{
			$this->connect();
		}
	}
}
