<?php namespace n3tw0rk\phpfeather\Libraries\Database\Drivers\Results;

use n3tw0rk\phpfeather\Libraries\Database\Abstraction\Results;

class MySQLi extends Results
{

	public function __construct( $mysqliResults = null )
	{
		$this->resultSet = $mysqliResults;
		$this->returnType = self::RESULT_ARRAY;
	}

	public function count()
	{
		if( empty( $this->resultSet ) )
		{
			return 0;
		}
		return $this->resultSet->num_rows;
	}

	public function current()
	{
		if( $this->valid() )
		{
			switch( $this->returnType )
			{
				case self::RESULT_OBJECT : 
				{
					return $this->resultSet->fetch_object();
				}
				case self::RESULT_ARRAY : 
				{
					return $this->resultSet->fetch_array();
				}
				case self::RESULT_ASSOC : 
				default :
				{
					return $this->resultSet->fetch_assoc();
				}
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
		return ( 0 <= $this->position && 
			$this->count() > $this->position && 
			$this->resultSet->data_seek( $this->position ) );
	}

}
