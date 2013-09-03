<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

if( !function_exists( 'dropDownOptions' ) )
{

	function dropDownOptions( $options, $selected = null, $default = true )
	{
	
		$dropDowns = array();
		
		if( $default )
			$dropDowns[] = '<option value="-1">Please Select</option>';
		
		if( is_array( $options ) && 0 < sizeof( $options ) )
		{
			foreach( $options AS $key => $val )
				if( $selected == $key )
					$dropDowns[] = sprintf( '<option value="%s" selected="selected">%s</option>', $key, $val );
				else
					$dropDowns[] = sprintf( '<option value="%s">%s</option>', $key, $val );
		}
		
		return implode( "\n", $dropDowns );
	}

}