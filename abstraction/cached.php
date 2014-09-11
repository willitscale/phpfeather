<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;


if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

/**
 *	Cached
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_Cached
{
	protected $attributes;
	protected $object;

	public abstract function connect();
	public abstract function disconnect();
	public abstract function set();
	public abstract function remove();
	public abstract function exists();
	public abstract function flush();
}
