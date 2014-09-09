<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstraction/fastlookup.php' );

abstract class PHPF__FastLookupMemory extends PHPF__FastLookup
{
}

