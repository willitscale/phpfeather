<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

/**
 *	No SQL Connection
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_NoSQLConnection
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
			$this->connect();
	}

}

