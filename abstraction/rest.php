<?php

namespace uk\co\n3tw0rk\phpfeather\abstraction;

if( !defined( 'SYSTEM_ACCESS' ) )
{
    trigger_error( 'Unable to access application.', E_USER_ERROR );
}

include_once( 'abstraction/system.php' );

use uk\co\n3tw0rk\phpfeather\system as SYSTEM;


/**
 *	Rest
 *
 *	@version 0.0.1
 *	@package phpfeather\abstract
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
abstract class PHPF_Rest extends PHPF_System
{
	abstract public function _GET( $id = 0 );
	abstract public function _POST( $id = 0 );
	abstract public function _DELETE( $id = 0 );
	abstract public function _PUT( $id = 0 );
	abstract public function _PATCH( $id = 0 );
}
