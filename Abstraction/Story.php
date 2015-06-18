<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	Story Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class Story extends System
{
	/**
	 * 
	 * @param unknown $request
	 * @return unknown
	 */
	public function start($request)
	{
		return $request;
	}

	/**
	 * 
	 * @param unknown $closure
	 * @param unknown $request
	 */
	public function middle($closure,$request)
	{
		return $closure($request);
	}

	/**
	 * 
	 * @param unknown $response
	 * @return unknown
	 */
	public function end($response)
	{
		return $response;
	}
}
