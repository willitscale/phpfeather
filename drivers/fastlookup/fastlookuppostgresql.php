<?php

if( !defined( 'SYSTEM_ACCESS' ) )
        trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/fastlookupsqldatabase.php' );

class PHPF__FastLookupPostgreSQL extends PHPF__FastLookupSQLDatabase
{
}

