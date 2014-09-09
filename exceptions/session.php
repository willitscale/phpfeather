<?php

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

namespace uk\co\n3tw0rk\phpfeather\exceptions;

/**
 *	Session Exception
 *
 *	@version 0.0.1
 *	@package phpfeather\exceptions
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_SessionException extends Exception{}
