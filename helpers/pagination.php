<?php

namespace uk\co\n3tw0rk\phpfeather\helpers;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

/**
 *	PAGINATION
 *
 *	@version 0.0.1
 *	@package uk\co\n3tw0rk\phpfeather\helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_PAGINATION
{
	public static function PARAMS( $count, $page = 1, $limit = 12, $padding = 1 )
	{
		$max = ceil( $count / $limit );

		if( 0 >= $page || $page > $max )
		{
			$page = 1;
		}

		return array(
			'count'		=> $count,
			'page' 		=> $page,
			'pre' 		=> $page - $padding,
			'post'		=> $page + $padding,
			'count'		=> $count,
			'limit' 	=> $limit,
			'max' 		=> $max,
			'showmin' 	=> 1 + $padding,
			'showmax' 	=> $max - $padding );
	}
}