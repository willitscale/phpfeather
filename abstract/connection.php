<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

abstract class Connection
{
	
	protected $connection;

	abstract public function connect();
	abstract public function disconnect();
	
	abstract public function query();
	abstract public function info();
	abstract public function error();
	abstract public function id();
	
	abstract public function escape( $string );

	public function queryString()
	{

		$args = func_get_args();

		if( !is_array( $args ) || 0 == sizeof( $args ) )
			return '';

		$matches = null;
		$escaped = array();

		preg_match_all( '/[^%](?<flags>%[0-9\$\.+ -]*[bcdeEfFgGorsuxX])/m', $args[ 0 ], $matches );

		$ni = 1;
		if( is_array( $matches ) && array_key_exists( 'flags', $matches ) )
			foreach( $matches[ 'flags' ] AS $key => $val )
			{
			
				if( 1 == preg_match( '/(?<pos>[0-9]+)\$/', $val, $pos ) )
				{
					$escape = intval( $pos[ 'pos' ] );
					$ni--;
				}
				else
					$escape = $key + $ni;

				if( !array_key_exists( $escape, $args ) || in_array( $escape, $escaped ) )
					continue;

				switch( 1 )
				{

					case preg_match( '/b$/', $val ) : 
					case preg_match( '/c$/', $val ) : 
					case preg_match( '/d$/', $val ) : 
					case preg_match( '/o$/', $val ) : 
					case preg_match( '/u$/', $val ) : 
					case preg_match( '/x$/', $val ) : 
					case preg_match( '/X$/', $val ) : 
						$args[ $escape ] = intval( $args[ $escape ] );
						break;

					case preg_match( '/e$/', $val ) : 
					case preg_match( '/E$/', $val ) : 
					case preg_match( '/f$/', $val ) : 
					case preg_match( '/F$/', $val ) : 
					case preg_match( '/g$/', $val ) : 
					case preg_match( '/G$/', $val ) : 
						$args[ $escape ] = floatval( $args[ $escape ] );
						break;

					case preg_match( '/s$/', $val ) : 
						$args[ $escape ] = $this->escape( strval( $args[ $escape ] ) );
						break;

					case preg_match( '/r$/', $val ) : 
						break;

				}

				$escaped[] = $escape;
			}

		unset( $matches );

		$args[ 0 ] = preg_replace( '/%([0-9\$]*)s/m', '\'$0\'', $args[ 0 ] );
		$args[ 0 ] = preg_replace( '/(%([0-9\$]*)r)/m', '%$2s', $args[ 0 ] );

		return call_user_func_array( 'sprintf', $args );

	}

}
