<?php

if( !defined( 'SYSTEM_ACCESS' ) )
        trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/fastlookupmemory.php' );

class PHPF__FastLookupMemcache extends PHPF__FastLookupMemory
{
}

