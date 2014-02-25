<?php
namespace app\models\admin;
use framework\core\Model;
use framework\request\Request;

class OptionModel extends Model
{
       public function rules()
       {
              return [
                     'required' => [
                            'title' => [
                                   'itemValue' => Request::getPost('title'),
                                   'itemMessage' => 'عنوان را وارد کنید',
                            ],
                            'theme' => [
                                   'itemValue' => Request::getPost('theme'),
                                   'itemMessage' => 'قالب را وارد کنید',
                            ],
                            'defaultForm' => [
                                   'itemValue' => Request::getPost('defaultForm'),
                                   'itemMessage' => 'فرم پیشفرض را انتخاب کنید',
                            ],
                            'perPage' => [
                                   'itemValue' => Request::getPost('perPage'),
                                   'itemMessage' => 'تعداد آیتم ها در هر صفحه را وارد کنید',
                            ],
                     ],
                     'numerical' => [
                            'defaultForm' => [
                                   'itemValue' => Request::getPost('defaultForm'),
                                   'itemMessage' => 'فرم پیشفرض باید عددی باشد',
                            ],
                            'perPage' => [
                                   'itemValue' => Request::getPost('perPage'),
                                   'itemMessage' => 'تعداد آیتم ها در هر صفحه باید عددی باشد',
                            ],
                            'smtpPort' => [
                                   'itemValue' => Request::getPost('smtpPort'),
                                   'itemMessage' => 'پورت smtp باید عددی باشد',
                            ],
                            'adminMobile' => [
                                   'itemValue' => Request::getPost('adminMobile'),
                                   'itemMessage' => 'موبایل باید عددی باشد',
                            ],
                     ],
                     'email' => [
                            'adminMail' => [
                                   'itemValue' => Request::getPost('adminMail'),
                                   'itemMessage' => 'ایمیل وارد شده صحیح نیست',
                            ],
                     ],
                     'regex' => [
                            'adminMobile' => [
                                   'itemValue' => Request::getPost('adminMobile'),
                                   'regex' => '/^09([0-9]){9}$/',
                                   'itemMessage' => 'موبایل وارد شده صحیح نیست',
                            ],
                     ],
              ];
       }
}