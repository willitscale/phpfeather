<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	Model Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Model extends System
{
	/**
	 * @access protected
	 * @var unknown
	 */
	protected $data = [];
	
	/**
	 * Constructor Sub-Routine
	 * 
	 * @access public
	 * @param Array $data
	 * @return void
	 */
	public function __construct( $data = [] )
	{
		parent::__construct();
	}

	/**
	 * Map Method
	 * 
	 * @access public
	 * @param Array $data
	 * @return void
	 */
	public function map( $data = [] )
	{
		if( empty( $data ) )
		{
			return;
		}

		foreach( $data AS $key => $value )
		{
			$this->$key = $value;
		}
	}
	
	/**
	 * Get Method
	 * 
	 * @access public
	 * @param String $key
	 * @return Mixed
	 */
	public function __get( $key )
	{
		return $this->data[ $key ];
	}
	
	/**
	 * Set Method
	 *  
	 * @access public
	 * @param String $key
	 * @param Mixed $value
	 * @return void
	 */
	public function __set( $key, $value )
	{
		$this->data[ $key ] = $value;
	}
}
