<?php
namespace app\models\admin;
use framework\core\Model;
use framework\request\Request;

class UserModel extends Model
{
       public function rules()
       {
              return [
                     'required' => [
                            'userName' => [
                                   'itemValue' => Request::getPost('userName'),
                                   'itemMessage' => 'نام کاربری را وارد کنید',
                            ],
                            'email' => [
                                   'itemValue' => Request::getPost('email'),
                                   'itemMessage' => 'ایمیل را وارد کنید',
                            ],
                            'password' => [
                                   'itemValue' => Request::getPost('password'),
                                   'itemMessage' => 'کلمه عبور را وارد کنید',
                            ],
                     ],
                     'email' => [
                            'email' => [
                                   'itemValue' => Request::getPost('email'),
                                   'itemMessage' => 'ایمیل وارد شده صحیح نیست',
                            ],
                     ],
              ];
       }
}