<?php namespace n3tw0rk\phpfeather;

spl_autoload_register( function ( $class )
{
	$framework = 'n3tw0rk\\phpfeather\\';

	$base_dir = __DIR__ . '/';

	$size = strlen( $framework );
	
	if( 0 !== strncmp( $framework, $class, $size ) )
	{
		return;
	}

	$relative = substr( $class, $size );

	// Try the application first
	$file = $_SERVER[ 'DOCUMENT_ROOT' ] . str_replace( '\\', '/', $relative ) . '.php';

	if( file_exists( $file ) )
	{
		require_once( $file );
		return;
	}

	// Try the framework last
	$file = $base_dir . str_replace( '\\', '/', $relative ) . '.php';

	if( file_exists( $file ) )
	{
		require_once( $file );
		return;
	}
});
