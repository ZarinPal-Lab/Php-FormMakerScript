<?php
namespace framework\helpers;
use framework\helpers\exception\ArrayHelperException;
/**
 * Array Helper
 * set get and delete array keys
 * 
 * @use ArrayHelper::set(); set keys to array with key1.key2.lastKey = ...
 * @use ArrayHelper::get(); get key from array
 * @use ArrayHelper::delete(); unset key of array
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		helpers
 * @copyright	(c) 2014 all rights reserved
 */
class ArrayHelper
{
	/**
	 * set keys to array
	 *
	 * @param array $array, example $_SESSION
	 * @param string $key, key.key1.key2
	 * @param mixed $value, key value
	 * @access public static
	 * @return void
	 */
	public static function set(&$array,$key,$value)
	{
		$keys = explode('.',$key);
		while(count($keys) > 1)
		{
			$key = array_shift($keys);
			if(!isset($array[$key]))
				$array[$key] = [];
			$array =& $array[$key];
		}
		$array[array_shift($keys)] = $value;
	}
	
	/**
	 * get key from array
	 *
	 * @param array $array, array for get
	 * @param string $key, key1.key2
	 * @access public static
	 * @return mixed
	 */
	public static function get($array,$key)
	{
		$keys = explode('.',$key);
		while(count($keys) > 1)
		{
			$key = array_shift($keys);
			if(!isset($array[$key]))
				return false;
			$array =& $array[$key];
		}
		$lastKey = array_shift($keys);
		return (isset($array[$lastKey]) ? $array[$lastKey] : false);
	}
	
	/**
	 * delete keys of array
	 *
	 * @param array $array, array for delete
	 * @param string $key, key.key1.key2
	 * @access public static
	 * @return void
	 */
	public static function delete(&$array,$key)
	{
		$keys = explode('.',$key);
		while(count($keys) > 1)
		{
			$key = array_shift($keys);
			if(!isset($array[$key]))
				return false;
			$array =& $array[$key];
		}
		unset($array[array_shift($keys)]);
	}
}