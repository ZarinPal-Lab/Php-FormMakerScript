<?php
namespace framework\session;
use framework\session\exception\SessionException;
use framework\helpers\ArrayHelper;
/**
 * Session Class
 *
 * @use Session::instance(); get singleton object of this class
 * @use Session::instance()->flash; set flash message name
 * @use Session::instance()->set(); set session key
 * @use Session::instance()->get(); get session key
 * @use Session::instance()->open(); start session
 * @use Session::instance()->delete(); delete session key
 * @use Session::instance()->getId(); get session id
 * @use Session::instance()->setName(); set session name
 * @use Session::instance()->destroy(); destroy sessions
 * @use Session::instance()->setSavePath(); set session save path
 * @use Session::instance()->writeClose(); close session writing
 * @use Session::instance()->setFlash(); set flash message
 * @use Session::instance()->getFlash(); get flash message
 * @use Session::instance()->hasFlash(); check flash message 
 * @use Session::instance()->getFlashes(); get all flash messages
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		session
 * @copyright	(c) 2014 all rights reserved
 */
class Session
{
	/**
	 * singleton object
	 *
	 * @access private static
	 * @var object
	 */
	private static $instance = null;
	
	/**
	 * flash messages key
	 *
	 * @access public
	 * @var string
	 */
	public $flash = '__flash';
	
	/**
	 * get one object from this class
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
	 * set session key
	 *
	 * @param string $key, session key
	 * @param mixed $value, session value
	 * @access public
	 * @return void
	 */
	public function set($key,$value)
	{
		if(!$this->getId())
			return false;
		ArrayHelper::set($_SESSION,$key,$value);
	}
	
	/**
	 * get session key
	 *
	 * @param string $key, session key
	 * @access public
	 * @return mixed
	 */
	public function get($key)
	{
		if(!$this->getId())
			return false;
		return ArrayHelper::get($_SESSION,$key);
	}

      /**
       * check session key
       *
       * @param string $key, session key
       * @access public
       * @return mixed
       */
      public function has($key)
      {
            if(!$this->getId())
                  return false;
            if(ArrayHelper::get($_SESSION,$key))
                  return true;
            return false;
      }

	/**
	 * start session
	 *
	 * @access public
	 * @return void
	 */
	public function open($regenerate = false)
	{
		if(!$this->getId())
			session_start();
              if($regenerate)
                     $this->regenerateId();
              return self::$instance;
	}

       /**
	 * regenerate session id
	 *
	 * @access public
	 * @return void
	 */
       public function regenerateId()
       {
              if($this->getId())
                     session_regenerate_id(true);
       }
	
	/**
	 * get current session id
	 *
	 * @access public
	 * @return boolean|string
	 */
	public function getId()
	{
		if(session_id())
			return session_id();
		return false;
	}

       /**
	 * set cookie httponly
        * ( cookie cannot read or change with javascript...)
	 *
	 * @access public
	 * @return boolean|string
	 */
       public function setHttpOnly($value = 1)
       {
              ini_set('session.cookie_httponly',$value);
       }
	
	/**
	 * delete session key
	 *
	 * @param string $key, session key
	 * @access public
	 * @return void
	 */
	public function delete($key)
	{
		if(!$this->getId())
			return false;
		ArrayHelper::delete($_SESSION,$key);
	}
	
	/**
	 * destroy all sessions
	 *
	 * @access public
	 * @return boolean|void
	 */
	public function destroy()
	{
		if(!$this->getId())
			return false;
		session_unset();
		session_destroy();
	}
	
	/**
	 * set session name
	 *
	 * @param string $name, session name
	 * @access public
	 * @return void
	 */
	public function setName($name)
	{
		if(!$this->getId())
			session_name($name);
	}
	
	/**
	 * set flash message
	 *
	 * @param string $key, session key
	 * @param string $value, message
	 * @access public
	 * @return void
	 */	
	public function setFlash($key,$value = null)
	{
		$this->open();
		ArrayHelper::set($_SESSION,"{$this->flash}.{$key}",$value);
	}
	
	/**
	 * check flash message
	 *
	 * @param string $key, session key
	 * @access public
	 * @return boolean
	 */
	public function hasFlash($key)
	{
		$this->open();
		if($this->getFlash($key,false))
			return true;
		return false;
	}
	
	/**
	 * get flash message
	 *
	 * @param string $key, session key
	 * @param boolean $delete, delete key after get
	 * @access public
	 * @return mixed
	 */
	public function getFlash($key,$delete = true)
	{
		$this->open();
		$get = ArrayHelper::get($_SESSION,"{$this->flash}.{$key}");
		if($delete)
			ArrayHelper::delete($_SESSION,"{$this->flash}.{$key}");
		return $get;
	}
	
	/**
	 * get all flash messages
	 *
	 * @param boolean $delete, delete key after get
	 * @access public
	 * @return mixed
	 */	
	public function getFlashes($delete = true)
	{
		$this->open();
		$get = ArrayHelper::get($_SESSION,$this->flash);
		if($delete)
			ArrayHelper::delete($_SESSION,$this->flash);
		return (($get) ? $get : []);
	}
		
	/**
	 * session write close
	 *
	 * @access public
	 * @return void
	 */	
	public function writeClose()
	{
		if($this->getId())
			session_write_close();
	}
	
	/**
	 * session set save path
	 *
	 * @param string $path, save path
	 * @access public
	 * @return void
	 */
	public function setSavePath($path)
	{
		if(!$this->getId())
			session.save_path($path);
	}
}