<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

abstract class Cached
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
