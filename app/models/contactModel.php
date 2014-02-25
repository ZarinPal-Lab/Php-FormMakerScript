<?php
namespace app\models;
use framework\core\Model;
use framework\request\Request;

class ContactModel extends Model
{
	public function rules()
	{
		return [
			'required' => [
				'name' => [
					'itemValue' => Request::getPost('name'),
					'itemMessage' => 'نام و نام خانوادگی نباید خالی باشد',
				],
				'email' => [
					'itemValue' => Request::getPost('email'),
					'itemMessage' => 'ایمیل خود را وارد کنید',
				],
				'subject' => [
					'itemValue' => Request::getPost('subject'),
					'itemMessage' => 'موضوع را وارد کنید',
				],
				'content' => [
					'itemValue' => Request::getPost('content'),
					'itemMessage' => 'توضیحات نمیتواند خالی باشد',
				],
				'captcha' => [
					'itemValue' => Request::getPost('captcha'),
					'itemMessage' => 'کد امنیتی را وارد کنید',
				],
			],
			'email' => [
				'email' => [
					'itemValue' => Request::getPost('email'),
					'itemMessage' => 'ایمیل وارد شده صحیح نیست',	
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