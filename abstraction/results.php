<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

/**
 *	Results
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_Results implements Countable, Iterator
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
