<?php
namespace framework\core;
use framework\core\exception\ConfigException;
/**
 * Config Class
 *
 * get config items with this class
 *
 * @use Config::instance(); for a get object of this class
 * @use Config::instance()->setFile(); for set config file
 * @use Config::instance()->getItems(); return all config items
 * @use Config::instance()->getItem(); return config item
 * @use Config::instance()->hasItem(); check item exists
 * @use Config::instance()->addItem(); add to config items
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		core
 * @copyright	(c) 2014 all rights reserved
 */
class Config
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
	 * get items from this file
	 *
	 * @access protected
	 * @var string
	 */
	protected $file = 'main.php';
	
	/**
	 * set configs to this
	 *
	 * @access protected
	 * @var array
	 */
	protected static $items = [];
	
	/**
	 * get one instance of this class
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
	 * set config file
	 *
	 * @param string $file, file name
	 * @access public
	 * @return object
	 */
	public function setFile($file)
	{
		if(!is_string($file))
			throw new ConfigException('config::setFile argument must be string');
		$this->file = $file;
	}
	
	/**
	 * check config item exists
	 *
	 * @param string $item, item name
	 * @access public
	 * @return boolean
	 */
	public function hasItem($item)
	{
		if($this->getItem($item))
			return true;
		return false;
	}
	
	/**
	 * get config item 
	 *
	 * @param string $item, item name
	 * @access public
	 * @return array|string
	 */
	public function getItem($item)
	{
		return $this->getItems($item);
	}
	
	/**
	 * get all config items
	 *
	 * @param string $item, item name
	 * @access public
	 * @return array|string
	 */
	public function getItems($item = false)
	{
		if(isset(self::$items[$item]))
			return self::$items[$item];
		$this->getItemsFromFile();
		if(!$item) 
			return self::$items;
		return self::$items[$item];
	}
	
	/**
	 * add config items
	 *
	 * @param array $items, items
	 * @access public
	 * @return void
	 */
	public function addItems($items)
	{
		if(!is_array($items) or count($items) <= 0)	
			return;
		array_merge($this->items,$items);
	}
		
	/**
	 * get all items from config file
	 *
	 * @access public
	 * @return array
	 */
	public function getItemsFromFile()
	{
		$path = BASEPATH."app/config/{$this->file}";
		if(!file_exists($path))
			throw new ConfigException("404 not found config file {$path}");
		self::$items = include $path;
		return self::$items;
	}
}