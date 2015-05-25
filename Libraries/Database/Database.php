<?php namespace n3tw0rk\phpfeather\Libraries\Database;

use n3tw0rk\phpfeather\System\Application;
use n3tw0rk\phpfeather\Libraries\Database\Exceptions AS Exceptions;

/**
 *	Database Library
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Database
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Database
{
	const DB_EXCEPTION = 'n3tw0rk\\phpfeather\\Libraries\\Database\\Exceptions\\';
	const DB_CONNECTION = 'n3tw0rk\\phpfeather\\Libraries\\Database\\Drivers\\Connection\\';
	
	/**
	 * @access protected
	 * @var Array
	 */
	protected $instances = array();

	/**
	 * @access protected
	 * @var String
	 */
	protected $currentInstance;

	/**
	 * @access protected
	 * @var Array
	 */
	protected $validate = 
	[
		'driver'	=>	'DatabaseData',
		'user'		=>	'DatabaseUser',
		'pass'		=>	'DatabasePass',
		'data'		=>	'DatabaseData',
		'host'		=>	'DatabaseHost',
		'port'		=>	'DatabasePort',
		'test'		=>	'DatabaseTest',
		'extra'		=>	'DatabaseExtra',
	];
	
	public function __construct()
	{
		$this->init();
	}

	protected function init()
	{
		$database = Application::getConfig( 'Database' );

		foreach( $database AS $local => $attributes )
		{
			$this->createInstance( $local, $attributes );
		}
	}
	
	public function createInstance( $name = null, $attributes = [] )
	{
		if( empty( $name ) )
		{
			$name = 'default';
		}

		if( empty( $attributes ) || !is_array( $attributes ) )
		{
			throw new Exceptions\DatabaseAttributes();
		}

		foreach( $this->validate AS $key => $exception )
		{
			if( !array_key_exists( $key, $attributes ) )
			{
				$exception = self::DB_EXCEPTION . $exception;

				throw new $exception;
			}
		}

		try
		{
			$class = self::DB_CONNECTION . $attributes[ 'driver' ];

			$this->instances[ $name ] = new $class( $attributes );
		}
		catch( Exception $e )
		{
			throw new Exception\DatabaseDriver( $attributes[ 'driver' ] );
		}
		
		$this->currentInstance = $name;
		
		if( $attributes[ 'test' ] )
		{
			$this->testConnection();
		}
	}
	
	public function query()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( [ $this->instances[ $this->currentInstance ],
			'query' ], $params );
	}
	
	public function exec()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( [ $this->instances[ $this->currentInstance ],
			'exec' ], $params );
	}
	
	public function queryString()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( [ $this->instances[ $this->currentInstance ],
			'queryString' ], $params );
	}
	
	public function setCurrentInstance( $instanceName = null )
	{
		if( empty( $instanceName ) || 
			!array_key_exists( $instanceName ) )
		{
			return 0;
		}

		$this->currentInstance = $instanceName;
		
		return 1;
	}
	
	public function error()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( [ $this->instances[ $this->currentInstance ],
			'error' ], $params );
	}
	
	public function id()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( [ $this->instances[ $this->currentInstance ],
			'id' ], $params );
	}
	
	public function info()
	{
		$this->testConnection();
		$params = func_get_args();
		return call_user_func_array( [ $this->instances[ $this->currentInstance ],
			'info' ], $params );
	}
	
	public function testConnection()
	{
		$this->instances[ $this->currentInstance ]->testConnection();
	}

}