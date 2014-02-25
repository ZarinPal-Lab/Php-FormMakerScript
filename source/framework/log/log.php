<?php
namespace framework\log;
use framework\log\exception\LogException;
use framework\core\Config;
use framework\helpers\File;
use framework\request\Request;
/**
 * Log Class
 *
 * log for application information
 *
 * @use Log::instance()->write(); write message to file 
 * @use Log::instance()->hasFile(); check file exists
 * @use Log::instance()->setFile(); set filename to file property
 * @use Log::instance()->setPattern(); set log save pattern
 * @use Log::instance()->clear(); clear file content
 * @use Log::instance()->createFile(); create log file
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		log
 * @copyright	(c) 2014 all rights reserved
 */
class Log
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
	 * file for save log message
	 *
	 * @access protected
	 * @var string
	 */
	protected $file;
	
	/**
	 * pattern for log message
	 *
	 * @access protected
	 * @var string
	 */
	protected $pattern = '{file} | {date} | {message}';
	
	/**
	 * initialize log class
	 * set default log file
	 * 
	 * @return void
	 */
	public function initialize()
	{
		$this->file = LOGPATH.'application.log';
		return self::$instance;
	}
	
	/**
	 * get one instance of this class
	 *
	 * @access pulic static
	 * @return object
	 */
	public static function instance()
	{
		if(self::$instance === null)
			self::$instance = new self;
		return self::$instance;
	}
	
	/**
	 * write message to log file
	 *
	 * @param string $file , file name
	 * @param string $message, log message
	 * @access public
	 * @return void
	 */
	public function write($file,$message)
	{
		$log = Config::instance()->getItem('log');
		if(!$log) return;
		if(!File::has($this->file))
			$this->createFile();
		$toLog = $this->getMessage($file,$message);
		File::update($this->file,$toLog);
	}
	
	/**
	 * set log file with defined LOGPATH
	 *
	 * @param sring $file, file name
	 * @access public
	 * @return object
	 */
	public function setFile($file)
	{
		if(!$file)
			throw new LogException('Log::setFile argument cannot be empty');
		$this->file = LOGPATH.$file;
		return $this;
	}
	
	/**
	 * set pattern for log message
	 *
	 * @param string $pattern, message pattern
	 * @access public
	 * @return object
	 */
	public function setPattern($pattern)
	{
		if(!$pattern)
			throw new LogException('Log::setPattern argument cannot be empty');
		$this->pattern = $pattern;
		return $this;
	}
	
	/**
	 * (delete|create) log file
	 *
	 * @access public
	 * @return void
	 */
	public function clear()
	{
		if(File::has($this->file))
			$this->createFile();
	}
	
	/**
	 * just create log file 
	 *
	 * @access public
	 * @return void
	 */
	public function createFile()
	{
		chmod(LOGPATH,0755);
		$handle = fopen($this->file,'w+');
		fclose($handle);
		return true;
	}
	
	/**
	 * parse log message
	 *
	 * @param string $file, file name
	 * @param string $message , log message
	 * @access protected
	 * @return string
	 */
	protected function getMessage($file,$message)
	{
		$find = ['{file}','{message}','{date}'];
		$replace = [$file,$message,date('Y/m/d - H:i:s',time())];
		$output = str_replace($find,$replace,$this->pattern).PHP_EOL;
		$output .= 'Request Uri => '.Request::getRequestUri().PHP_EOL;
		$output .= 'User ip => '.Request::getRemoteAddr().PHP_EOL;
		$output .= '------------------------------------------------------------'.PHP_EOL;
		return $output;
	}
}