<?php namespace n3tw0rk\phpfeather\Libraries\Database\Abstraction;

/**
 *	Results Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Libraries\Database\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Results implements \Countable, \Iterator
{
	const RESULT_OBJECT = 0x01;
	const RESULT_ARRAY = 0x02;
	const RESULT_ASSOC = 0x03;
	
	protected $resultSet;
	protected $position;
	protected $returnType;

	public function fetchArray()
	{
		$this->returnType = RESULT_ARRAY;
		return $this;
	}
	
	public function fetchObject()
	{
		$this->returnType = RESULT_OBJECT;
		return $this;
	}
	
	public function fetchAssoc()
	{
		$this->returnType = RESULT_ASSOC;
		return $this;
	}

}
