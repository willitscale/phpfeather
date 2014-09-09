<?php

if( !defined( 'SYSTEM_ACCESS' ) )
        trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/fastlookup.php' );

class PHPF__FastLookupNoSQLDatabase extends PHPF__FastLookup
{
}

