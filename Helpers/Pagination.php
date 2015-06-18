<?php namespace n3tw0rk\phpfeather\Helpers;

/**
 *	Pagination Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class Pagination
{
	public static function params( $count, $page = 1, $limit = 12, $padding = 1 )
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