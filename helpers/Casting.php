<?php namespace n3tw0rk\phpfeather\Helpers;

/**
 *	Casting Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Casting
{
	public static function &arrayToObject( $array )
	{
		$object = new stdClass;
	
		if( !is_array( $array ) )
		{
			return $array;
		}
	
		foreach( $array AS $key => $val )
		{
			$object->$key = self::arrayToObject( $val );
		}
	
		return $object;
	}
	
	public static function &objectToArray( $object )
	{
		$array = [];
	
		if( !is_object( $object ) )
		{
			return $object;
		}
	
		foreach( $object AS $key => $val )
		{
			$array[ $key ] = self::objectToArray( $val );
		}
	
		return $array;
	}
}
