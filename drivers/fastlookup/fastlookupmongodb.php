<?php

if( !defined( 'SYSTEM_ACCESS' ) )
        trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/fastlookupnosqldatabase.php' );

class PHPF__FastLookupMongoDB extends PHPF__FastLookupNoSQLDatabase
{
}

