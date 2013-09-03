<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

abstract class Results implements Countable, Iterator
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
