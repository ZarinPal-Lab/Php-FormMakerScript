<?php
namespace app\models\admin;
use framework\core\Model;
use framework\request\Request;

class FormModel extends Model
{
       public function rules()
       {
              return [
                     'required' => [
                            'formName' => [
                                   'itemValue' => Request::getPost('formName'),
                                   'itemMessage' => 'عنوان فرم را وارد کنید',
                            ],
                            'formDescription' => [
                                   'itemValue' => Request::getPost('formDescription'),
                                   'itemMessage' => 'توضیحات فرم را وارد کنید',
                            ],
                            'formTag' => [
                                   'itemValue' => Request::getPost('formTag'),
                                   'itemMessage' => 'برچسب را وارد کنید',
                            ],
                            'formPriceType' => [
                                   'itemValue' => Request::getPost('formPriceType'),
                                   'itemMessage' => 'نوع فیلد مبلغ را وارد کنید',
                            ],
                            'formPriceValue' => [
                                   'itemValue' => Request::getPost('formPriceValue'),
                                   'itemMessage' => 'مقدار مبلغ را وارد کنید',
                            ],
                            'formStatus' => [
                                   'itemValue' => Request::getPost('formStatus'),
                                   'itemMessage' => 'وضعیت فرم را انتخاب کنید',
                            ],
                     ],
                     'numerical' => [
                            'formStatus' => [
                                   'itemValue' => Request::getPost('formStatus'),
                                   'itemMessage' => 'وضعیت فرم باید عددی باشد',
                            ],
                     ],
              ];
       }
}