<?php namespace n3tw0rk\phpfeather\Libraries;

/**
 *	CURL Library
 *
 *	@version 0.0.1
 *	@package libraries\curl
 *	@author James Lockhart james@n3tw0rk.co.uk
 *	@license GPL v2
 *	@license http://www.gnu.org/licenses/gpl-2.0.html
 */
class CURL
{
	private $options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HEADER         => false,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_ENCODING       => "utf-8",
		CURLOPT_USERAGENT      => "PHPF",
		CURLOPT_AUTOREFERER    => true,
		CURLOPT_CONNECTTIMEOUT => 120,
		CURLOPT_TIMEOUT        => 120,
		CURLOPT_MAXREDIRS      => 10,
		CURLOPT_SSL_VERIFYPEER => false
	);
	
	private $cUrl;

	public function get( $url )
	{
		$this->cUrl = curl_init( $url );

		curl_setopt_array( $this->cUrl, $this->options );

		$data = curl_getinfo( $this->cUrl );
		$data[ 'errno' ]   = curl_errno( $this->cUrl );
		$data[ 'errmsg' ]  = curl_error( $this->cUrl );
		$data[ 'content' ] = curl_exec( $this->cUrl );

		curl_close( $this->cUrl );

		return $data;
	}
	
	public function setOption( $option, $value )
	{
		$this->options[ $option ] = $value;
	}
}