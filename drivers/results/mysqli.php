<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/results.php' );

class MysqliResults extends Results
{

	public function __construct( $mysqliResults = null )
	{
		$this->resultSet = $mysqliResults;
		$this->returnType = RESULT_ARRAY;
	}

	public function count()
	{
		if( !$this->resultSet )
			return 0;
		return $this->resultSet->num_rows;
	}

	public function current()
	{
		if( $this->valid() )
		{
			switch( $this->returnType )
			{
				case RESULT_OBJECT : 
					return $this->resultSet->fetch_object();
				case RESULT_ARRAY : 
					return $this->resultSet->fetch_array();
				case RESULT_ASSOC : 
				default :
					return $this->resultSet->fetch_assoc();
			}
		}
		return null;
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		$this->position++;
	}

	public function rewind()
	{
		$this->position = 0;
	}

	public function valid()
	{
		return ( 0 <= $this->position && $this->count() > $this->position && $this->resultSet->data_seek( $this->position ) );
	}

}