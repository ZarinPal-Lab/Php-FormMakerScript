<?php
namespace framework\database;
use framework\database\exception\QueryBuilderException;
use framework\database\Database;
/**
 * Query Builder
 * easy create query with this class
 *
 * @use QueryBuilder::instance()->select(); set select 
 * @use QueryBuilder::instance()->from(); set from
 * @use QueryBuilder::instance()->join(); set join
 * @use QueryBuilder::instance()->where(); set where
 * @use QueryBuilder::instance()->orderBy(); set order by
 * @use QueryBuilder::instance()->limit(); set limit
 * @use QueryBuilder::instance()->offset(); set offset
 * @use QueryBuilder::instance()->getQuery(); get query
 * @use QueryBuilder::instance()->clearQuery(); clear properties
 *
 * @author		saeed johary <foreach@live.com>
 * @since 		1.0
 * @package		database
 * @copyright	(c) 2014 all rights reserved
 */
class QueryBuilder
{
	/**
	 * singleton object 
	 * save one object of this class
	 * to this property
	 *
	 * @access private static
	 * @var object
	 */
	private static $instance = null;
	
	/**
	 * select in query
	 *
	 * @access protected
	 * @var string
	 */
	protected $select = 'SELECT *';
	
	/**
	 * from in query
	 *
	 * @access protected
	 * @var string
	 */
	protected $from = null;
	
	/**
	 * join in query
	 *
	 * @access protected
	 * @var array
	 */
	protected $join = [];
	
	/**
	 * where in query
	 *
	 * @access protected
	 * @var array
	 */
	protected $where = [];
	
	/**
	 * orderby in query
	 *
	 * @access protected
	 * @var string
	 */
	protected $orderBy = null;
	
	/**
	 * limit in query
	 *
	 * @access protected
	 * @var integer
	 */
	protected $limit = null;
	
	/**
	 * offset in query
	 *
	 * @access protected
	 * @var integer
	 */
	protected $offset = null;
	
	/**
	 * get one object of this class
	 *
	 * @access public static
	 * @return object
	 */
	public static function instance()
	{
		if(self::$instance === null)
			self::$instance = new self;
		return self::$instance;
	}
	
	/**
	 * set select
	 *
	 * @param string $select, select fields
	 * @access public
	 * @return object
	 */
	public function select($select = '*')
	{
		$this->select = "SELECT {$select}";
		return self::$instance;
	}
	
	/**
	 * set from
	 *
	 * @param string $from, set table
	 * @access public
	 * @return object
	 */
	public function from($from)
	{
		$this->from = " FROM `{$from}`";
		return self::$instance;
	}
	
	/**
	 * set join
	 *
	 * @param string $join, condition
	 * @param string $joinType, join type
	 * @access public
	 * @return object
	 */
	public function join($join,$joinType = 'INNER JOIN')
	{
		$this->join[] = " {$joinType} {$join}";
		return self::$instance;
	}
	
	/**
	 * set where
	 *
	 * @param string $where, condition
	 * @param string $mode, where mode (AND,OR)
	 * @access public
	 * @return object
	 */
	public function where($where,$mode = 'WHERE')
	{
		$this->where[] = " {$mode} {$where}";
		return self::$instance;
	}
	
	/**
	 * set order by
	 *
	 * @param string $orderBy
	 * @access public
	 * @return object
	 */
	public function orderBy($orderBy)
	{
		$this->orderBy = " ORDER BY {$orderBy}";
		return self::$instance;
	}
	
	/**
	 * set limit
	 *
	 * @param integer $limit
	 * @access public
	 * @return object
	 */
	public function limit($limit)
	{
		if(!is_numeric($limit))
			throw new QueryBuilderException('QueryBuilder::limit first argument must be integer');
		$this->limit = " LIMIT {$limit}";
		return self::$instance;
	}
	
	/**
	 * set offset
	 *
	 * @param integer $offset
	 * @access public
	 * @return object
	 */
	public function offset($offset)
	{
		if(!is_numeric($offset))
			throw new QueryBuilderException('QueryBuilder::offset first argument must be integer');
		$this->offset = ",{$offset}";
		return self::$instance;
	}
	
	/**
	 * create insert query
	 *
	 * @param string $table, database table
	 * @param array $values, query fields and values
	 * @param array $params, prepare values
	 * @access public
	 * @return boolean
	 */
	public function insert($table,$values,$params = [])
	{
		$fields = $fieldValues = '';
		foreach($values as $key => $value)
		{
			$fields .= "`{$key}`,";
			$fieldValues .= "{$value},";
		}
		$data = array_map('rtrim',[$fields,$fieldValues],[',',',']);
		$sql = "INSERT INTO `{$table}` ({$data[0]}) VALUES({$data[1]})";
		$stmt = Database::connection()->prepare($sql);
		$stmt->execute($params);
		$stmt->closeCursor();
		return Database::connection()->lastInsertId();
	}
	
	/**
	 * create update query
	 *
	 * @param string $table, database table
	 * @param array $values, fields and values
	 * @param string $condition, condition
	 * @param array $params, prepare values and conditions
	 */
	public function update($table,$values,$condition = '',$params = [])
	{
		$fields = '';
		foreach($values as $field => $value)
		{
			$fields .= "`{$field}` = {$value},";
		}
		$fields = rtrim($fields,',');
		$sql = "UPDATE `{$table}`  SET {$fields}";
		if($condition) $sql .= " WHERE {$condition}";
		$stmt = Database::connection()->prepare($sql);
		$stmt->execute($params);
		$stmt->closeCursor();
		return Database::connection()->lastInsertId();
	}
	
	/**
	 * create delete query
	 *
	 * @param string $table, database table
	 * @param string $condition, condition
	 * @param array $params, prepare values
	 */
	public function delete($table,$condition = '',$params = [])
	{
		$sql = "DELETE FROM `{$table}`";
		if($condition)
			$sql .= "  WHERE {$condition}";
		$stmt = Database::connection()->prepare($sql);
		$stmt->execute($params);
		$stmt->closeCursor();
		return Database::connection()->lastInsertId();
	}
	
	/**
	 * parse and get query
	 *
	 * @param boolean $clear, if true reset properties
	 * @access public
	 * @return string
	 */
	public function getQuery($clear = true)
	{
		$output  = $this->select.$this->from;
		foreach($this->join as $join)
			$output .= $join;
		foreach($this->where as $where)
			$output .= $where;
		$output .= $this->orderBy.$this->limit.$this->offset;
		if($clear) $this->clear();
		return $output;
	}
	
	/**
	 * get database one row
	 *
	 * @param array $params, execute params
	 * @param string $fetchMode, pdo fetch mode
	 * @access public
	 * @return mixed
	 */
	public function getRow($params = [],$fetchMode = \PDO::FETCH_OBJ)
	{
		$query = Database::connection()->prepare($this->getQuery());
		$query->execute($params);
		return $query->fetch($fetchMode);
	}
	
	/**
	 * get database rows
	 *
	 * @param array $params, execute params
	 * @param string $fetchMode, pdo fetch mode
	 * @access public
	 * @return mixed
	 */
	public function getAll($params = [],$fetchMode = \PDO::FETCH_OBJ)
	{
		$query = Database::connection()->prepare($this->getQuery());
		$query->execute($params);
		return $query->fetchAll($fetchMode);
	}
	
	/**
	 * reset properties
	 *
	 * @access public 
	 * @return void
	 */
	public function clear()
	{
		$this->select = 'SELECT *';
		$this->from = null;
		$this->join = [];
		$this->where = [];
		$this->orderBy = null;
		$this->limit = null;
		$this->offset = null;
	}
}