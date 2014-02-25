<?php
namespace framework\core;
use framework\core\exception\ControllerException;
use framework\core\Config;
use framework\helpers\Html;
use framework\helpers\File;
use framework\log\Log;
use framework\request\Request;

/**
 * Base Controller Class
 * abstract class, cannot create a object
 *
 * @use $this->theme for set site theme
 * @use $this->layout for set theme layout
 * @use $this->defaultAction for set default action
 * @use $this->init(); your initialize
 * @use $this->getThemeUrl(); get theme url
 * @use $this->render(); show theme file to user
 *
 * @author		saeed johary <forech@live.com>
 * @since 		1.0
 * @package		core
 * @copyright	(c) 2014 all rights reserved
 */
abstract class Controller
{
	/**
	 * theme folder name
	 *
	 * @access public
	 * @var string
	 */
	public $theme; 
	
	/**
	 * layout file name
	 *
	 * @access public
	 * @var string
	 */
	public $layout = 'layout';
	
	/**
	 * controller default action
	 *
	 * @access public
	 * @var string
	 */
	public $defaultAction = 'index';
	
	/**
	 * class constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->theme = Config::instance()->getItem('theme');
		$this->init();
	}
	
	/**
	 * your initialize
	 *
	 * @access public
	 * @return void
	 */
	public function init()
	{
		// your application configs
	}
	
	/**
	 * run before action
	 *
	 * @access public
	 * @return void
	 */
	public function beforeAction()
	{
		// your code
	}
	
	/**
	 * get theme url with site url
	 *
	 * @param boolean|string $append, add to end of url
	 * @access public
	 * @return string
	 */
	public function getThemeUrl($append = false)
	{
		$output = \Framework::getSiteUrl();
		$output .= 'themes/'.$this->theme.'/';
		if($append) $output .= $append;
		return $output;
	}

      /**
       * refresh page
       *
       * @access public
       * @return void
       */
      public function refresh()
      {
            Request::redirect(Request::getServer('REQUEST_URI'));
      }

	/**
	 * show view to user 
	 *
	 * @param string $view, view path
	 * @param array $vars, variables
	 * @param boolean $terminate, terminate after show
	 * @access protected
	 * @return void
	 */
	public function render($view,$vars = [],$terminate = false)
	{
		$viewPath = BASEPATH."themes/{$this->theme}/views/{$view}.php";
		if(!File::has($viewPath))
			throw new ControllerException("404 view file not found {$view}.php");
		ob_start();
		extract($vars);
		include_once $viewPath;
		$content = ob_get_contents();
		ob_end_clean();
		$layout = BASEPATH."themes/{$this->theme}/views/{$this->layout}.php";
		if(!File::has($layout))
			throw new ControllerException("404 layout file not found {$this->layout}.php");
		include_once $layout;
		if($terminate) exit();
	}
	
	/**
	 * show partial view to user
	 *
	 * @param string $view, view name
	 * @access public
	 * @return void
	 */
	public function renderPartial($view)
	{
		$viewPath = BASEPATH."themes/{$this->theme}/views/{$view}.php";
		if(!File::has($viewPath))
			throw new ControllerException("404 view file not found {$view}.php");
		include_once $viewPath;
	}
}