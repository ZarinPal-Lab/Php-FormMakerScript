<?php 
namespace app\models;
use framework\core\Model;
use framework\request\Request;

class FormModel extends Model
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
                    'itemMessage' => 'ایمیل نباید خالی باشد',
                ],
                // 'price' => [
                //     'itemValue' => Request::getPost('price'),
                //     'itemMessage' => 'مبلغ نباید خالی باشد',
                // ],
                'gateway' => [
                    'itemValue' => Request::getPost('gateway'),
                    'itemMessage' => 'درگاه پرداخت را انتخاب کنید',
                ],
            ],
            'email' => [
                'email' => [
                    'itemValue' => Request::getPost('email'),
                    'itemMessage' => 'ایمیل وارد شده صحیح نیست',
                ],
            ],
            'numerical' => [
                'mobile' => [
                    'itemValue' => Request::getPost('mobile'),
                    'itemMessage' => 'شماره موبایل باید عددی باشد',
                ],
                'gateway' => [
                    'itemValue' => Request::getPost('gateway'),
                    'itemMessage' => 'درگاه پرداخت صحیح نیست',
                ],
            ],
            'length' => [
                'price' => [
                    'itemValue' => Request::getPost('price'),
                    'min' => 4,
                    'itemMessage' => 'حداقل مبلغ باید 1000 تومان باشد',
                ],
            ],
            'regex' => [
                'mobile' => [
                    'itemValue' => Request::getPost('mobile'),
                    'regex' => '/^09[0-9]{9}$/',
                    'itemMessage' => 'موبایل وارد شده صحیح نیست',
                ],
            ],
        ];
    }
}