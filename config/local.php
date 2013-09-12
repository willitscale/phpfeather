<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

define( 'APPLICATION_RELEASE', DEVELOPMENT, true );

/*

Example Config :
	
$autoload[ 'db' ] = 'Database';

$database[ 'local' ][ 'driver' ] = 'mysqli';
$database[ 'local' ][ 'host' ] = '127.0.0.1';
$database[ 'local' ][ 'port' ] = 3306;
$database[ 'local' ][ 'user' ] = '';
$database[ 'local' ][ 'pass' ] = '';
$database[ 'local' ][ 'data' ] = '';
$database[ 'local' ][ 'test' ] = false;
	
$autoload[ 'cache' ] = 'Cache';

$cached[ 'local' ][ 'host' ] = '127.0.0.1';
$cached[ 'local' ][ 'port' ] = 11211;

$mapping[ '/robots.txt' ] = '/static/robots';

*/
