<?php
namespace framework\request;
use framework\request\exception\RequestException;
/**
 * Request Class
 * 
 * @use Request::isPostRequest(); check request is $_POST
 * @use Request::isGetRequest(); check request is $_GET
 * @use Request::isAjaxRequest(); check request is ajax
 * @use Request::getPost(); get $_POST indexes
 * @use Request::getQuery(); get $_GET indexes
 * @use Request::getRequestUri(); get uri
 * @use Request::getRemoteAddr(); get user ip
 * @use Request::getServerAddr(); get server ip
 * @use Request::getServer(); get $_SERVER indexes
 */
class Request
{
	/**
	 * check request is post ($_POST)
	 *
	 * @access public static
	 * @return boolean
	 */
	public static function isPostRequest()
	{
		if(self::getServer('REQUEST_METHOD') === 'POST')
			return true;
		return false;
	}
	
	/**
	 * check request is get ($_GET)
	 *
	 * @access public static
	 * @return boolean
	 */
	public static function isGetRequest()
	{
		if(self::getServer('REQUEST_METHOD') === 'GET')
			return true;
		return false;
	}
	
	/**
	 * check request is ajax
	 *
	 * @access public static
	 * @return boolean
	 */
	public static function isAjaxRequest()
	{
		if(self::getServer('HTTP_X_REQUESTED_WITH') === 'xmlhttprequest')
			return true;
		return false;
	}
	
	/**
	 * has index in $_POST
	 *
	 * @param string $name, index name
	 * @access public
	 * @return boolean
	 */
	public static function isPost($name)
	{
		if(isset($_POST[$name]))
			return true;
		return false;
	}
	
	/**
	 * get index of $_POST
	 *
	 * @param string $name, index name
	 * @access public
	 * @return mixed
	 */
	public static function getPost($name)
	{
		if(self::isPost($name))
			return $_POST[$name];
		return false;
	}

	/**
	 * has index in $_GET
	 *
	 * @param string $name, index name
	 * @access public
	 * @return boolean
	 */
	public static function isQuery($name)
	{
		if(isset($_GET[$name]))
			return true;
		return false;
	}
	
	/**
	 * get index of $_GET
	 *
	 * @param string $name, index name
	 * @access public static
	 * @return mixed
	 */
	public static function getQuery($name)
	{
		if(self::isQuery($name))
			return $_GET[$name];
		return false;
	}
	
	/**
	 * get request uri
	 *
	 * @access public static
	 * @return string
	 */
	public static function getRequestUri()
	{
		return self::getServer('REQUEST_URI');
	}
	
	/**
	 * get user ip address
	 *
	 * @access public static
	 * @return string
	 */
	public static function getRemoteAddr()
	{
		return self::getServer('REMOTE_ADDR');
	}
	
	/**
	 * get server ip address
	 *
	 * @access public static
	 * @return string
	 */
	public static function getServerAddr()
	{
		return self::getServer('SERVER_ADDR');
	}
	
	/**
	 * get $_SERVER indexes
	 *
	 * @param string $index, index name
	 * @access public static
	 * @return mixed
	 */
	public static function getServer($index)
	{
		if(isset($_SERVER[$index]))
			return $_SERVER[$index];
		return false;
	}

      /**
       * redirect to url
       *
       * @param string $url, url
       * @param integer $code, status code
       * @access public static
       * @return void
       */
      public static function redirect($url,$code = 302)
      {
            header("Location:{$url}",true,$code);
            exit;
      }
}