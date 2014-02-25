<?php
namespace app\models\admin;
use framework\core\Model;
use framework\request\Request;

class DescModel extends Model
{
       public function rules()
       {
              return [
                     'required' => [
                            'formId' => [
                                   'itemValue' => Request::getPost('formId'),
                                   'itemMessage' => 'فرم را انتخاب کنید',
                            ],
                            'formContent' => [
                                   'itemValue' => Request::getPost('formContent'),
                                   'itemMessage' => 'توضیحات را وارد کنید',
                            ],
                     ],
                     'numerical' => [
                            'formId' => [
                                   'itemValue' => Request::getPost('formId'),
                                   'itemMessage' => 'فرم باید از نوع عددی باشد',
                            ],
                     ],
              ];
       }
}