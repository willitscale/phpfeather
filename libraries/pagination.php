<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

class Pagination
{

	private $currentPage = 0;
	private $maxPage = 0;
	private $items = 0;

	public function __construct()
	{
	}

}