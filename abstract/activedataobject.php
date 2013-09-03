<?php

if( !defined( 'SYSTEM_ACCESS' ) )
	trigger_error( 'Unable to access application.', E_USER_ERROR );

include_once( 'abstract/model.php' );

abstract class ActiveDataObject extends Model
{

	protected $table;
	protected $exclude;
	protected $schema;
	protected $key;

	public function __construct( $table, $exclude = array(), $key = '' )
	{
		parent::__construct();
		$this->table = $table;
		$this->exclude = $exclude;
		$this->key = $key;
		$this->getSchema();
	}
	
	protected function getSchema()
	{
		$this->schema = array();
		foreach( $this->db->query( 'DESCRIBE `%r`;', $this->table ) AS $column )
			if( !in_array( $column[ 'Field' ], $this->exclude ) )
				$this->schema[] = $column[ 'Field' ];
	}

	public function update( $recordID = 0, $values = array() )
	{
		if( !isset( $recordID ) || 0 >= $recordID )
			return 0;
	
		$updates = array();

		foreach( $values AS $field => $value )
		{
			if( is_array( $value ) && array_key_exists( 'type', $value ) )
			{
				switch( $value[ 'type' ] )
				{
					case 'int' :
						$updates[] = $this->db->queryString( '`%r` = %d', $field, $value[ 'value' ] );
						break;
					case 'raw' :
						$updates[] = $this->db->queryString( '`%r` = %r', $field, $value[ 'value' ] );
						break;
					case 'string' :
					default :
						$updates[] = $this->db->queryString( '`%r` = %s', $field, $value );
						break;
				}
			}
			else
				$updates[] = $this->db->queryString( '`%r` = %s', $field, $value );
		}
		
		$this->db->query( 'UPDATE `%r` SET %r WHERE `%r` = %d;', 
			$this->table, implode( ',', $updates ), $this->key, $recordID );

		return 1;
	}

	public function create( $defaults = array() )
	{
		
		$fields = array();
		$values = array();
	
		foreach( $defaults AS $field => $value )
		{
			$fields[] = $this->db->queryString( '`%r`', $field );
			if( is_array( $value ) && array_key_exists( 'type', $value ) )
			{
				switch( $value[ 'type' ] )
				{
					case 'int' :
						$values[] = $this->db->queryString( '%d', $value[ 'value' ] );
						break;
					case 'raw' :
						$values[] = $value[ 'value' ];
						break;
					case 'string' :
					default :
						$values[] = $this->db->queryString( '%s', $value );
						break;
				}
			}
			else
			{
				$values[] = $this->db->queryString( '%s', $value );
			}
		}

		$this->db->query( 'INSERT INTO `%r` ( %r ) VALUES ( %r );', $this->table, 
			implode( ',', $fields ), implode( ',', $values ) );
		
		return $this->db->id();
	}

	public function &getList( $columns = array(), $joining = array(), $where = array(), $limit = 100, $offset = 0, $order = NULL )
	{

		$limitString = '';

		if( 0 < $limit )
			$limitString = $this->db->queryString( ' LIMIT %d, %d', $offset, $limit );

		$orderString = '';
			
		if( !is_null( $order ) )
			$orderString = $this->db->queryString( ' ORDER BY %r ', $order );
			
		$columnsString = '*';

		if( is_array( $columns ) && 0 < sizeof( $columns ) )
		{
			foreach( $columns AS $key => $val )
				$columns[ $key ] = $this->db->queryString( '`%r`', $val );
			$columnsString = implode( ', ', $columns );
		}

		$whereString = '';
		if( is_array( $where ) && 0 < sizeof( $where ) )
			$whereString = $this->db->queryString( 'WHERE %r', implode( ' AND ', $where ) );
			
		$joiningString = '';
		if( is_array( $joining ) && 0 < sizeof( $joining ) )
			$joiningString = implode( ' ', $joining );

		$data = $this->db->query( 'SELECT %r FROM `%r` %r %r %r %r', $columnsString, $this->table, 
			$joiningString, $whereString, $orderString, $limitString );

		$return = array();
		
		foreach( $data AS $row )
			$return[] = $row;
		
		return $return;

	}

	public function &getAjaxList( $columns = array(), $joining = array(), $where = array(), $limit = 100, $offset = 0, $order = NULL )
	{

		$limitString = '';

		if( 0 < $limit )
			$limitString = $this->db->queryString( ' LIMIT %d, %d', $offset, $limit );

		$orderString = '';
			
		if( !is_null( $order ) )
			$orderString = $this->db->queryString( ' ORDER BY %r ', $order );
			
		$columnsString = '*';

		if( is_array( $columns ) && 0 < sizeof( $columns ) )
		{
			foreach( $columns AS $key => $val )
				$columns[ $key ] = $this->db->queryString( '`%r`', $val );
			$columnsString = implode( ', ', $columns );
		}

		$whereString = '';
		if( is_array( $where ) && 0 < sizeof( $where ) )
			$whereString = $this->db->queryString( 'WHERE %r', implode( ' AND ', $where ) );
			
		$joiningString = '';
		if( is_array( $joining ) && 0 < sizeof( $joining ) )
			$joiningString = implode( ' ', $joining );

		$data = $this->db->query( 'SELECT %r FROM `%r` %r %r %r %r', $columnsString, $this->table, 
			$joiningString, $whereString, $orderString, $limitString );
		
		$dataSize = $this->db->query( 'SELECT COUNT( 1 ) AS `counter` FROM `%r` %r %r', $this->table, 
			$joiningString, $whereString )->current();

		$return = new stdClass;
			
		$return->data = array();
		$return->items = $dataSize[ 'counter' ];
		
		foreach( $data AS $row )
			$return->data[] = $row;
		
		return $return;

	}
	
}
