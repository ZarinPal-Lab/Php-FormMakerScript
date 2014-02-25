<?php
namespace app\models;
use framework\core\Model;
use framework\request\Request;

class LoginModel extends Model
{
	public function rules()
	{		
		return [
			'required' => [
				'userName' => [
					'itemValue' => Request::getPost('userName'),
					'itemMessage' => 'نام کاربری را وارد کنید',
				],
				'password' => [
					'itemValue' => Request::getPost('password'),
					'itemMessage' => 'کلمه عبور را وارد کنید',
				],
				'captcha' => [
					'itemValue' => Request::getPost('captcha'),
					'itemMessage' => 'کد امنیتی را وارد کنید',
				],
			],
			'captcha' => [
				'captcha' => [
					'itemInput' => Request::getPost('captcha'),
					'itemMessage' => 'کد امنیتی وارد شده صحیح نیست',
				],
			],
		];
	}
}