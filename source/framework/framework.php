<?php
use framework\core\Config;
use framework\autoloader\Autoloader;
use framework\core\Router;
use framework\log\Log;
/**
 * Framework Class
 * bootstrap all requests , router and run controller
 *
 * @use Framework::getGeneratedTime(); get script generated time
 * @use Framework::getMemoryUsage(); get script memory usage by kb
 * @use Framework::version(); get framework version
 * @use Framework::name(); get framework name
 * @use Framework::import(); include file or add class to classes
 * @use Framework::getSiteUrl(); get site url
 * @use Framework::createUrl(); create valid url 
 * @use Framework::db(); get database connection
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		bootstrap
 * @copyright	(c) 2014 all rights reserved
 */
final class Framework
{
	/**
	 * singleton object
	 * save one object of this class
	 * to this property
	 *
	 * @access private static
	 * @var object
	 */
	private static $instance;
	
	/**
	 * script begin time
	 *
	 * @access public static
	 * @var integer|float
	 */
	public static $beginTime;
	
	/**
	 * script begin memory
	 *
	 * @access public static
	 * @var integer|float
	 */
	public  static $beginMemory;
	
	/**
	 * controller object
	 *
	 * @access public
	 * @var object
	 */
	public $controller;
	
	/**
	 * get framework version
	 *
	 * @access public static
	 * @return float
	 */
	public static function version()
	{
		return 1.0;
	}
	
	/**
	 * get framework name
	 *
	 * @access public static
	 * @return string
	 */
	public static function name()
	{
		return 'Personal Framework';
	}
	
	/**
	 * get one object of this class
	 *
	 * @access public static
	 * @return object
	 */
	public static function instance()
	{
		if(!empty(self::$instance))
			return self::$instance;
		return self::$instance = new self;
	}
	
	/**
	 * initialize autoloader and error reporting
	 *
	 * @access public
	 * @return void
	 */
	public function initialize()
	{
		self::$beginTime = microtime();
		self::$beginMemory = memory_get_usage();
		self::import(FRAMEWORK.'autoloader/autoloader',true);
		Autoloader::instance()->initialize();
		Autoloader::instance()->setClasses(self::import(FRAMEWORK.'classes',true));
		AutoLoader::instance()->setClasses(Config::instance()->getItem('classes'));
              date_default_timezone_set(Config::instance()->getItem('timeZone'));
		error_reporting(Config::instance()->getItem('errorReporting'));
		set_exception_handler([self::$instance,'exceptionHandler']);
		set_error_handler([self::$instance,'errorHandler']);
		return self::$instance;
	}
	
	/**
	 * router and run application
	 *
	 * @access public
	 * @return void
	 */
	public function run()
	{
		$this->initialize();
		Router::instance()->parseRequest();
		$controller = ucfirst(Router::instance()->controller).'Controller';
		$action = 'action'.ucfirst(Router::instance()->action);
		$params = Router::instance()->params;
		$class = "app\controllers\\{$controller}";
		if(!Autoloader::instance()->hasClass($class))
			throw new Exception("404 not found autoloader class {$class}");
		$controllerClass = new $class();
		$this->controller = $controllerClass;
		if(empty($action) or $action === 'action')
			$action = 'action'.ucfirst($controllerClass->defaultAction);
		if(!method_exists($controllerClass,$action))
			throw new Exception("404 not found action {$action}");
		$controllerClass->beforeAction();
		call_user_func_array([$controllerClass,$action],$params);
	}
	
	/**
	 * show exception message with controller and action
	 *
	 * @param string $message, error message
	 * @access public static
	 * @return void
	 */
	public static function exceptionHandler($exception)
	{
		$logFile = $exception->getFile().' on line '.$exception->getLine();
		Log::instance()->initialize()->write($logFile,$exception->getMessage());
		if(Config::instance()->getItem('exceptionReporting') === false)
			return;
		$parseString = Router::instance()->parseMyString(Config::instance()->getItem('exceptionHandler'));
		if(!Autoloader::instance()->hasClass($parseString['controllerClass']))
			throw new Exception("404 not found autoloader controller {$output['controller']}");
		$controllerClass = new $parseString['controllerClass']();
		if(!method_exists($controllerClass,$parseString['action']))
			throw new Exception("404 not found exception action ({$parseString['action']}) in controller {$parseString['controller']}");
		$controllerClass->beforeAction();
		$controllerClass->{$parseString['action']}($exception);
		exit();
	}
	
	/**
	 * show error message with controller and action
	 *
	 * @param string $errNo, error mode
	 * @param string $errStr, error message
	 * @param string $errFile, error file
	 * @param integer $errLine, error line
	 * @access public static
	 * @return void
	 */
	public static function errorHandler($errNo,$errStr,$errFile,$errLine)
	{
		$logFile = $errFile.' on line '.$errLine;
		Log::instance()->initialize()->write($logFile,$errStr);
		if(Config::instance()->getItem('errorReporting') === false)
			return;
		$parseString = Router::instance()->parseMyString(Config::instance()->getItem('errorHandler'));
		if(!Autoloader::instance()->hasClass($parseString['controllerClass']))
			throw new Exception("404 not found autoloader controller {$parseString['controller']}");
		$controllerClass = new $parseString['controllerClass']();
		if(!method_exists($controllerClass,$parseString['action']))
			throw new Exception("404 not found error action {$parseString['action']} in controller {$parseString['controller']}");
		$controllerClass->beforeAction();
		$controllerClass->{$parseString['action']}($errNo,$errStr,$errFile,$errLine);
		exit();
	}
	
	/**
	 * get site url from config file
	 *
	 * @access public static
	 * @return string
	 */
	public static function getSiteUrl()
	{
		return Config::instance()->getItem('siteUrl');
	}
	
	/**
	 * include file or add file to classes autoloader
	 *
	 * @param array|string $classesOrPath, autoloader class or file path
	 * @param boolean $include, if true include file
	 * @access public static
	 * @return boolean
	 */
	public static function import($classesOrPath,$include = false,$suffix = '.php')
	{
		if($include)
			return include_once("{$classesOrPath}{$suffix}");
		else
			return Autoloader::instance()->setClasses($classesOrPath);
	}
	
	/**
	 * create valid url 
	 *
	 * @param array $controllerAction, controller and action
	 * @param array $params, url params
	 * @access public static
	 * @return string
	 */
	public static function createUrl($controllerAction,$params = [])
	{
		$output = self::getSiteUrl();
		$output .= Config::instance()->getItem('indexFile').'/';
		$output .= $controllerAction;
		$output .= '/'.implode('/',$params);
		return rtrim($output,'/');
	}
	
	/**
	 * get script generated time
	 *
	 * @access public static
	 * @return integer|float
	 */
	public static function getGeneratedTime()
	{
		return (microtime()-self::$beginTime);
	}
	
	/**
	 * get script memory usage by kb
	 *
	 * @access public static
	 * @return integer|float
	 */
	public static function getMemoryUsage()
	{
		return (memory_get_usage()-self::$beginMemory)/1024;
	}
}