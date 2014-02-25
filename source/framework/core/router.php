<?php
namespace framework\core;
use framework\core\exception\RouterException;
use framework\core\Config;
use framework\request\Request;
/**
 * Router Class
 * parse request for get controller and action and params
 *
 * @use Router::controller , get controller name
 * @use Router::action , get action name
 * @use Router::params , get action params
 * @use Router::instance() , get one object of this class
 * @use Router::parseRequest() , parse and set controller,action,params
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		core
 * @copyright	(c) 2014 all rights reserved
 */
final class Router
{
	/**
	 * singleton object
	 * save one object of this
	 * class to this property
	 *
	 * @access private static
	 * @var object
	 */
	private static $instance = null;
	
	/**
	 * controller name
	 *
	 * @access public
	 * @var string
	 */
	public $controller;
	
	/**
	 * action name
	 *
	 * @access public
	 * @var string
	 */
	public $action;
	
	/**
	 * action params
	 *
	 * @access public
	 * @var array
	 */
	public $params = [];
	
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
	 * parse url for get controller and action and params
	 * replace index file and sub folder 
	 *
	 * @access public
	 * @return string
	 */
	public function parseRequest()
	{
		$find = [Config::instance()->getItem('subFolder'),Config::instance()->getItem('indexFile')];
		$uri = trim(str_replace($find,['',''],Request::getServer('PHP_SELF')),'/');
		$parts = explode('/',$uri);
		if(isset($parts[0]))
			$this->controller = $parts[0];
		if(isset($parts[1]))
			$this->action = $parts[1];
		array_shift($parts);
		array_shift($parts);
		$this->params = $parts;
		if(empty($this->controller))
			$this->controller = Config::instance()->getItem('defaultController');
		return $uri;
	}
	
	/**
	 * parse string for exception and error handler class
	 *
	 * @param string $string, example main/error
	 * @access public
	 * @return array
	 */
	public function parseMyString($string)
	{
		$parts = explode('/',$string);
		if(!isset($parts[0]) or !isset($parts[1]))
			throw new RouterException('Router::parseMyString first argument not valid');
		$output['controller'] = ucfirst($parts[0]).'Controller';
		$output['action'] =  $parts[1];
		$output['controllerClass'] = "app\controllers\\{$output['controller']}";
		return $output;
	}
}