<?php
namespace app\components;
use framework\session\Session;
use framework\database\Database;
use framework\request\Request;

/**
 * Admin login class
 *
 * @use Admin::login(); login user
 * @use Admin::logout(); logout user
 * @use Admin::getUserName(); get logged username
 *
 * @author		saeed johari <foreach@live.com>
 * @package		component
 * @since		1.0
 * @copyright	(c) 2014 all rights reserved
 */
class Admin
{
	/**
	 * save user name
	 *
	 * @access private
	 * @var string
	 */
	private $userName;
	
	/**
	 * login user
	 *
	 * @param string $username, user name
	 * @param string $password, user password
	 * @access public
	 * @return boolean
	 */
	public function login($username,$password)
	{
		Session::instance()->open();
		
		$user = Database::queryBuilder()
			->select('*')
			->from('user')
			->where('userName = :userName')
			->where('userPassword = :password','AND')
			->getRow([':userName' => $username,':password' => $password]);
			
		if($user) {
			$this->userName = $user->userName;
			Session::instance()->set('user',$this->userName);
			Session::instance()->set('hash',$this->generateHash());
			return true;
		}
		return false;
	}
	
	/**
	 * logout user
	 *
	 * @access public
	 * @return void
	 */
	public function logout()
	{
		Session::instance()->open();
		
		Session::instance()->delete('user');
		Session::instance()->delete('hash');
		Session::instance()->destroy();
	}
	
	/**
	 * get logged username
	 *
	 * @access public
	 * @return string
	 */
	public function getUserName()
	{
		return $this->userName;
	}
	
	/**
	 * check user is logged
	 *
	 * @access public
	 * @return boolean
	 */
	public function getIsLogged()
	{
		Session::instance()->open();
		
		if(!Session::instance()->get('user')) return false;
		$this->userName = Session::instance()->get('user');
		$hash = $this->generateHash();
		if($hash === Session::instance()->get('hash'))
			return true;
		$this->logout();
		return false;
	}

	/**
	 * generate security hash
	 *
	 * @access private
	 * @return string
	 */
	private function generateHash()
	{
		$data = $this->userName.Request::getRemoteAddr().Request::getServer('HTTP_USER_AGENT');
		$data = hash('sha1',$data);
		return $data;
	}
}