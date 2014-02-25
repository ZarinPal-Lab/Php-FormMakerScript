<?php
namespace framework\security;
use framework\security\exception\CsrfException;
use framework\session\Session;
use framework\request\Request;
/**
 * Csrf Class
 * security class
 *
 * @use Csrf::generate(); generate csrf code
 * @use Csrf::validate(); validate csrf code
 *
 * @author		saeed johary <foreach@live.com>
 * @since		1.0
 * @package		security
 * @copyright	(c) 2014 all rights reserved
 */
class Csrf
{
	/**
	 * generate csrf code and set to session
	 *
	 * @param string $key, csrf session key
	 * @access public static
	 * @return string
	 */
	public static function generate($key = 'csrf')
	{
		$token = md5(rand());
		Session::instance()->open();
		Session::instance()->set($key,$token);
		return $token;
	}

	/**
	 * validate csrf session with input post
	 *
	 * @param string $key, csrf session key
	 * @param string $inputName, csrf input name
	 * @access public static
	 * @return boolean
	 */
	public static function validate($key = 'csrf',$inputName = 'csrf')
	{
		Session::instance()->open();

		if((string)Session::instance()->get($key) == Request::getPost($inputName))
			return true;
              else
			throw new CsrfException('Csrf cannot be verified');
	}
}