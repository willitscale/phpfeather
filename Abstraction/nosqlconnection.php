<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	No SQL Connection Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class NoSQLConnection
{
	protected $connection;
	protected $connected = false;

	abstract public function connect();
	abstract public function disconnect();
	
	abstract public function query();
	abstract public function info();
	abstract public function error();
	abstract public function id();
	
	public function testConnection()
	{
		if( !$this->connected )
		{
			$this->connect();
		}
	}
}

