<?php namespace n3tw0rk\phpfeather\Abstraction;

/**
 *	Cached Nodes Abstract Class
 *
 *	@version 0.1.1
 *	@package n3tw0rk\phpfeather\Abstraction
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class CachedNodes
{
	protected $attributes;
	protected $objects;

	public abstract function connect();
	public abstract function disconnect();
	public abstract function addNode( $host, $port );
	public abstract function addNodes( $nodes );
	public abstract function set( $key, $value );
	public abstract function setByNode( $node, $key, $value );
	public abstract function get( $key );
	public abstract function getByNode( $node, $key );
	public abstract function getMultiple( $keys );
	public abstract function getMultipleByNode( $node, $keys );
	public abstract function remove( $key );
	public abstract function removeByNode( $node, $key );
	public abstract function removeMutiple( $keys );
	public abstract function removeMutipleByNode( $node, $keys );
	public abstract function exists( $key );
	public abstract function existsByNode( $node, $key );
	public abstract function flush();
	public abstract function flushByNode( $node );
	public abstract function getNodeList();
}
