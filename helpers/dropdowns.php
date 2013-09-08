<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

/**
 *	DROPDOWNS
 *
 *	@version 0.0.1
 *	@package phpfeather\helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_DROPDOWNS
{

	public static function dropDownOptions( $options, $selected = null, $default = true )
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
