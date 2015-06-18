<?php namespace n3tw0rk\phpfeather\Libraries\Forms\Helpers;

/**
 *	Validation
 *
 *	@version 0.0.1
 *	@package n3tw0rk\phpfeather\Libraries\Forms\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Validation
{

	public function __construct()
	{
	}
	
	public function check( $value, $min = 0, $max = 100, $expression = REGEXP_ANYTHING, 
		$blank = false, $numeric = false )
	{
		$bitmask = ZERO;
		
		if( !$blank && $this->blank( $value, $numeric ) )
			$bitmask = $bitmask | VALIDATION_BLANK_FAIL;

		if( !$this->min( $value, $min ) )
			$bitmask = $bitmask | VALIDATION_MIN_FAIL;
		
		if( !$this->max( $value, $max ) )
			$bitmask = $bitmask | VALIDATION_MAX_FAIL;
		
		if( !$this->regexp( $value, $expression ) )
			$bitmask = $bitmask | VALIDATION_REGEXP_FAIL;

		return $bitmask;

	}

	public function blank( $value, $numeric = false )
	{
		return ( !isset( $value ) || is_null( $value ) || '' == $value || 
			( $numeric && 0 >= intval( $value ) ) );
	}
	
	public function regexp( $value, $expression = REGEXP_ANYTHING )
	{
		return preg_match( $expression, $value );
	}
	
	public function min( $value, $min = 0 )
	{
		return ( strlen( $value ) > $min );
	}
	
	public function max( $value, $max = 100 )
	{
		return ( strlen( $value ) < $max );
	}
	
	public function compare( $value1, $value2 )
	{
		return ( $value1 == $value2 ) ? ZERO : VALIDATION_COMPARE_FAIL;
	}

}