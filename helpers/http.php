<?php

namespace uk\co\n3tw0rk\phpfeather\helpers;

if( !defined( 'SYSTEM_ACCESS' ) )
{
	trigger_error( 'Unable to access application.', E_USER_ERROR );
}

/**
 *	HTTP
 *
 *	@version 0.0.1
 *	@package phpfeather\helpers
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class PHPF_HTTP
{
	public static $codes = array(
			'100'	=>	'Continue',
			'101'	=>	'Switching Protocols',
			'200'	=>	'OK',
			'201'	=>	'Created',
			'202'	=>	'Accepted',
			'203'	=>	'Non-Authoritative Information',
			'204'	=>	'No Content',
			'205'	=>	'Reset Content',
			'206'	=>	'Partial Content',
			'300'	=>	'Multiple Choices',
			'301'	=>	'Moved Permanently',
			'302'	=>	'Found',
			'303'	=>	'See Other',
			'304'	=>	'Not Modified',
			'305'	=>	'Use Proxy',
			'306'	=>	'(Unused)',
			'307'	=>	'Temporary Redirect',
			'400'	=>	'Bad Request',
			'401'	=>	'Unauthorized',
			'402'	=>	'Payment Required',
			'403'	=>	'Forbidden',
			'404'	=>	'Not Found',
			'405'	=>	'Method Not Allowed',
			'406'	=>	'Not Acceptable',
			'407'	=>	'Proxy Authentication Required',
			'408'	=>	'Request Timeout',
			'409'	=>	'Conflict',
			'410'	=>	'Gone',
			'411'	=>	'Length Required',
			'412'	=>	'Precondition Failed',
			'413'	=>	'Request Entity Too Large',
			'414'	=>	'Request-URI Too Long',
			'415'	=>	'Unsupported Media Type',
			'416'	=>	'Requested Range Not Satisfiable',
			'417'	=>	'Expectation Failed',
			'500'	=>	'Internal Server Error',
			'501'	=>	'Not Implemented',
			'502'	=>	'Bad Gateway',
			'503'	=>	'Service Unavailable',
			'504'	=>	'Gateway Timeout',
			'505'	=>	'HTTP Version Not Supported' );

	public static function REDIRECT( $url, $httpCode = '307' )
	{
		header( sprintf( 'Location: %s', $url ) );
		header( sprintf( 'Status: %s %s', $httpCode, HTTP::$codes[ $httpCode ] ) );
		header( sprintf( 'HTTP/1.0 %s %s', $httpCode, HTTP::$codes[ $httpCode ] ) );
	}
	
	public static function IP()
	{
		return $_SERVER[ 'REMOTE_ADDR' ];
	}
	
	public static function URL( $params = array(), $full = false )
	{
		$urn = '';

		if( isset( $_GET[ 'u' ] ) )
		{
			$urn = $_GET[ 'u' ];
			unset( $_GET[ 'u' ] );
		}
		
		if( empty( $params ) )
		{
			$params = $_GET;
		}
		else
		{
			$params = array_merge( $_GET, $params );
		}
		
		$queryString = '';
		
		if( !empty( $params ) )
		{
			$queryString = '?';
			foreach( $params AS $key => $value )
			{
				if( '?' !== $queryString )
				{
					$queryString .= '&';
				}
	
				$queryString .= $key . '=' . $value;
			}
		}

		if( !$full )
		{
			return $urn . $queryString;
		}
		
		$protocol = 'http';
		
		if( isset( $_GET[ 'HTTPS' ] ) )
		{
			$protocol = 'https';
		}

		$uri = $_SERVER[ 'HTTP_HOST' ] . $urn;
		
		return $protocol . '://' . $uri . $queryString;
	}
}