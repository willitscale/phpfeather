<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	Results Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Results implements \Countable, \Iterator
{
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
