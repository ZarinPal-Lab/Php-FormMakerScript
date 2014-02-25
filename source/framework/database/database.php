<?php
namespace framework\database;
use framework\database\exception\DatabaseException;
use framework\database\QueryBuilder;
use framework\core\Config;
/**
 * Database Class
 *
 * @use Database::queryBuilder(); get singleton object of QueryBuilder class
 * @use Database::connection(); get singleton object of pdo class connection
 * @use Database::closeConnection(); set static $pdo to null
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		database
 * @copyright	(c) 2014 all rights reserved
 */
class Database
{	
	/**
	 * pdo connection
	 *
	 * @access private static
	 * @var object
	 */
	private static $pdo = null;
	
	/**
	 * get query builder object
	 *
	 * @access public static
	 * @return object
	 */
	public static function queryBuilder()
	{
		return QueryBuilder::instance();
	}
	
	/**
	 * get one connection of pdo class
	 *
	 * @access public static
	 * @return object
	 */
	public static function connection()
	{
		if(!extension_loaded('pdo'))
			throw new DatabaseException('please enable pdo extension');
		if(self::$pdo === null){
			$db = Config::instance()->getItem('database');
			$pdo = new \PDO($db['connection'],$db['username'],$db['password']);
			$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES,$db['emulatePrepare']);
			$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
			$pdo->exec('SET CHARACTER SET utf8;SET NAMES utf8');
			self::$pdo = $pdo;
			unset($pdo);
			return self::$pdo;
		}
		return self::$pdo;
	}
	
	/**
	 * set pdo static property to null
	 *
	 * @access public static
	 * @return void
	 */
	public static function closeConnection()
	{
		self::$pdo = null;
	}
}