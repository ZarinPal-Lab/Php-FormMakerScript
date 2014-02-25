<?php
namespace framework\autoloader;
use framework\autoloader\exception\AutoloaderException;
/**
 * Autoloader Class
 *
 * auto load classes with $classes property
 *
 * @use Autoloader::instance(); for a get object of this class
 * @use Autoloader::instance()->setClasses(); for set array class
 * to classes property
 * @use Autoloader::instance()->classExists(); check class exists 
 * in classes property
 *
 * @author 		saeed johary <foreach@live.com>
 * @since 		1.0
 * @package 	autoloader
 * @copyright 	(c) 2014 all rights reserved
 */
class Autoloader
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
	 * autoloader classes
	 * classes map , get file path with
     * this property
	 *
	 * @access protected
	 * @var array
	 */
	protected $classes = [];
		
	/**
	 * initialize autoloader
	 * register autoloader method
	 *
	 * @access public
	 * @return void
	 */
	public function initialize()
	{	
		spl_autoload_register([self::$instance,'registerAutoloader']);
	}
		
	/**
	 * get single object from this class
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
	 * autoload classes with this method
	 *
	 * @param string $class , class name
	 * @access public
	 * @return void
	 */
	public function registerAutoloader($class)
	{
		if($this->hasClass($class))
			include_once $this->getClass($class);
		else
			throw new AutoloaderException("404 not found autoloader class {$class}");
	}
		
	/**
	 * set array classes to classes property
	 *
	 * @param array $classes , classes  
	 * @access public
	 * @return void
	 */
	public function setClasses($classes)
	{
		if(!is_array($classes) or count($classes) <= 0)
			return;
		$this->classes = array_merge($this->classes,$classes);
	}
		
	/**
	 * check class exists in classes property 
	 *
	 * @param string $class, class path
	 * @access public
	 * @return boolean
	 */
	public function hasClass($class)
	{
		if(isset($this->classes[$class]))
			return true;
		return false;
	}
		
	/**
	 * get class from classes property 
	 *
	 * @param string $class, class path
	 * @access public
	 * @return string
	 */
	public function getClass($class)
	{
		return $this->classes[$class];
	}
}