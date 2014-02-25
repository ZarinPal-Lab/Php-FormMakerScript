<?php
namespace framework\helpers;
use framework\helpers\exception\FileException;
use framework\log\Log;
/**
 * File Class
 * file helper for create and read and delete and update file
 *
 * @use File::create(); for a create file
 * @use File::read(); for a read file
 * @use File::delete(); delete file
 * @use File::update(); add line to end of file content
 * @use File::has(); check file exists
 * @use File::getSuffix(); get file suffix (type) by extension
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		helper
 * @copyright	(c) 2013 all rights reserved
 */
class File
{
	/**
	 * create file 
	 *
	 * @param string $file, file path
	 * @param mixed $content, file content
	 * @access public static
	 * @return boolean
	 */
	public static function create($file,$content = '')
	{
		chmod(dirname($file),0755);
		$handle = @fopen($file,'w+');
		if(!$handle)
			throw new FileException("File::create not opening file {$file}");
		flock($handle,LOCK_EX);
		fwrite($handle,$content);
		flock($handle,LOCK_UN);
		fclose($handle);
		return true;
	}
	
	/**
	 * read file
	 *
	 * @param string $file, file path
	 * @access public static
	 * @return mixed
	 */
	public static function read($file)
	{
		if(!self::has($file))
			throw new FileException("File::read 404 not found file {$file}");
		if(!is_readable($file))
			throw new FileException("File::read file not readable {$file} ");
		return @file_get_contents($file);
	}
	
	/**
	 * delete file
	 *
	 * @param string $file, file path
	 * @access public static
	 * @return boolean
	 */
	public static function delete($file)
	{
		if(!self::has($file))
			throw new FileException("File::delete 404 not found file {$file}");
		return @unlink($file);
	}
	
	/**
	 * update file
	 *
	 * @param string $file, file path
	 * @param mixed $content, add to end of file
	 * @access public static
	 * @return boolean
	 */
	public static function update($file,$content)
	{
		if(!self::has($file))
			throw new FileException("File::update 404 file not found {$file}");
		if(!is_writable($file))
			throw new FileException("File::update file not writable {$file}");
		return @file_put_contents($file,$content,FILE_APPEND);
	}
	
	/**
	 * has file
	 *
	 * @param string $file, file path
	 * @access public static
	 * @return boolean
	 */
	public static function has($file)
	{
		if(file_exists($file))
			return true;
		return false;
	}
	
	/**
	 * get file suffix
	 *
	 * @param string $file, file path
	 * @access public static
	 * @return string
	 */
	public static function getSuffix($file)
	{
		$suffix = pathinfo($file,PATHINFO_EXTENSION);
		return strtolower($suffix);
	}
}